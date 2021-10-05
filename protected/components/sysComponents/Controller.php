<?php

class Controller extends CController
{
    const noImg = '/assets_static/images/no_img.jpg';
    static public $commonAssetsUrls;
    static private $script_cnt = 0;

    public $loadScripts = true;
    public $cs;
    public $title = '';

    public $menu_id = null;
    public $smenu_id = null;
    public $menu = array();
    public $breadcrumbs = array();
    public $config;

    public $modelName = '';
    public $modelDataName = '';
    public $modelScenario = '';
    public $catId; // for categorized itemsList
    public $viewDir;

    public function actions()
    {
        return array(
            'elfinderconnector' => 'ext.elFinder-2.actions.elfinderConnector',
            'ajaxupload' => 'ext.AjaxUpload.AjaxUploadAction',
            'cropper' => 'ext.AjaxUpload.CropperAction',
            'ckeupload' => 'ext.AjaxUpload.CKEUploadAction'
        );
    }

    public function init()
    {
        //sleep(1); // эмуляция задержки сети

        parent::init();


        $this->config = Config::Get();

        Yii::app()->name = $this->config->{'site_name' . Y::langSfx()};
        $this->pageTitle = Yii::app()->name;
        $this->setSEO(array(
            'title' => $this->config->{'site_name' . Y::langSfx()},
            'descr' => $this->config->{'meta_desc' . Y::langSfx()},
            'keys' => $this->config->{'meta_keys' . Y::langSfx()},
        ));


        $this->cs = Yii::app()->clientScript;
        self::$commonAssetsUrls = $this->PublishCommonAssets();

        // ! добавить проверку mime-типа
        if (Yii::app()->request->isAjaxRequest) {
            $this->loadScripts = false;
        }

        if ($this->loadScripts) {

            $this->cs->registerScriptFile($this->cs->coreScriptUrl . '/jquery.cookie.js');
            $this->cs->registerScriptFile(Y::app()->baseUrl . '/assets_static/js/jquery.ui.datepicker-ru.js');
            $this->cs->registerScriptFile(Y::app()->baseUrl . '/assets_static/js/jquery.maskedinput-1.3.js');
        }

        if (Y::user_id() > 0)
            Y::sqlUpdate('tbl_user', array('last_visit_time' => time()), Y::user_id());
    }

    protected function PublishCommonAssets($forceCopy = false)
    {
        $assets = array();
        //$assets['dynaTree'] = Y::publish(Y::path('ext.dynaTree.assets'), $forceCopy);
        //$assets['elRTE'] = Y::publish(Y::path('ext.elRTE.assets'), $forceCopy);
        //$assets['elFinder-2'] = Y::publish(Y::path('ext.elFinder-2.assets'), $forceCopy);
        return $assets;
    }

    protected function beforeRender($view)
    {
        parent::beforeRender($view);

        if ($this->loadScripts) {
            $this->cs->registerMetaTag(Yii::app()->params['metaKeys'], 'keywords');
            $this->cs->registerMetaTag(Yii::app()->params['metaDesc'], 'description');

            $cfgPath = Yii::app()->params['cfgName'];
            $modulePath = $this->module->basePath . '/assets/' . $cfgPath;
            $controllerPath = $modulePath . '/' . $this->id;

            $moduleScript = $modulePath . '/module.js';
            $controllerScript = $controllerPath . '/controller.js';
            $actionScript = $controllerPath . $this->action->id . '.js';

            $moduleCss = $modulePath . '/module.css';
            $controllerCss = $controllerPath . '/controller.css';
            $actionCss = $controllerPath . $this->action->id . '.css';

            if (file_exists($moduleScript))
                Y::cs()->registerScriptFile(CHtml::asset($moduleScript));
            if (file_exists($moduleCss))
                Y::cs()->registerCssFile(CHtml::asset($moduleCss));

            /*if (file_exists($controllerScript))
                Y::cs()->registerScriptFile(CHtml::asset($controllerScript));
            if (file_exists($controllerCss))
                Y::cs()->registerCssFile(CHtml::asset($controllerCss));

            if (file_exists($actionScript))
                Y::cs()->registerScriptFile(CHtml::asset($actionScript));
            if (file_exists($actionCss))
                Y::cs()->registerCssFile(CHtml::asset($actionCss));*/
        }
        return true;
    }

