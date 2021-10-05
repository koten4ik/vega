<?php

/**
 * This is the model class for table "{{article_category}}".
 *
 * The followings are the available columns in table '{{article_category}}':
 * @property string $id
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 * @property string $name
 * @property integer $alias
 * @property string $descr
 * @property integer $published
 * @property string $params
 */
class CatalogCategory extends ActiveRecord
{
    public $parentId;
    public $notDeleted;

    const ROOT_ID = 1;
    const ROOT_NAME = 'Корень';

    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/shop/category/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'mid','w'=>300,'h'=>300,'param'=>self::RESIZE),
                array('name'=>'mid','w'=>100,'h'=>100,'param'=>self::RESIZE),
        )),
    );

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{catalog_category}}';
	}

    public function behaviors()
    {
        return array(
            'tree'=>array(
                'class'=>'ext.NestedSetBehavior.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
            ),
        );
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('title', 'required'),
            //array('alias','unique'),
			array('published', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>150),
            array('title, alias, descr, params, image', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('title, alias, descr, published, params', 'safe', 'on'=>'search'),
		));
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
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
			'title' => 'Имя',
			'alias' => 'Псевдоним',
			'descr' => 'Описание',
			'published' => 'Опубликовано',
            'image_tmp' => 'Изображение:'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
        $criteria->order = $this->tree->hasManyRoots ?
                           $this->tree->rootAttribute . ', ' . $this->tree->leftAttribute :
                           $this->tree->leftAttribute;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => false
		));
	}

    public function afterFind(){
        parent::afterFind();

        if( $this->alias == 'root'
            || $this->alias == 'articles'
            || $this->alias == 'reserve'
            || $this->alias == 'demand'
        ) $this->notDeleted = true;
    }
    public function _beforeSave()
    {

        if($this->alias == '') $this->alias = Y::translitIt($this->title);

    }

    public function getUrl()
    {
        return Yii::app()->createUrl('shop/item/list', array('c_alias'=>$this->alias, 'c_id'=>$this->id ));
    }

    private static $currentCat = null;

    public static function getCurrent()
    {
        if(CatalogItem::getCurrent()){
            self::$currentCat = CatalogItem::getCurrent()->category;
        }
        if( self::$currentCat == null && isset($_GET['c_id']) ){
            self::$currentCat = self::model()->find('id=:id',array(':id'=>$_GET['c_id']));
        }

        return self::$currentCat;
    }

    private static $parrentCat = null;
    public static function getParent(){
        if( self::$parrentCat == null )
            if(self::getCurrent()) self::$parrentCat = self::getCurrent()->parent()->find();
        return self::$parrentCat;
    }
}