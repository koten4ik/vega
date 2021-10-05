<?php

/**
 * This is the model class for table "{{poll_item}}".
 *
 * The followings are the available columns in table '{{poll_item}}':
 * @property integer $id
 * @property string $title
 * @property string $descr
 * @property integer $create_time
 * @property integer $published
 * @property integer $finished
 */
class PollItem extends ActiveRecord
{
    public $published = 1;
    public $position = 0;


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName(){   return '{{poll_item}}';   }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return CMap::mergeArray(parent::rules(), array(
            array('title', 'required'),
            array('title, descr, create_time, published, finished', 'safe'),
            array('create_time, published, finished, position', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, descr, create_time, published, finished', 'safe', 'on' => 'search'),
        ));
    }

    public function relations()
    {
        return array(
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'descr' => 'Описание',
            'create_time' => 'Дата создания',
            'published' => 'Опубликовано',
            'finished' => 'Завершено',
            'position' => 'Сорт.'
        );
    }

    public function search()
    {
        // saved grid state (page sort ect.)
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName']);

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('published', $this->published);
        $criteria->compare('finished', $this->finished);
        $criteria->compare('position', $this->position);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'create_time DESC'),
            'pagination' => array('pageSize' => Config::$data['base']->pageSize)
        ));
    }

    public function search_front()
    {
        // saved grid state (page sort ect.)
        // $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'id DESC'),
            'pagination' => array('pageSize' => Config::$data['base']->pageSizeFront)
        ));
    }

    public function getUrl()
    {
        //return Yii::app()->createUrl('module/controller/action', array('alias'=>$this->alias));
    }

    protected function afterFind()
    {
        parent::afterFind();
    }

    protected function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        parent::afterValidate();
        //if($this->hasErrors()){ $this->cdate = null; }
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->create_time = time();
        }
        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        $success = parent::beforeDelete();
        PollElement::model()->deleteAll('owner=' . $this->id);
        PollVote::model()->deleteAll('poll_id=' . $this->id);
        return $success;
    }

    public static function getListRaw($limit = -1)
    {
        $criteria = new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        return self::model()->findAll($criteria);
    }

    public static function getList($limit = -1)
    {
        $criteria = new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        return CMap::mergeArray(array('' => ''), CHtml::listData(self::model()->findAll($criteria), 'id', 'title'));
    }

    /*const WAIT = 'wait';
    const APPROVED = 'approved';
    public static function statusList($val = null){
        $arr =  array(
            self::WAIT=>'Ожидание',
            self::APPROVED=>'Одобрено',
        );
        if($val !== null) return $arr[$val];
        else return $arr;
    }*/

    public static function voted($poll_id)
    {
        // по пользователю
        if (Y::app()->user->id) {
            $u_voted = PollVote::model()->find('poll_id=' . $poll_id . ' and user_id=' . Y::app()->user->id);
            if ($u_voted) return true;
        }

        // по ip
        $ip_voted = PollVote::model()->findAll('poll_id=' . $poll_id . ' and ip=' . ip2long(Y::app()->request->userHostAddress));
        if (count($ip_voted) > 50) return true;

        // по кукам
        //if ($_COOKIE['poll_' . $poll_id]) return true;

        return false;
    }
}