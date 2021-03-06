<?php

/**
 * This is the model class for table "{{poll_vote}}".
 *
 * The followings are the available columns in table '{{poll_vote}}':
 * @property integer $id
 * @property integer $poll_id
 * @property integer $element_id
 * @property string $ip
 * @property integer $user_id
 * @property integer $create_time
 */
class PollVote extends ActiveRecord
{
    public $published = 1;
    public $position = 0;


	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

    public function tableName(){ return '{{poll_vote}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('element_id, ip, user_id, poll_id, create_time', 'safe'),
			array('element_id, user_id, create_time', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, element_id, ip, user_id,  create_time', 'safe', 'on'=>'search'),
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
			'element_id' => 'Element',
			'ip' => 'Ip',
			'user_id' => 'User',
			'create_time' => 'Create Time',
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('element_id',$this->element_id);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('create_time',$this->create_time);

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
        return CMap::mergeArray(array(''=>''),CHtml::listData(self::model()->findAll($criteria),'id','title'));
    }

    /*const WAIT = 'wait';
    const APPROVED = 'approved';
    public static function statusList($val = null){
        $arr =  array(
            self::WAIT=>'????????????????',
            self::APPROVED=>'????????????????',
        );
        if($val !== null) return $arr[$val];
        else return $arr;
    }*/
}