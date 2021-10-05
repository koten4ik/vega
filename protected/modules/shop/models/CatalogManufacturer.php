<?php

/**
 * This is the model class for table "{{catalog_manufacturer}}".
 *
 * The followings are the available columns in table '{{catalog_manufacturer}}':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $descr
 * @property string $image
 * @property string $metadata
 */
class CatalogManufacturer extends ActiveRecord
{

    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/shop/manufacturer/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'mid','w'=>200,'h'=>160,'param'=>self::RESIZE),
        )),
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogManufacturer the static model class
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
		return '{{catalog_manufacturer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('name', 'required'),
			array('name, alias, image', 'length', 'max'=>255),
            array('name, alias, descr, image, metadata', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, alias, descr, image, metadata', 'safe', 'on'=>'search'),
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
			'id' => 'ID производителя',
			'name' => 'Имя производителя',
			'alias' => 'Псевдоним',
			'descr' => 'Описание',
			'image_tmp' => 'Изображение',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('metadata',$this->metadata,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function afterFind()
     {
         parent::afterFind();

     }

     public function beforeSave()
     {

         return parent::beforeSave();
     }

     public function beforeValidate()
     {
         if($this->alias == '') $this->alias = Y::translitIt($this->name);
         return parent::beforeValidate();
     }

    public static function getList()
    {
        $criteria=new CDbCriteria;
        //$criteria->compare('published',1);
        //$criteria->order = 'ordering';
        $list[] = new CatalogManufacturer();
        return CMap::mergeArray($list, self::model()->findAll($criteria));
    }
}