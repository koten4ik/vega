<?php

/**
 * This is the model class for table "{{regions_city}}".
 *
 * The followings are the available columns in table '{{regions_city}}':
 * @property string $id_city
 * @property string $id_region
 * @property integer $id_country
 * @property string $oid
 * @property string $city_name_ru
 * @property string $city_name_en
 */
class RegionsCity extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RegionsCity the static model class
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
		return '{{regions_city}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_region, id_country, oid, city_name_en', 'required'),
			array('id_country', 'numerical', 'integerOnly'=>true),
			array('id_region, oid', 'length', 'max'=>10),
			array('city_name_ru, city_name_en', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_city, id_region, id_country, oid, city_name_ru, city_name_en', 'safe', 'on'=>'search'),
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
			'id_city' => 'Id City',
			'id_region' => 'Id Region',
			'id_country' => 'Id Country',
			'oid' => 'Oid',
			'city_name_ru' => 'City Name Ru',
			'city_name_en' => 'City Name En',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_region)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->compare('id_region',$id_region);

		/*$criteria->compare('id_city',$this->id_city);
		$criteria->compare('id_country',$this->id_country);
		$criteria->compare('oid',$this->oid,true);
		$criteria->compare('city_name_ru',$this->city_name_ru,true);
		$criteria->compare('city_name_en',$this->city_name_en,true);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>1000,),
		));
	}
}