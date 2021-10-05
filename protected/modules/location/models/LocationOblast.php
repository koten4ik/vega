<?php

/**
 * This is the model class for table "{{location_oblast}}".
 *
 * The followings are the available columns in table '{{location_oblast}}':
 * @property string $id
 * @property integer $country_id
 * @property string $title
 */
class LocationOblast extends ActiveRecord
{
    public $published = 1;
    public $position = 0;


	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{location_oblast}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('country_id', 'required'),
			array('country_id, capital_id, published', 'numerical', 'integerOnly'=>true),
			array('title, title_en, okrug', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, country_id, title', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'country' => array(self::BELONGS_TO, 'LocationCountry', 'country_id'),
            'capital' => array(self::BELONGS_TO, 'LocationCity', 'capital_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'country_id' => Y::t('Страна'),
            'title' => Y::t('Название'),
            'title_en' => Y::t('Название En'),
            'published' => Y::t('Опубликовано'),
            'capital_id' => Y::t('Цент. город'),
            'okrug' => Y::t('Округ'),
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'title ASC'),
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
        $this->u_time = time();
        if ($this->isNewRecord) $this->c_time = time();

        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        $success = parent::beforeDelete();

        //Model::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public static function getListRaw($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        return self::model()->findAll($criteria);
    }
    public static function getList($country_id = 0){
        $criteria=new CDbCriteria;
        $criteria->order = 'title';
        //$criteria->limit = $limit;
        $criteria->compare('country_id',$country_id);
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

    public function childCnt(){
        return LocationRaion::model()->count('oblast_id='.$this->id);
    }

    public static function byPK($pk){
        return self::model()->findByPk($pk);
    }
}