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
class ContentCategory extends ActiveRecord
{
    public $parentId;
    public $notDeleted;
    public $cat_id;
    public $published = 1;

    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/content/category/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'mid','w'=>320,'h'=>240,'param'=>self::RESIZE_AND_CROP),
                array('name'=>'sml','w'=>120,'h'=>80,'param'=>self::RESIZE_AND_CROP),
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
		return '{{content_category}}';
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
            array('alias','unique'),
			array('published, published_l2, published_l3', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>150),
            array('title, title_l2, title_l3, alias, descr, descr_l2, descr_l3, params, image', 'safe'),

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
            'title_l2' => 'Имя l2',
            'title_l3' => 'Имя l3',
			'alias' => 'Псевдоним',
			'descr' => 'Описание',
            'descr_l2' => 'Описание l2',
            'descr_l3' => 'Описание l3',
			'published' => 'Опубликовано',
            'published_l2' => 'Опубликовано l2',
            'published_l3' => 'Опубликовано l3',
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
            ||  $this->alias == 'articles'
        ) $this->notDeleted = true;
    }
    public function _beforeSave()
    {
        if($this->alias == '') $this->alias = Y::translitIt($this->title);
    }

    public static function byPK($pk){
        return self::model()->findByPk($pk);
    }
    public static function byAlias($alias){
        return self::model()->find('alias=:al', array(':al' => $alias));
    }
    public function getUrl()
    {
        return Yii::app()->createUrl('content/item/list', array('alias' => $this->alias));
    }
}