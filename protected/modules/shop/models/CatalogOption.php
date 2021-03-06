<?php

/**
 * This is the model class for table "{{catalog_option}}".
 *
 * The followings are the available columns in table '{{catalog_option}}':
 * @property integer $id
 * @property string $title
 * @property string $title_add
 * @property integer $position
 * @property integer $needed
 * @property integer $sufix
 */
class CatalogOption extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogOption the static model class
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
		return '{{catalog_option}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('position, needed', 'numerical', 'integerOnly'=>true),
			array('title, title_add, sufix', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, title_add, position, needed', 'safe', 'on'=>'search'),
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
			'title' => 'Название',
			'title_add' => 'Доп. название',
			'position' => 'Позиция',
			'needed' => 'Необходимо для покупки',
            'sufix' => 'Суфикс',

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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title_add',$this->title_add,true);
		$criteria->compare('position',$this->position);
		$criteria->compare('needed',$this->needed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position'),
		));
	}

    public function beforeDelete()
    {
        parent::beforeDelete();
        $vals = CatalogOptionVal::model()->findAll('option_id=:optionId', array(':optionId'=>$this->id));
        foreach($vals as $val)
            $val->delete();
            //CatalogItemOption::model()->deleteAll('option_value_id='.$this->id);
        return true;
    }
}