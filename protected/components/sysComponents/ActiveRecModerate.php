<?php


class ActiveRecModerate extends ActiveRecord
{
    public $moderated = self::MODERATED_NONE;
    public $moderate_apply = 0;
    public $moderate_descr_list;
    public $moderate_descr_list2;
    public $delete_mark=0;
    public $status = null;
    public $visible_f;
    public $moderator_id = 0;

    public function rules()
    {
        return CMap::mergeArray(parent::rules(), array(
            array('moderated, moderate_apply, delete_mark, status, visible_f', 'safe'),
            array('moderate_apply', 'userApplyCheck'),
        ));
    }

    public function relations()
    {
        return CMap::mergeArray(parent::relations(), array(
            'moderator' => array(self::BELONGS_TO, 'User', 'moderator_id'),
        ));
    }

    public function attributeLabels()
    {
        return CMap::mergeArray(parent::attributeLabels(), array(
            'moderated' => Y::t('Проверено'),
            'moderate_apply' => Y::t('Причина устранена'),
            'moderate_descr_list'=>Y::t('Шаблон отказа'),
            'moderate_descr_list2'=>Y::t('Шаблон доработки '),
        ));
    }

    public static function addModerSearchFrontCriteria()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(
            't.moderated='.self::MODERATED_APPROVED. ' or t.moderated='.self::MODERATED_APPROVED_REVISION);

