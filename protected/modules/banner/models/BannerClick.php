<?php

/**
 * This is the model class for table "{{banner_click}}".
 *
 * The followings are the available columns in table '{{banner_click}}':
 * @property integer $id
 * @property integer $banner_id
 * @property integer $create_time
 * @property string $ip_address
 * @property string $referer
 * @property string $cookie
 */
class BannerClick extends ActiveRecord
{
    public $published = 1;
    public $position = 0;
    public $no_log = true;

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{banner_click}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('banner_id, create_time, ip_address, referer, cookie', 'safe'),
			array('banner_id, create_time', 'numerical', 'integerOnly'=>true),
			array('ip_address, referer, cookie', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, banner_id, create_time, ip_address, referer, cookie', 'safe', 'on'=>'search'),
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
			'banner_id' => 'Banner',
			'create_time' => 'Create Time',
			'ip_address' => 'Ip Address',
			'referer' => 'Referer',
			'cookie' => 'Cookie',
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('banner_id',$this->banner_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('referer',$this->referer,true);
		$criteria->compare('cookie',$this->cookie,true);

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
        if ($this->isNewRecord){$this->create_time = time();}
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