<?php

/**
 * This is the model class for table "{{catalog_order}}".
 *
 * The followings are the available columns in table '{{catalog_order}}':
 * @property integer $id
 * @property integer $cdate
 * @property integer $mdate
 * @property integer $customer_id
 * @property string $comment
 * @property double $total
 * @property string $currency
 * @property string $ip
 * @property string $pay_firstname
 * @property string $pay_lastname
 * @property string $pay_phone1
 * @property string $pay_phone2
 * @property string $pay_email
 * @property string $pay_company
 * @property string $pay_address_1
 * @property string $pay_address_2
 * @property string $pay_city
 * @property string $pay_postcode
 * @property string $pay_country
 * @property string $pay_region
 * @property string $pay_method
 * @property string $ship_firstname
 * @property string $ship_lastname
 * @property string $ship_phone1
 * @property string $ship_phone2
 * @property string $ship_email
 * @property string $ship_company
 * @property string $ship_address_1
 * @property string $ship_address_2
 * @property string $ship_city
 * @property string $ship_postcode
 * @property string $ship_country
 * @property string $ship_region
 * @property string $ship_method
 * @property string $products
 * @property string $status
 */
class CatalogOrder extends ActiveRecord
{
    public $customer;
    public $total_c;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogOrder the static model class
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
		return '{{catalog_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pay_firstname, pay_lastname, pay_phone1, pay_email, pay_address_1, pay_city, pay_postcode,
			    pay_region, pay_method, ship_firstname, ship_lastname, ship_phone1, ship_email,
                ship_address_1, ship_city, ship_postcode, ship_region, ship_method, total', 'required'),

			array('cdate, mdate, customer_id', 'numerical', 'integerOnly'=>true),
            array('pay_email, ship_email', 'email'),
            array('pay_region, pay_city, ship_region, ship_city', 'compare',
                'compareValue'=>-1, 'operator'=>'>', 'message'=>'Укажите {attribute}' ),

            array('pay_firstname, pay_lastname, pay_phone1, pay_address_1, pay_postcode, comment,
                ship_firstname, ship_lastname, ship_phone1, ship_address_1, ship_postcode','filter',
                'filter'=>array($obj=new CHtmlPurifier(),'purify')),

			array('total', 'numerical'),
			array('currency, ip', 'length', 'max'=>24),

