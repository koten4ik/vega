<?php

/**
 * This is the model class for table "{{catalog_attribute}}".
 *
 * The followings are the available columns in table '{{catalog_attribute}}':
 * @property integer $id
 * @property string $name
 * @property integer $cat_id
 * @property integer $filter
 * @property integer $type
 * @property integer $position
 * @property string $sufix
 */
class CatalogAttribute extends ActiveRecord
{
    const STRING = 1;
    const BOOLEAN = 2;
    const NUMERIC = 3;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CatalogAttribute the static model class
	 */
    public $position = 1;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_attribute}}';
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
			array('cat_id, filter, type, position', 'numerical', 'integerOnly'=>true),
			array('name, sufix', 'length', 'max'=>255),
            array('name, group_id, filter, type, position, sufix, cat_ids', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, cat_id, filter, type, position, sufix', 'safe', 'on'=>'search'),
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
               'category'=>array(self::BELONGS_TO, 'CatalogCategory', 'cat_id'),
           );
   	}

    /*public function getName(){
        return 'aa';//$this->name;
    }*/
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'cat_id' => 'Категория',
			'filter' => 'Поиск по характеристике',
			'type' => 'Тип',
			'position' => 'Позиция',
			'sufix' => 'суфикс',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
        //$this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('filter',$this->filter);
		$criteria->compare('type',$this->type);
		$criteria->compare('position',$this->position);
		$criteria->compare('sufix',$this->sufix,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function searchByCat($cat_id)
    {
        $criteria=new CDbCriteria;

        $attr_by = CatalogAttrCat::getListByCat(array($cat_id));
        if(!$attr_by) $criteria->compare('id',-1);
        foreach($attr_by as $elem)
            $criteria->compare('id',$elem->attr_id, false, 'OR');

        $criteria->compare('name',$this->name,true);
        $criteria->compare('cat_id',$this->cat_id);
        $criteria->compare('filter',$this->filter);
        $criteria->compare('type',$this->type);
        $criteria->compare('position',$this->position);
        $criteria->compare('sufix',$this->sufix,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
        ));
    }

    public static function getTypeList()
    {
        return array(self::STRING=>'Строка', self::NUMERIC=>'Число', self::BOOLEAN=>'Флаг(да/нет)');
    }
    public static function getType($val = null)
    {
        $arr = self::getTypeList();
        return $val != null ? $arr[$val] : $arr;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $t = new CatalogItem();
        Yii::app()->db->createCommand()->dropColumn($t->tableName(), 'attr'.$this->id);
        CatalogAttrVal::model()->deleteAll('attr_id=:attrId', array(':attrId'=>$this->id));
        CatalogAttrCat::model()->deleteAll('attr_id=:attrId', array(':attrId'=>$this->id));
    }

    public function afterSave()
    {
        parent::afterSave();

        $t = new CatalogItem();
        $type = $this->type == 1 ? 'string' : 'integer';
        if ($this->isNewRecord)
        {
            Yii::app()->db->createCommand()->addColumn($t->tableName(), 'attr'.$this->id, $type );
        }
        else{
            if($t->tableSchema->columns['attr'.$this->id]->type != $type)
                Yii::app()->db->createCommand()->alterColumn($t->tableName(), 'attr'.$this->id, $type );
        }

        /*$cats = explode('~',$this->cat_ids);
        CatalogAttrCat::model()->deleteAll('attr_id=:attrId', array(':attrId'=>$this->id));
        foreach($cats as $cat)
        {
            $attr_cat = new CatalogAttrCat();
            $attr_cat->cat_id = (int)$cat;
            $attr_cat->attr_id = $this->id;
            $attr_cat->save();
        }*/
    }

    /* @param mixed $cat if $cat < 0 return full list
     * @return array the records found */
    public static function getList($cat = null)
    {
        $criteria=new CDbCriteria;
        $criteria->order = 'position';

        if($cat < 0) return self::model()->findAll($criteria);

        $keys = array();
        $cat_ids = array();
        $cat_id = $cat != null ?  $cat->id : CatalogCategory::ROOT_ID;
        $cat_ids[] = $cat_id;

        if($cat != null){
            $descendants=$cat->ancestors()->findAll();
            foreach($descendants as $elem) $cat_ids[] = $elem->id;
        }

        foreach(CatalogAttrCat::getListByCat($cat_ids) as $elem)
            $keys[] = $elem->attr_id;

        return self::model()->findAllByPk($keys,$criteria);
        /*$criteria=new CDbCriteria;
        if($cat > 0){
            $criteria->compare('cat_id',$cat->id);
            $descendants=$cat->ancestors()->findAll();
            foreach($descendants as $elem)
                $criteria->compare('cat_id',$elem->id,false,'OR');        }

        if($cat == null) $criteria->compare('cat_id',CatalogCategory::ROOT_ID);
        //$criteria->compare('published',1);
        $criteria->order = 'position';
        return self::model()->cache(0)->findAll($criteria);*/
    }
}