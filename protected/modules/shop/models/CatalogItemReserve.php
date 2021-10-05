<?php

/**
 * This is the model class for table "{{catalog_item_reserve}}".
 *
 * The followings are the available columns in table '{{catalog_item_reserve}}':
 * @property integer $id
 * @property integer $item_id
 * @property integer $count
 * @property integer $cdate
 * @property integer $order_id
 */
class CatalogItemReserve extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogItemReserve the static model class
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
		return '{{catalog_item_reserve}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('item_id, count, cdate, order_id', 'required'),
			array('item_id, count, cdate, order_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, count, cdate, order_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
    public function relations()
   	{
        return array(
           'item'=>array(self::BELONGS_TO, 'CatalogItem', 'item_id'),
        );
   	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Товар',
            'count' => 'Количество',
			'cdate' => 'Дата бронирования',
			'order_id' => 'Заказ',
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

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.item_id',$this->item_id);
        $criteria->compare('t.count',$this->count);
		$criteria->compare('t.cdate',$this->cdate);
		$criteria->compare('t.order_id',$this->order_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind()
    {
        parent::afterFind();
        $this->cdate = date("d-m-Y - H:i:s",$this->cdate);
    }
}