			array('pay_firstname, pay_lastname, pay_phone1, pay_phone2, pay_email, pay_company,
			    pay_address_1, pay_address_2, pay_city, pay_postcode, pay_country, pay_region,
			    pay_method, ship_firstname, ship_lastname, ship_phone1, ship_phone2, ship_email,
                ship_company, ship_address_1, ship_address_2, ship_city, ship_postcode, ship_country,
                ship_region, ship_method', 'length', 'max'=>128),

            array('cdate, mdate, customer_id, comment, total, currency, ip, pay_firstname, pay_lastname,
                pay_phone1, pay_phone2, pay_email, pay_company, pay_address_1, pay_address_2, pay_city,
                pay_postcode, pay_country, pay_region, pay_method, ship_firstname, ship_lastname,
                ship_phone1, ship_phone2, ship_email, ship_company, ship_address_1, ship_address_2,
                ship_city, ship_postcode, ship_country, ship_region, ship_method, products, status', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cdate, mdate, customer_id, comment, total, currency, ip, pay_firstname, pay_lastname,
			    pay_phone1, pay_phone2, pay_email, pay_company, pay_address_1, pay_address_2, pay_city,
			    pay_postcode, pay_country, pay_region, pay_method, ship_firstname, ship_lastname,
			    ship_phone1, ship_phone2, ship_email, ship_company, ship_address_1, ship_address_2,
                ship_city, ship_postcode, ship_country, ship_region, ship_method', 'safe', 'on'=>'search'),
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
            'pay_country_data'=>array(self::BELONGS_TO, 'RegionsCountry', 'pay_country'),
            'pay_region_data'=>array(self::BELONGS_TO, 'RegionsRegion', 'pay_region'),
            'pay_city_data'=>array(self::BELONGS_TO, 'RegionsCity', 'pay_city'),
            'ship_country_data'=>array(self::BELONGS_TO, 'RegionsCountry', 'ship_country'),
            'ship_region_data'=>array(self::BELONGS_TO, 'RegionsRegion', 'ship_region'),
            'ship_city_data'=>array(self::BELONGS_TO, 'RegionsCity', 'ship_city'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Заказ',
			'cdate' => 'Дата создания',
			'mdate' => 'Дата изменения',
			'customer_id' => 'ID покупателя',
            'customer' => 'Покупатель',
			'comment' => 'Коментарий',
			'total' => 'Итого',
            'total_c' => 'Итого',
			'currency' => 'Валюта',
			'ip' => 'Ip адрес',
            'status'=>'Статус',

			'pay_firstname' => 'Имя, отчество',
			'pay_lastname' => 'Фамилия',
			'pay_phone1' => 'Телефон',
			'pay_phone2' => 'Телефон 2',
			'pay_email' => 'Email',
			'pay_company' => 'Компания',
			'pay_address_1' => 'Адрес',
			'pay_address_2' => 'Адрес 2',
			'pay_postcode' => 'Почтовый индекс',

            'pay_country' => 'Страна',
            'pay_region' => 'Область/регион',
            'pay_city' => 'Город',
            'pay_country_data.country_name_ru' => 'Страна',
            'pay_region_data.region_name_ru' => 'Область/регион',
            'pay_city_data.city_name_ru' => 'Город',

			'pay_method' => 'Способ оплаты',

			'ship_firstname' => 'Имя, отчество',
			'ship_lastname' => 'Фамилия',
			'ship_phone1' => 'Телефон',
			'ship_phone2' => 'Телефон 2',
			'ship_email' => 'Email',
			'ship_company' => 'Компания',
			'ship_address_1' => 'Адрес',
			'ship_address_2' => 'Адрес 2',
			'ship_postcode' => 'Почтовый индекс',

            'ship_country' => 'Страна',
            'ship_region' => 'Область/регион',
            'ship_city' => 'Город',
            'ship_country_data.country_name_ru' => 'Страна',
            'ship_region_data.region_name_ru' => 'Область/регион',
            'ship_city_data.city_name_ru' => 'Город',

			'ship_method' => 'Способ доставки',
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
        if($this->cdate){
            $criteria->addBetweenCondition('cdate',
                CDateTimeParser::parse($this->cdate,'dd.MM.yyyy'),
                CDateTimeParser::parse($this->cdate,'dd.MM.yyyy')+60*60*24
            );
        }
		$criteria->compare('mdate',$this->mdate);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('total',$this->total);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('pay_firstname',$this->pay_firstname,true);
		$criteria->compare('pay_lastname',$this->pay_lastname,true);
		$criteria->compare('pay_phone1',$this->pay_phone1,true);
		$criteria->compare('pay_phone2',$this->pay_phone2,true);
		$criteria->compare('pay_email',$this->pay_email,true);
		$criteria->compare('pay_company',$this->pay_company,true);
		$criteria->compare('pay_address_1',$this->pay_address_1,true);
		$criteria->compare('pay_address_2',$this->pay_address_2,true);
		$criteria->compare('pay_city',$this->pay_city,true);
		$criteria->compare('pay_postcode',$this->pay_postcode,true);
		$criteria->compare('pay_country',$this->pay_country,true);
		$criteria->compare('pay_region',$this->pay_region,true);
		$criteria->compare('pay_method',$this->pay_method,true);
		$criteria->compare('ship_firstname',$this->ship_firstname,true);
		$criteria->compare('ship_lastname',$this->ship_lastname,true);
		$criteria->compare('ship_phone1',$this->ship_phone1,true);
		$criteria->compare('ship_phone2',$this->ship_phone2,true);
		$criteria->compare('ship_email',$this->ship_email,true);
		$criteria->compare('ship_company',$this->ship_company,true);
		$criteria->compare('ship_address_1',$this->ship_address_1,true);
		$criteria->compare('ship_address_2',$this->ship_address_2,true);
		$criteria->compare('ship_city',$this->ship_city,true);
		$criteria->compare('ship_postcode',$this->ship_postcode,true);
		$criteria->compare('ship_country',$this->ship_country,true);
		$criteria->compare('ship_region',$this->ship_region,true);
		$criteria->compare('ship_method',$this->ship_method,true);
        $criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'cdate desc'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function afterFind()
    {
        parent::afterFind();
        $this->cdate = date("d-m-Y - H:i:s",$this->cdate);
        $this->customer = $this->pay_lastname.' '.$this->pay_firstname;
        $this->total_c = $this->total.ShopModule::getCurrency();
    }

    public function beforeSave()
    {

        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->cdate = time();
            $this->mdate = time();
            $this->ip = Yii::app()->request->userHostAddress;
            $this->customer_id = Yii::app()->user->id;
        }
        $this->mdate = time();
        return parent::beforeValidate();
    }

    const PAY_WAIT = '0';
    const SHIP_WAIT = '1';
    const IN_PROCESS = '2';
    const SHIP_COMPLETE = '3';
    const RETURNED = '4';
    const COMPLETED = '5';
    public static function statusList($val=null) {
        $_items = 	array(
            self::PAY_WAIT => 'Ожидание оплаты',
            self::SHIP_WAIT => 'Ожидает доставки',
            self::IN_PROCESS => 'В обработке',
            self::SHIP_COMPLETE => 'Доставлено',
            self::RETURNED => 'Возвращено',
            self::COMPLETED => 'Сделка завершена',
   		);
        if(isset($val))
            return isset($_items[$val]) ? $_items[$val] : 'undefined value';
        else return $_items;
   	}
}