<?php

/**
 * This is the model class for table "{{location_country}}".
 *
 * The followings are the available columns in table '{{location_country}}':
 * @property integer $id
 * @property string $title
 */
class LocationCountry extends ActiveRecord
{
    public $published = 1;
    public $position = 0;


	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{location_country}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('title', 'required'),
			array('title, title_en, capital_id, published, position', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'capital' => array(self::BELONGS_TO, 'LocationCity', 'capital_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'title' => Y::t('Название'),
            'title_en' => Y::t('Название En'),
            'published' => Y::t('Опубликовано'),
            'capital_id' => Y::t('Цент. город'),
            'position' => Y::t('Сорт.'),
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position ASC'),
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
    public static function getList($limit = -1){
        $criteria=new CDbCriteria;
        if(Y::app()->params['cfgName'] == 'frontend')
            $criteria->compare('published',1);
        $criteria->order = 'position';
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

    public static function byPK($pk){
        return self::model()->findByPk($pk);
    }
}