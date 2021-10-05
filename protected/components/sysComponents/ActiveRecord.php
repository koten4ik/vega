<?php

class ActiveRecord extends CActiveRecord
{
    const RESIZE = 1;
    const CROP = 2;
    const RESIZE_AND_FILL = 3;
    const RESIZE_AND_CROP = 4;
    public $files_config = array();
    private static $upFlName = array(); // fix for multi call CUploadedFile(name)
    public $no_log = false;

    public $c_time = 0;
    public $u_time = 0;
    public $u_time_adm = 0;
    public $u_time_freeze = false;
    public $user_id = 0;
    public $position = 0;
    public $published = 0;

    public $mode_image_resize = false;

    // seo
    public $title;
    public $metadata = '';
    public $metaTitle, $metaDesc, $metaKeys;
    public $metaTitle_l2, $metaDesc_l2, $metaKeys_l2;
    public $metaTitle_l3, $metaDesc_l3, $metaKeys_l3;

    public function init()
    {

    }

    public function rules()
    {
        $files_rules = array();
        foreach ($this->files_config as $name => $data) {
            //if($data['rule']['types'] != '')
            {
                $files_rules[] = array($name . '_tmp', 'safe');
                // загрузка сейчас только через аякс,
                // правила размера и типа передается в AjaxUploadAction
                // правило file в 1.1.14 не работает
                //$files_rules[] = array($name.'_tmp', 'file', 'types'=>$data['rule']['types'],
                //    'maxSize'=>$data['rule']['maxSize']*1024*1024, 'allowEmpty'=>true);
                //$files_rules[] = array($name.'_tmp', 'strExtentionValidator', 'types'=>$data['rule']['types']);
            }
            if ($data['rule']['required']) {
                $files_rules[] = array($name . '_tmp', 'required', 'on' => $data['rule']['scenario']);
                $files_rules[] = array($name . '_tmp', 'compare', 'operator' => '!=',
                    'compareValue' => 'del_curr_image', 'on' => $data['rule']['scenario'],
                    'message' => Yii::t('yii', '{attribute} cannot be blank.')
                );
            }
        }

        $files_rules[] = array('metaDesc, metaKeys, metaTitle,
                                metaDesc_l2, metaKeys_l2, metaTitle_l2,
                                metaDesc_l3, metaKeys_l3, metaTitle_l3,
                                published, position', 'safe');

        return $files_rules;
    }

    protected function afterFind()
    {
        parent::afterFind();

        // multiLang
        if (Y::app()->params['cfgName'] == 'frontend'
            && Y::app()->params['multiLang'] == true)
            foreach ($this->getMetaData()->columns as $column) {
                $name = $column->name;
                if ($this->hasAttribute($name . Y::langSfx())) {
                    $name1 = $name . Y::langSfx();
                    if ($this->$name1 != '' && $this->$name1 != null)
                        $this->$name = $this->$name1;
                }
            }

        // ------------------ seo -----------------
        $mdata = explode('&', $this->metadata);
        $arr = explode('~', $mdata[0]);

        $this->metaDesc = $arr[0];
        $this->metaKeys = $arr[1];
        $this->metaTitle = $arr[2];
        $arr = explode('~', $mdata[1]);
        $this->metaDesc_l2 = $arr[0];
        $this->metaKeys_l2 = $arr[1];
        $this->metaTitle_l2 = $arr[2];
        $arr = explode('~', $mdata[2]);
        $this->metaDesc_l3 = $arr[0];
        $this->metaKeys_l3 = $arr[1];
        $this->metaTitle_l3 = $arr[2];

        if (!$this->metaTitle && $this->title) $this->metaTitle = $this->title;
        if (isset($this->title_l2) && !$this->metaTitle_l2 && $this->title_l2) $this->metaTitle_l2 = $this->title_l2;
        if (isset($this->title_l3) && !$this->metaTitle_l3 && $this->title_l3) $this->metaTitle_l3 = $this->title_l3;

        if (Y::params('cfgName') == 'frontend') {
            $this->metaTitle = $this->{'metaTitle' . Y::langSfx()};
            $this->metaKeys = $this->{'metaKeys' . Y::langSfx()};
            $this->metaDesc = $this->{'metaDesc' . Y::langSfx()};
        }
    }

    protected function beforeSave()
    {
        $user = User::getUser();
        if ($user && $user->role == User::ROLE_VISOR) {
            $this->addError('id', 'Нет доступа к сохранению');
            return false;
        }

        if ($this->isNewRecord) {
            if ($this->c_time == 0)
                $this->c_time = time();
            if ($this->user_id == 0)
                $this->user_id = Y::user_id();
            if ($this->position == 0) {
                $arr = Y::sqlQueryAll('select * from ' . $this->tableName() . ' order by id desc limit 1');
                $this->position = $arr[0]['id'] + 1;
            }
        } else {
            if ($this->u_time_freeze == false)
                if (User::isModerator()) $this->u_time_adm = time();
                else $this->u_time = time();
        }

        // seo
        $this->metadata = $this->metaDesc . '~' . $this->metaKeys . '~' . $this->metaTitle . '&';
        $this->metadata .= $this->metaDesc_l2 . '~' . $this->metaKeys_l2 . '~' . $this->metaTitle_l2 . '&';
        $this->metadata .= $this->metaDesc_l3 . '~' . $this->metaKeys_l3 . '~' . $this->metaTitle_l3;

        return parent::beforeSave();
    }

    protected function afterValidate()
    {
        if (count($this->errors) == 0)
            foreach ($this->files_config as $name => $data)
                $this->getFile($name, $data);

        return parent::afterValidate();
    }

    protected function beforeDelete()
    {
        $user = User::getUser();
        if ($user && $user->role == User::ROLE_VISOR) {
            //$this->addError('id','Нет доступа к удалению');
            return false;
        }

        $success = parent::beforeDelete();

        foreach ($this->files_config as $name => $data)
            $this->delFile($name, $data);

        if ($success) $this->arLog();

        return $success;
    }

    protected function afterSave()
    {
        parent::afterSave();
        $this->arLog();
    }

    private function arLog()
    {
        $ar_log = new ArLog();
        if (!$this->no_log)
            Y::sqlInsert($ar_log->tableName(), array(
                'c_time' => time(),
                'model_name' => get_class($this),
                'model_id' => $this->id,
                'user_id' => Y::user_id(),
                'controller_id' => Y::app()->controller->id,
                'action_id' => Y::app()->controller->action->id,
                'module_id' => Y::app()->controller->module->id,
            ));
    }

    // старая реализяция сохраненния грида
    public function StateProcess($grid_name)
    {
        /*if(isset($_GET['ajax'])) Yii::app()->user->setState($grid_name, $_GET);
        else{  $state = Yii::app()->user->getState($grid_name);
            if($state){ $_GET = CMap::mergeArray($_GET, $state);  unset($_GET['ajax']);
                $this->attributes = $state[get_class($this)];   }
        }*/
    }

    public function getFile($field, $file_data)
    {
        $exist = false;
        if ($this->mode_image_resize) $exist = true;
        $root = $_SERVER['DOCUMENT_ROOT'];
        $path = $root . $file_data['path'];
        $field_tmp = $field . '_tmp';

        $time_dir_y = date('Y', time()) . '/';
        $time_dir_m = date('m', time()) . '/';
        $time_dir = $file_data['time_dir'] ? $time_dir_y . $time_dir_m : '';

        // ================== make dirs
        if ($this->$field_tmp) {
            if (!is_dir($path)) mkdir($path);
            if ($file_data['tmbs'])
                foreach ($file_data['tmbs'] as $tmb)
                    if (!is_dir($path . $tmb['name'])) mkdir($path . $tmb['name']);

            if ($file_data['time_dir'] && !is_dir($path . $time_dir_y)) {
                mkdir($path . $time_dir_y);
                foreach ($file_data['tmbs'] as $tmb) mkdir($path . $tmb['name'] . '/' . $time_dir_y);
            }
            if ($file_data['time_dir'] && !is_dir($path . $time_dir_y . $time_dir_m)) {
                mkdir($path . $time_dir_y . $time_dir_m);
                foreach ($file_data['tmbs'] as $tmb) mkdir($path . $tmb['name'] . '/' . $time_dir_y . $time_dir_m);
            }
        }
        // ============ from local --- обычный аплоад заменен на аякс
        /*$fi1=CUploadedFile::getInstance($this,$field_tmp);
        if($fi1 != null && !in_array($fi1->name,self::$upFlName))
        {
            $exist = true;
            self::$upFlName[] = $fi1->name;
            $this->delFile($field,$file_data);
            $this->$field = $time_dir.$this->genFileName($fi1->name,$file_data['save_fname']);
            $fi1->saveAs($path.$this->$field);
            $this->delTmpFile($field_tmp);
        }*/
        // ============ from server
        if ($this->$field_tmp && $this->$field_tmp != 'del_curr_image'
            && $this->$field_tmp != 'filled' && $this->mode_image_resize == false) {
            $this->delFile($field, $file_data);

            // if image on other server
            $external = strpos($this->$field_tmp, "http") === 0;

            $this->$field = $time_dir . $this->genFileName($this->$field_tmp, $file_data['save_fname'], $external);

            copy(($external ? '' : $root) . $this->$field_tmp, $path . $this->$field);
            if (is_file($path . $this->$field)) $exist = true;
            else $this->$field = '';

            if (strpos($this->$field_tmp, "cke_images") === false)
                $this->delTmpFile($field_tmp);
            $this->$field_tmp = 'filled';

            $this->afterFileLoaded($field);
        }
        // =========== delete
        if ($this->$field_tmp == 'del_curr_image' && $this->mode_image_resize == false) {
            $this->delFile($field, $file_data);
            $this->$field = '';
        }
        // =========== generate thumbs
        if ($exist && $file_data['type'] == 'image' && $file_data['tmbs'])
            foreach ($file_data['tmbs'] as $tmb) {
                if (!$tmb) continue;
                $thumb = Yii::app()->thumb;
                $thumb->thumbsDirectory = $path . $tmb['name'] . '/' . $time_dir;
                $thumb->load($path . $this->$field);

                switch ($tmb['param']) {
                    case self::RESIZE:
                        $thumb->resize($tmb['w'], $tmb['h']);
                        break;

                    case self::RESIZE_AND_CROP:
                        $dims = $thumb->image->getCurrentDimensions();
                        $tmb_coeff = $tmb['w'] / $tmb['h'];
                        $dims_coeff = $dims['width'] / $dims['height'];
                        if ($tmb_coeff <= $dims_coeff) {
                            $thumb->resize($tmb['h'] * 10, $tmb['h']);
                            $thumb->cropFromCenter($tmb['w'], $tmb['h']);
                        } else {
                            $thumb->resize($tmb['w'], $tmb['w'] * 10);
                            $thumb->crop(0, 0, $tmb['w'], $tmb['h']);
                        }
                        break;

                    case self::CROP:
                        $c = $thumb->image->getCurrentDimensions();
                        $c = $c['width'] > $c['height'] ? $c['width'] / $c['height'] :
                            $c['height'] / $c['width'];
                        $thumb->resize($tmb['w'] * $c, $tmb['h'] * $c);
                        $thumb->cropFromCenter($tmb['w'], $tmb['h']);
                        break;

                    default:
                        $thumb->resize($tmb['w'], $tmb['h']);
                }
                $temp = explode("/", $this->$field);
                $thumb->save(end($temp));
            }
    }

    private function genFileName($name, $skip, $external = 0)
    {
        $ext_sfx = $external ? '_ext_img' : '';
        if ($skip) {
            $temp = explode("/", $name);
            $id = $this->id ? $this->id : rand(100, 999);
            return ($id) . $ext_sfx . '_' . end($temp);
        }
        $temp = explode(".", $name);
        return $new_name = str_replace('.', '', microtime(true)) . $ext_sfx . '.' . end($temp);
    }

    public function delFile($field, $file_data)
    {
        if ($this->$field == '') return;

        $path = $_SERVER['DOCUMENT_ROOT'] . $file_data['path'];
        if (file_exists($path . $this->$field))
            unlink($path . $this->$field);

        if ($file_data['type'] == 'image' && $file_data['tmbs'])
            foreach ($file_data['tmbs'] as $tmb) {
                if (!$tmb) continue;
                if (file_exists($path . $tmb['name'] . '/' . $this->$field))
                    unlink($path . $tmb['name'] . '/' . $this->$field);
            }
    }

    public function delTmpFile($field_tmp)
    {
        if ($this->$field_tmp == '') return;
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $this->$field_tmp))
            unlink($_SERVER['DOCUMENT_ROOT'] . $this->$field_tmp);
    }

    public function strExtentionValidator($attribute, $params)
    {
        if ($this->$attribute != '' && $this->$attribute != 'del_curr_image'
            && $this->$attribute != 'filled') {
            /*if($params['types']==''){
                $this->addError($attribute,Y::t('Not set extention list'));
                return;
            }*/
            if (!in_array(strtolower(end(explode(".", $this->$attribute))), explode(',', $params['types']))) {
                $message = Yii::t('yii', 'The file "{file}" cannot be uploaded. Only files with these extensions are allowed: {extensions}.',
                    array('{file}' => end(explode("/", $this->$attribute)), '{extensions}' => $params['types']));
                $this->addError($attribute, $message);
            }
        }
    }

    protected function afterFileLoaded($field = null)
    {
    }

    public function fileUrl($field, $tmb = 0)
    {
        $field_data = $this->files_config[$field];
        $tmb_p = $field_data['tmbs'][$tmb - 1]['name'] . '/';
        $path = $field_data['url'] ? $field_data['url'] : $field_data['path'];
        $no_file = $field_data['type'] == 'image' ? Controller::noImg : '';

        $rezult = null;
        if ($rezult === null && !$this->$field) $rezult = $no_file;
        if ($rezult === null && strpos($this->$field, "/") > -1) $rezult = $this->$field;
        if ($rezult === null) $rezult = $path . ($tmb > 0 ? $tmb_p : '') . $this->$field;

        return $rezult;
    }

    public static function textCriteria($text, $field)
    {
        $t_cr = new CDbCriteria();
        $t_cr->addSearchCondition($field, $text, true);
        /*$text = explode(' ', $text);
        foreach($text as $i=>$key){
            if($i > 5 || iconv_strlen($key,'UTF-8')<(3) ) continue;
            $t_cr->compare($field, $key,true, 'and');
        }*/
        return $t_cr;
    }

    function getPrewText($text, $maxchar = 200)
    {
        if (mb_strlen($text, 'UTF-8') > $maxchar)
            $text = mb_substr($text, 0, mb_strpos($text, " ", $maxchar, 'UTF-8'), 'UTF-8') . '...';

        return $text;
    }

    function limit_words($string, $word_limit)
    {
        $words = explode(" ", $string);
        return implode(" ", array_splice($words, 0, $word_limit));
    }

    /*const CONST1 = 1;
    const CONST2 = 2;
    public static function fieldList($val = null){
        $arr =  array(
            self::CONST1=>'title1',
            self::CONST2=>'title2',
        );
        if($val !== null) return $arr[$val];
        else return $arr;
    }*/
}