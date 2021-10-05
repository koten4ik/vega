<?php

/**
 * This is the model class for table "{{comments}}".
 *
 * The followings are the available columns in table '{{comments}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $text
 * @property integer $create_time
 * @property integer $like_cnt
 * @property integer $published
 * @property integer $item_id
 * @property integer $model_key
 * @property integer $parent_id
 * @property integer $has_childs
 */
class Comments extends ActiveRecord
{
    public $published = 1;
    public $position = 0;
    public $approved = 0;

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{comments_item}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('user_id, name, text, create_time, like_cnt, published, item_id, model_key', 'safe'),
			array('user_id, create_time, like_cnt, published, item_id, model_key,
			    parent_id, has_childs, approved', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
            array('text','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, name, text, create_time, like_cnt, published, item_id, model_key', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'name' => 'Имя',
			'text' => 'Комментарий',
			'parent_id' => 'Ответ на',
			'create_time' => 'Время создания',
			'like_cnt' => 'Like Cnt',
			'published' => 'Опубликован',
			'item_id' => 'Элемент',
			'model_key' => 'Раздел',
            'approved'=>'Проверено'
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('like_cnt',$this->like_cnt);
		$criteria->compare('published',$this->published);
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('model_key',$this->model_key);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'approved asc, id DESC'),
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
        if ($this->isNewRecord){
            $this->create_time = time();
        }
        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        $success = parent::beforeDelete();

        //Model::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public static function getCount($item_id,$model_key)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('published',1);
        $criteria->compare('item_id',$item_id);
        $criteria->compare('model_key',$model_key);
        $criteria->order = 'create_time asc';
        return count(self::model()->findAll($criteria));
    }
    public static function getListByOwner($owner_id,$item_id,$model_key)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('published',1);
        $criteria->compare('item_id',$item_id);
        $criteria->compare('model_key',$model_key);
        $criteria->compare('parent_id',$owner_id);
        $criteria->order = 'create_time asc';
        return self::model()->findAll($criteria);
    }

    const CONTENT_ITEM = 1;
    const IGALLERY_ITEM = 2;

    public static function modelList($val = null){
        $arr =  array(
            self::CONTENT_ITEM=>'Материалы',
            self::IGALLERY_ITEM=>'Галерея',
        );
        if($val !== null) return $arr[$val];
        else return $arr;
    }
}