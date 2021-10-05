<?php

/**
 * This is the model class for table "{{catalog_option_val}}".
 *
 * The followings are the available columns in table '{{catalog_option_val}}':
 * @property integer $id
 * @property integer $option_id
 * @property string $value
 * @property integer $position
 */
class CatalogOptionVal extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogOptionVal the static model class
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
		return '{{catalog_option_val}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('option_id, value', 'required'),
			array('option_id, position', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, option_id, value, position', 'safe', 'on'=>'search'),
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
			'option_id' => 'Опция',
			'value' => 'Значение',
			'position' => 'Позиция',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($option_id = -1)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        if(isset($_GET['option_id'])) $option_id = $_GET['option_id'];
        if($option_id > 0) $criteria->compare('t.option_id',$option_id);

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.value',$this->value,true);
		//$criteria->compare('t.position',$this->position);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'t.position'),
		));
	}

    public function beforeDelete()
    {
        parent::beforeDelete();
        CatalogItemOption::model()->deleteAll('option_value_id='.$this->id);
        return true;
    }
}