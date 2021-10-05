<?php

/**
 * This is the model class for table "{{catalog_shipping}}".
 *
 * The followings are the available columns in table '{{catalog_shipping}}':
 * @property integer $id
 * @property string $name
 * @property string $descr
 * @property string $params
 * @property integer $ordering
 */
class CatalogPayment extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogShipping the static model class
	 */
    public $published = 1;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_payment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('published', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
            array('name, descr, params, published, ordering', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, descr, params, ordering', 'safe', 'on'=>'search'),
		);
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
			'name' => 'Название',
			'descr' => 'Описание',
			'params' => 'Параметры',
            'published'=>'Включено',
			'ordering' => 'Порядок сортировки',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
        $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('params',$this->params,true);
        $criteria->compare('published',$this->published);
		$criteria->compare('ordering',$this->ordering);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public static function getList()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('published',1);
        $criteria->order = 'ordering';
        return self::model()->findAll($criteria);
    }
}