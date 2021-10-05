<?php

/**
 * This is the model class for table "{{base_source_message}}".
 *
 * The followings are the available columns in table '{{base_source_message}}':
 * @property integer $id
 * @property string $category
 * @property string $message
 */
class BaseSourceMessage extends ActiveRecord
{
    public $published = 1;
    public $position = 0;
    public $category = 'common';
    const DEF_LANG = 'ru';

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{base_source_message}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('category', 'length', 'max'=>32),
			array('message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category, message', 'safe', 'on'=>'search'),
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
			'category' => 'Category',
			'message' => 'Строка',
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('message',$this->message,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'id DESC'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function search_front()
    {
        // saved grid state (page sort ect.)
        // $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
               'sort'=>array('defaultOrder'=>'id DESC'),
               'pagination'=>array('pageSize'=>Config::$data['base']->pageSizeFront)
        ));
    }

    public function getUrl(){
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
    public function afterValidate(){
        parent::afterValidate();
        //if($this->hasErrors()){ $this->cdate = null; }
    }

    protected function beforeSave()
    {
        //if ($this->isNewRecord){$this->create_time = time();}
        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        $success = parent::beforeDelete();

        BaseMessage::model()->deleteAll('id='.$this->id);
        return $success;
    }

    public static function getListRaw($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        return self::model()->findAll($criteria);
    }
    public static function getList($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        //return CMap::mergeArray(array(''=>''),CHtml::listData(self::model()->findAll($criteria),'id','title'));
        return CHtml::listData(self::model()->findAll($criteria),'id','title');
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
}