    public function registerScript($script, $position = CClientScript::POS_READY)
    {
        $id = __CLASS__ . $this->id . self::$script_cnt++;
        Yii::app()->clientScript->registerScript($id, $script, $position);
    }

    public function sendMail($adresses, $message, $from = array(), $attaches = array())
    {
        if (!$from['email']) $from['email'] = Config::get()->mail_from;
        if (!$from['name']) $from['name'] = Config::get()->mail_from_name;

        $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
        //$mailer->IsSMTP();
        $mailer->IsHTML();
        $mailer->CharSet = 'UTF-8';
        $mailer->From = $from['email'];
        $mailer->FromName = $from['name'];

        if (is_string($adresses)) {
            $arr = explode(',', stripslashes($adresses));
            if (count($arr) > 0) $adresses = $arr;
        }
        if ($adresses)
            foreach ($adresses as $adress) {
                if(!trim($adress)) continue;
                $mailer->AddAddress($adress);
            }

        foreach ($attaches as $attach) {
            $mailer->AddAttachment($attach);
        }

        $mailer->Subject = $message['subject'];
        $mailer->Body = $message['body'];
        return $mailer->Send();
    }

    public function setFlash($key, $msg)
    {
        Yii::app()->user->setFlash($key, $msg);
    }

    public function drawFlash($key, $block_class)
    {
        if (Yii::app()->user->hasFlash($key)) {
            echo '<div class="' . $block_class . '" >';
            echo Yii::app()->user->getFlash($key);
            echo '</div>';
        }
    }

    public function actionFlag($pk, $name, $value)
    {
        //if(Yii::app()->request->isPostRequest)
        {
            $model = $this->loadModel($pk);
            $model->{$name} = $value;
            $model->save(false);
        }
        //else throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function setSEO($data)
    {
        if ($data['title']) $this->pageTitle = $data['title'];
        if ($data['descr']) Yii::app()->params['metaDesc'] = $data['descr'];
        if ($data['keys']) Yii::app()->params['metaKeys'] = $data['keys'];
    }

    public function beforeCreate()
    {
    }

    public function afterCreate()
    {
    }

    public function beforeUpdate()
    {
    }

    public function afterUpdate()
    {
    }

    public function beforeList()
    {
    }

    protected static function gridStateProc($modelName, $action = 'save')
    {
        $webUser = Yii::app()->user;
        $params = array("{$modelName}", "{$modelName}_page", "{$modelName}_sort", "{$modelName}_cat_id_name");
        foreach ($params as $p) {
            $_p = "_{$p}";
            switch ($action) {
                case 'save' :
                    if (isset($_GET[$p])) {
                        $webUser->setState($_p, $_GET[$p]);
                    }
                    else {
                        $webUser->setState($_p, null);
                    }
                    break;
                case 'load' :
                    $data = $webUser->getState($_p);
                    if (isset($data)) {
                        $_GET[$p] = $data;
                    }
                    break;
                case 'reset' :
                    $webUser->setState($_p, null);
                    break;
            }
        }
    }

    public function curlPostRequest($url, $data, $debug = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        //curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $content = curl_exec($curl);
        $err = curl_errno($curl);
        $errmsg = curl_error($curl);
        //$header = curl_getinfo($curl);
        curl_close($curl);

        $rezult['errno'] = $err;
        $rezult['errmsg'] = $errmsg;
        $rezult['content'] = $content;

        return $debug ? $rezult : $rezult['content'];
    }

    public function registerCssFile($f_path){
        $cs = Yii::app()->clientScript;
        $m_time = filemtime($_SERVER['DOCUMENT_ROOT'].$f_path);
        $cs->registerCssFile(Y::app()->baseUrl . $f_path.'?'.$m_time);
    }

    public function registerScriptFile($f_path){
        $cs = Yii::app()->clientScript;
        $m_time = filemtime($_SERVER['DOCUMENT_ROOT'].$f_path);
        $cs->registerScriptFile(Y::app()->baseUrl . $f_path.'?'.$m_time);
    }
}