        return $criteria;
    }

    /* ===================================================================== */

    public function moderListBaseCriteria()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.published', 1);
        $criteria->addCondition(
            't.moderated='.self::MODERATED_NONE.
            ' or ( t.moderated='.self::MODERATED_APPROVED.' and t.u_time>t.u_time_adm )');
        return $criteria;
    }

    public function statusMyListCriteria()
    {
        $criteria = new CDbCriteria();

        if(isset($_GET['revision']) && $this->status==null)
            $this->status = self::STATUS_NEED_REVISION;

        if($this->status==self::STATUS_ROUGH)
        {
            $criteria->compare('t.published', 0);
        }
        if($this->status==self::STATUS_MODER_WAIT)
        {
            $criteria->compare('t.published', 1);
            $criteria->compare('t.moderated', self::MODERATED_NONE);
        }
        if($this->status==self::STATUS_NEED_REVISION)
        {
            $criteria->compare('t.published', 1);
            //$criteria->compare('t.moderated', self::MODERATED_REVISION);
            $criteria->addCondition(
                't.moderated='.self::MODERATED_REVISION. ' or t.moderated='.self::MODERATED_APPROVED_REVISION);

        }
        if($this->status==self::STATUS_PUBLISHED)
        {
            $criteria->compare('t.published', 1);
            $criteria->compare('t.moderated', self::MODERATED_APPROVED);
        }
        if($this->status==self::STATUS_PUBLISHED_REVISION)
        {
            $criteria->compare('t.published', 1);
            $criteria->compare('t.moderated', self::MODERATED_APPROVED_REVISION);
        }

        return $criteria;
    }

    public function moderListCriteria()
    {
        $criteria = new CDbCriteria();

        $criteria->mergeWith($this->moderListBaseCriteria());

        if($this->status==self::STATUS_MODER_NOT_READED)
            $criteria->addCondition('t.u_time_adm = 0');
        if($this->status==self::STATUS_MODER_READED)
            $criteria->addCondition('t.u_time_adm > 0');
        if($this->visible_f==1)
            $criteria->addCondition('moderated='.self::MODERATED_APPROVED.' or moderated='.self::MODERATED_APPROVED_REVISION);
        if($this->visible_f==2)
            $criteria->addCondition('moderated!='.self::MODERATED_APPROVED.' and moderated!='.self::MODERATED_APPROVED_REVISION);

        return $criteria;
    }
    /* ===================================================================== */
    public function userApplyNeeded()
    {
        return ( $this->moderated == self::MODERATED_REVISION ||
                $this->moderated == self::MODERATED_APPROVED_REVISION )
                && User::isUser();
    }
    public function userApplyCheck($attribute, $params)
    {
        if( $this->userApplyNeeded() && !$this->moderate_apply && $this->published )
            $this->addError("moderate_apply", Y::t('Необходимо устранить причину доработки!'));
    }
    public function userApplyFixed()
    {
        return ( $this->moderate_apply && User::isModerator() );
    }

    /* ===================================================================== */

    public function beforeSave()
    {
        if ($this->isNewRecord){
            if(User::isModerator()) $this->moderated = self::MODERATED_APPROVED;
        }

        if($this->moderate_apply)
        {
            if(User::isUser())
            {
                if( $this->moderated == self::MODERATED_REVISION )
                    $this->moderated = self::MODERATED_NONE;

                if( $this->moderated == self::MODERATED_APPROVED_REVISION )
                    $this->moderated = self::MODERATED_APPROVED;
            }
            if(User::isModerator()) $this->moderate_apply = 0;
            //$this->data->moderate_descr = '';
        }

        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if(User::isModerator()) $this->moderator_id = Y::user_id();
        return parent::beforeValidate();
    }
    /* ===================================================================== */

    const MODERATED_NONE = 0;
    const MODERATED_APPROVED = 1;
    const MODERATED_REVISION = 2;
    const MODERATED_APPROVED_REVISION = 3;
    public static function moderateList($val = null){
        $arr =  array(
            self::MODERATED_NONE=>Y::t('Не проверено',0),
            self::MODERATED_APPROVED=>Y::t('Опубликовано',0),
            self::MODERATED_APPROVED_REVISION=>Y::t('На доработку (опубликовано)',0),
            self::MODERATED_REVISION=>Y::t('На доработку (не опубликовано - скрыто)',0),
        );
        if($val !== null) return $arr[$val];
        else return $arr;
    }

    /* ===================================================================== */

    public function getStatusPrint()
    {
        $rez = '';

        if(!$this->published) $rez = '<span style="color: #111;">'.Y::t('Черновик',0).'</span>'.
            '<br><span style="font-size:90%">'.Y::t('Не опубликовано',0).'</span>';
        else
        {
            $moder2 = $this->u_time > $this->u_time_adm;
            if(User::isModerator()){
                if($this->moderated==self::MODERATED_NONE && $this->moderate_apply)
                    $mw2 = '2';
                if($this->moderate_apply)
                    $mw22 = '2';
            }

            $urlU = $this->urlU. '&return=' .Y::app()->request->url .'#mod_descr';

            $only_portal = $this->on_rp==0?'<br>(Только портал!)':'';
            if($this->moderated==self::MODERATED_NONE)
                $rez = '<span class="yellow" style="font-size:90%">'.Y::t('Ожидает проверки',0).$mw2.'</span>'.
                    '<br><span style="font-size:90%">'.Y::t('Не опубликовано',0).'</span>';
            if($this->moderated==self::MODERATED_APPROVED)
                $rez = ($moder2 ? '<span class="yellow">'.Y::t('Проверяется',0).$mw22.'</span><br>' :'').
                    '<span class="green">'.Y::t('Опубликовано',0).$only_portal.'</span>';
            if($this->moderated==self::MODERATED_REVISION)
                $rez = '<a class="red" href="'.$urlU.'">'.Y::t('Доработать',0).'</a>'.
                    '<br><span style="font-size:90%">'.Y::t('Не опубликовано',0).$only_portal.'</span>';
            if($this->moderated==self::MODERATED_APPROVED_REVISION)
                $rez = '<a class="red" href="'.$urlU.'">'.Y::t('Доработать',0).'</a>'.
                    '<br><span class="green">'.Y::t('Опубликовано',0).$only_portal.'</span>';
        }

        return $rez;
    }

    /* ===================================================================== */

    public function getModerStatusPrint()
    {
        $rez = '';
        $only_portal = $this->on_rp==0?'<br>(Только портал!)':'';
        if( $this->u_time_adm == 0 )
            $rez = '<span class="yellow">'.Y::t('Проверка нового',0).'</span>';
        if( $this->u_time_adm > 0 )
            $rez = '<span class="blue">'.Y::t('Проверка изменений',0).$only_portal.'</span>';

        return $rez;
    }

    /* ===================================================================== */

    public function moderateDescrList(){
        $opt1 = Y::t('Не соответствует тематике',0)."\n";
        $opt3 = Y::t('Не понятен смысл материала',0)."\n";
        $opt2 = Y::t('Не представляет материал ценности (может быть не интересен или не полезен пользователям)',0)."\n";
        $opt4 = Y::t('Материал нарушает правила размещения информации на сайте: <a href="http://rp.bytdobru.info/addrules" target="_blank">Правила размещения</a>',0)."\n";
        return array( $opt1=>$opt1, $opt3=>$opt3, $opt2=>$opt2, $opt4=>$opt4 );
    }
    public function moderateDescrList2(){
        $opt1 = Y::t('Много ошибок в тексте - необходимо исправить грамматические и орфографические ошибки',0)."\n";
        $opt3 = Y::t('Много слов написанных большими буквами – необходимо привести текст в читабельный вид',0)."\n";
        $opt2 = Y::t('Привести текст в читабельный вид',0)."\n";
        $opt4 = Y::t('Ознакомьтесь, пожалуйста, с правилами размещения материала: <a href="http://rp.bytdobru.info/addrules" target="_blank">Правила размещения</a>',0)."\n";
        $opt5 = Y::t('Материал отредактирован редактором сайта для его соответствия правилам размещения информации.',0)."\n";
        $opt6 = Y::t('Желательно добавить фото к материалу, с ним ваш материал будет иметь больший вес и больше просмотров.',0)."\n";
        $opt7 = Y::t('При желании можете заполнить -Рекомендуемые поля-, с ними ваш материал будет иметь больший вес и больше откликов',0)."\n";

        return array( $opt1=>$opt1, $opt3=>$opt3, $opt2=>$opt2, $opt4=>$opt4, $opt5=>$opt5, $opt6=>$opt6, $opt7=>$opt7 );
    }

    /* ===================================================================== */

    const STATUS_ROUGH = 1;
    const STATUS_MODER_WAIT = 2;
    const STATUS_NEED_REVISION = 3;
    const STATUS_PUBLISHED = 4;
    const STATUS_PUBLISHED_REVISION = 6;
    const STATUS_MODER_NOT_READED = 10;
    const STATUS_MODER_READED = 11;
    public function statusFilter()
    {
        $m_class = get_class($this);
        $is_revision = isset($_GET['revision']);
        $arr = array();
        if(!$is_revision) $arr[0] = Y::t('Все материалы',0);
        if(!$is_revision) $arr[self::STATUS_ROUGH] = Y::t('Черновики',0);
        if(!$is_revision) $arr[self::STATUS_MODER_WAIT] = Y::t('Ожидают проверки',0);
        if(1            ) $arr[self::STATUS_NEED_REVISION] = Y::t('Нуждаются в доработке',0);
        if(!$is_revision) $arr[self::STATUS_PUBLISHED] = Y::t('Опубликованы',0);

        if( $is_revision ) $_GET[$m_class]['status'] = self::STATUS_NEED_REVISION;

        return CHtml::dropDownList($m_class . '[status]', $_GET[$m_class]['status'],$arr);
    }
    public function statusModerateFilter()
    {
        $m_class = get_class($this);
        $arr = array();
        $arr[0] = Y::t('Все',0);
        $arr[self::STATUS_MODER_NOT_READED] = Y::t('Проверка нового',0);
        $arr[self::STATUS_MODER_READED] = Y::t('Проверка изменений',0);

        return CHtml::dropDownList($m_class . '[status]', $_GET[$m_class]['status'],$arr);
    }
    public function visibleModerateFilter()
    {
        $m_class = get_class($this);
        $arr = array();
        $arr[0] = Y::t('Все',0);
        $arr[1] = Y::t('Да (опубликовано)',0);
        $arr[2] = Y::t('Нет (не опубликовано)',0);

        return CHtml::dropDownList($m_class . '[visible_f]', $_GET[$m_class]['visible_f'],$arr);
    }

    public function getVisible()
    {
        return $this->published &&
            ( $this->moderated==self::MODERATED_APPROVED ||
              $this->moderated==self::MODERATED_APPROVED_REVISION );
    }
    public function getVisiblePrint(){
        return $this->visible ? '<span class="green">'.Y::t('Да').'</span>' :
            '<span class="">'.Y::t('Нет').'</span>';
    }
    /* ===================================================================== */

    public static function needModeratedCntCondition()
    {
        $criteria = new CDbCriteria();
        //$criteria->addCondition('t.u_time_adm = 0');
        $criteria->addCondition('t.moderated = '.self::MODERATED_NONE);
        $criteria->mergeWith(self::moderListBaseCriteria());
        return $criteria;
    }
    public static function needModeratedCnt2Condition(){
        $criteria = new CDbCriteria();
        //$criteria->addCondition('t.u_time_adm > 0');
        $criteria->addCondition('t.moderated != '.self::MODERATED_NONE);
        $criteria->mergeWith(self::moderListBaseCriteria());
        return $criteria;
    }

    public static function needRevisionCntCondition()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.user_id', Y::user_id());
        $criteria->compare('t.published', 1);
        $criteria->compare('t.moderated', self::MODERATED_REVISION);
        return $criteria;
    }
    public static function needRevisionCnt2Condition(){
        $criteria = new CDbCriteria();
        $criteria->compare('t.user_id', Y::user_id());
        $criteria->compare('t.published', 1);
        $criteria->compare('t.moderated', self::MODERATED_APPROVED_REVISION);
        return $criteria;
    }
}


