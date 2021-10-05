<?php

/**
 * This is the model class for table "{{content_item_cat}}".
 *
 * The followings are the available columns in table '{{content_item_cat}}':
 * @property integer $id
 * @property integer $cat_id
 * @property integer $item_id
 */
class ContentItemCat extends ActiveRecord
{
    public $published = 1;
    public $position = 0;
    public $no_log = true;

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{content_item_cat}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('cat_id, item_id', 'required'),
			array('cat_id, item_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cat_id, item_id', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'item'=>array(self::BELONGS_TO, 'ContentItem', 'item_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cat_id' => 'Cat',
			'item_id' => 'Item',
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('item_id',$this->item_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'id DESC'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function getList($cat_id = 0)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.cat_id',$cat_id);
        $criteria->with = array('item');
        $criteria->together = true;
        $criteria->compare('item.published', 1);
        $criteria->order = 'item.cdate DESC';

        return self::model()->findAll($criteria);
    }
    
    public static function getCats($item_id){
        $criteria=new CDbCriteria;
        $criteria->compare('item_id',$item_id);
        $arr = array();
        foreach( self::model()->findAll($criteria) as $cat) $arr[] = $cat->cat_id;
        return $arr;
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

        //Model::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }
}