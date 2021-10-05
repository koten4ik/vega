<?php

/**
 * This is the model class for table "{{regions_region}}".
 *
 * The followings are the available columns in table '{{regions_region}}':
 * @property string $id_region
 * @property integer $id_country
 * @property string $oid
 * @property string $region_name_ru
 * @property string $region_name_en
 */
class RegionsRegion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RegionsRegion the static model class
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
		return '{{regions_region}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_country, oid, region_name_en', 'required'),
			array('id_country', 'numerical', 'integerOnly'=>true),
			array('oid', 'length', 'max'=>10),
			array('region_name_ru, region_name_en', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_region, id_country, oid, region_name_ru, region_name_en', 'safe', 'on'=>'search'),
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
			'id_region' => 'Id Region',
			'id_country' => 'Id Country',
			'oid' => 'Oid',
			'region_name_ru' => 'Region Name Ru',
			'region_name_en' => 'Region Name En',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($id_country)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_country',$id_country);
		/*$criteria->compare('id_country',$this->id_country);
		$criteria->compare('oid',$this->oid,true);
		$criteria->compare('region_name_ru',$this->region_name_ru,true);
		$criteria->compare('region_name_en',$this->region_name_en,true);*/

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>1000,),
		));
	}
}