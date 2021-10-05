<?php
/**
 * This is the model class for table "{{igallery}}".
 *
 * The followings are the available columns in table '{{igallery}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $image
 * @property integer $published
 * @property string $meta_keys
 * @property string $meta_desc
 */
class IgalleryItem extends ActiveRecord
{
    public $cat_id = 0;
    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/igallery/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'normal','w'=>1200,'h'=>1000,'param'=>self::RESIZE),
                array('name'=>'mid','w'=>240,'h'=>160,'param'=>self::RESIZE_AND_CROP),
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
		return '{{igallery}}';
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
			array('published', 'numerical', 'integerOnly'=>true),
			array('title, alias', 'length', 'max'=>150),
            array('title, title_l2, title_l3, alias, descr, descr_l2, descr_l3, image, meta_data,
                posotion, cdate, cat_id, fname_import', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias, descr, image, published, meta_data', 'safe', 'on'=>'search'),
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
              'category'=>array(self::BELONGS_TO, 'IgalleryCategory', 'cat_id'),
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
			'alias' => 'Псевдоним',
			'descr' => 'Описание',
			'published' => 'Опубликовано',
            'image_tmp' => 'Изображение:',
            'position' => 'Позиция',
            'cdate' => 'Дата',
            'cat_id' => 'Категория',
            'fname_import'=>'Имена файлов в описание'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($arc = 0)
	{
        $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName'].$this->cat_id);

		$criteria=new CDbCriteria;

		//$criteria->compare('cat_id', $this->cat_id);
        if($this->cat_id){ // для большого кол-ва катов - медленно
            $cat = IgalleryCategory::model()->findByPk($this->cat_id);
            $rows = IgalleryCategory::model()->findAll('lft>='.$cat->lft.' and rgt<='.$cat->rgt);
            foreach($rows as $row) $cats[] = $row->id;
            $criteria->addInCondition('cat_id',$cats);
        }

        $criteria->compare('id', $this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('published',$this->published);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'id DESC'
            ),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function front_search($arc = 0)
    	{
            $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

    		$criteria=new CDbCriteria;

    		$criteria->compare('title',$this->title,true);
    		$criteria->compare('published',1);


    		return new CActiveDataProvider($this, array(
    			'criteria'=>$criteria,
                'sort'=>array(
                    'defaultOrder'=>'id DESC'
                ),
                'pagination'=>array('pageSize'=>6)
    		));
    	}

    public function getUrl()
    {
        return Yii::app()->createUrl('/igallery/item/view', array('alias'=>$this->alias));
    }

    public function afterFind()
    {
        parent::afterFind();
        //if(!$this->image) $this->image = Controller::noImg;

    }

    public function beforeSave()
    {

        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord){  $this->cdate = time(); }

        if($this->alias == '') $this->alias = Y::translitIt($this->title);
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if($this->hasErrors()) {   }
    }

    public function beforeDelete()
    {
        parent::beforeDelete();

        foreach (IgalleryItemImage::getList($this->id) as $item)
            $item->delete();

        return true;
    }
}