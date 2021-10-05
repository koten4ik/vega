<?php

/**
 * This is the model class for table "{{catalog_attr_cat}}".
 *
 * The followings are the available columns in table '{{catalog_attr_cat}}':
 * @property integer $id
 * @property integer $attr_id
 * @property integer $cat_id
 */
class CatalogAttrCat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogAttrCat the static model class
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
		return '{{catalog_attr_cat}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attr_id, cat_id', 'required'),
			array('attr_id, cat_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, attr_id, cat_id', 'safe', 'on'=>'search'),
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
			'attr_id' => 'Attr',
			'cat_id' => 'Cat',
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
		$criteria->compare('attr_id',$this->attr_id);
		$criteria->compare('cat_id',$this->cat_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getListByCat($cat_ids = null)
    {
        $criteria=new CDbCriteria;

        if(count($cat_ids)){
            foreach($cat_ids as $cat_id)
                $criteria->compare('cat_id',$cat_id, false, 'OR');
        }
        return self::model()->cache(0)->findAll($criteria);
    }

    public static function getListByAttr($attr_id = null)
    {
        $criteria=new CDbCriteria;

        if($attr_id > 0){
            $criteria->compare('attr_id',$attr_id);
        }
        return self::model()->cache(0)->findAll($criteria);
    }
}