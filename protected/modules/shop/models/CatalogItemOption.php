<?php

/**
 * This is the model class for table "{{catalog_item_option}}".
 *
 * The followings are the available columns in table '{{catalog_item_option}}':
 * @property integer $id
 * @property integer $item_id
 * @property integer $option_id
 * @property integer $option_value_id
 * @property integer $quantity
 * @property integer $subtract
 * @property integer $price
 * @property integer $position
 */
class CatalogItemOption extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogItemOption the static model class
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
		return '{{catalog_item_option}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, option_value_id', 'required'),
			array('item_id, option_id, option_value_id, quantity, subtract, price, position', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, option_value_id, quantity, subtract, price', 'safe', 'on'=>'search'),
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
            'optionVal'=>array(self::BELONGS_TO, 'CatalogOptionVal', 'option_value_id'),
            'option'=>array(self::BELONGS_TO, 'CatalogOption', 'option_id'),
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
            'option_id' => 'Опция',
			'option_value_id' => 'Значение',
			'quantity' => 'Количество',
			'subtract' => 'Вычетать со склада',
			'price' => 'Цена',
            'position' => 'Позиция',
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

        if(isset($_GET['option_id'])) $option_id = $_GET['option_id'];
        if($option_id > 0) $criteria->compare('t.option_id',$option_id);

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.item_id',$item_id);
		$criteria->compare('t.option_value_id',$this->option_value_id);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.subtract',$this->subtract);
		$criteria->compare('t.price',$this->price);

        $criteria->with = array('optionVal');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'optionVal.position'),
		));
	}


}