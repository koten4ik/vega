<?php

/**
 * This is the model class for table "{{contact}}".
 *
 * The followings are the available columns in table '{{contact}}':
 * @property integer $id
 * @property string $cdate
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property integer $archived
 * @property string $ip
 */
class Feedback extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contact the static model class
	 */
    public $archived = 0;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{feedback}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, subject, message', 'required'),
			array('archived, cdate', 'numerical', 'integerOnly'=>true),
			array('name, email, ip', 'length', 'max'=>50),
			array('subject', 'length', 'max'=>100),
            array('name, subject, message','filter','filter'=>array($obj=new CHtmlPurifier(),'purify')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cdate, name, email, subject, message, archived, ip', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'cdate' => 'Дата',
			'name' => 'Имя',
			'email' => 'Email',
			'subject' => 'Тема',
			'message' => 'Сообщение',
			'archived' => 'В архиве',
			'ip' => 'Ip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($arc)
	{
        $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('archived',$arc);
		$criteria->compare('ip',$this->ip,true);

        if($this->cdate){
            $criteria->addBetweenCondition('cdate',
                CDateTimeParser::parse($this->cdate,'dd.MM.yyyy'),
                CDateTimeParser::parse($this->cdate,'dd.MM.yyyy')+60*60*24
            );
        }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'attributes'=>array(
                    'subject', 'cdate', 'name', 'email'
                ),
                'defaultOrder'=>'cdate DESC'
            ),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->cdate = time();

            $this->ip = Yii::app()->request->userHostAddress;
        }

        return parent::beforeValidate();
    }
}