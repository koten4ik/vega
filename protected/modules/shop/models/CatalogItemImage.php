<?php

/**
 * This is the model class for table "{{catalog_item_image}}".
 *
 * The followings are the available columns in table '{{catalog_item_image}}':
 * @property integer $id
 * @property integer $item_id
 * @property string $image
 * @property integer $position
 */
class CatalogItemImage extends ActiveRecord
{
    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/shop/item/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'mid','w'=>200,'h'=>160,'param'=>self::RESIZE),
        )),
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogItemImage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_item_image}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('item_id', 'required'),
			array('item_id, position', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, image, position', 'safe', 'on'=>'search'),
		));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'image' => 'Image',
			'position' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($item_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item_id',$item_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('position',$this->position);
        $criteria->order = 'position';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>4)
		));
	}

    public static function getList($item_id)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('item_id',$item_id);
        $criteria->order = 'position';
        return self::model()->findAll($criteria);
    }

    public function beforeSave()
    {
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        parent::beforeDelete();

        return true;
    }
}