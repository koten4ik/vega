<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $url
 * @property string $text
 * @property string $text_en
 * @property string $place_id
 * @property integer $published
 * @property integer $position
 * @property integer $rotation_percent
 * @property string $flash_file
 * @property integer $flash_width
 * @property integer $flash_height
 * @property integer $from_time
 * @property integer $to_time
 * @property integer $views
 */
class Banner extends ActiveRecord
{
    const t_format = 'd-m-Y';

    public $stat_from, $stat_to;
    public $rotation_percent = 100;
    public $rotation_time = 0;
    public $target;

    public $image_tmp, $flash_file_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/banner/item/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>true),
        ),
        'flash_file'=>array(
            'path'=>'/content/upload/banner/item/',  'time_dir'=>false, 'save_fname'=>true,
            'rule'=>array('types'=>'swf','maxSize'=>10, 'required'=>false),
        ),
    );
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banner the static model class
	 */
    public $flash_file;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{banner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('title_adm, url', 'required'),
            array('flash_width, flash_height', 'compare', 'compareValue'=>0, 'operator'=>'>', 'on'=>'is_flash'),
			array('published, position, flash_width, flash_height, place_id, rotation_time', 'numerical', 'integerOnly'=>true),
			array('url', 'url', 'message'=>'Не верная ссылка. Не забываем указывать http://'),
            array('title, title_l2, title_l3, title_adm, published, published_l2, published_l3, from_time, to_time,
                   rotation_percent, url, url_l2, url_l3, text, text_l2, text_l3, text_en, flash_file,
                   views, type, code', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, image, url, text, text_en, place_id, published, position, flash_file, flash_width,
			 flash_height', 'safe', 'on'=>'search'),
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
            'place' => array(self::BELONGS_TO, 'BannerPlace', 'place_id'),
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
            'title_l2' => 'Название En',
            'title_adm' => 'Назв.(адм)',
			'image_tmp' => 'Изображение',
			'url' => 'Ссылка',
            'url_l2' => 'Ссылка En',
			'text' => 'Текст',
			'text_l2' => 'Текст En',
			'published' => 'Опубликовано',
            'published_l2' => 'Опубликовано En',
			'position' => 'Позиция',
            'rotation_percent'=>'Ротация %',
			'flash_file_tmp' => 'Flash Файл',
			'flash_width' => 'Flash Width',
			'flash_height' => 'Flash Height',
            'place_id'=>'Банерное место',
            'from_time'=>'Начало показа',
            'to_time'=>'Окончание показа',
            'views'=>'Просмотры:',
            'rotation_time'=>'Время показа',
            'type' => 'Тип',
            'code' => 'Код вставки',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
        $criteria->compare('t.title',$this->title,true);
        $criteria->compare('t.title_adm',$this->title_adm,true);
		$criteria->compare('t.image',$this->image,true);
		$criteria->compare('t.url',$this->url,true);
		$criteria->compare('t.text',$this->text,true);
        $criteria->compare('t.place_id',$this->place_id);
		$criteria->compare('t.published',$this->published);
		$criteria->compare('t.position',$this->position);
		$criteria->compare('t.flash_file',$this->flash_file,true);
		$criteria->compare('t.flash_width',$this->flash_width);
		$criteria->compare('t.flash_height',$this->flash_height);
        $criteria->compare('t.from_time>',CDateTimeParser::parse($this->from_time, 'dd-MM-yyyy'));
        $criteria->compare('t.to_time<',CDateTimeParser::parse($this->to_time, 'dd-MM-yyyy'));

        $criteria->with = 'place';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'place.title asc, position asc, t.id DESC'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}

    public function search_front()
    {
        // saved grid state (page sort ect.)
        // $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

        $criteria=new CDbCriteria;
        $criteria->compare('id',$this->id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
               'sort'=>array('defaultOrder'=>'id DESC'),
               'pagination'=>array('pageSize'=>Config::$data['base']->pageSizeFront)
        ));
    }

    public function getUrl(){
        //return Yii::app()->createUrl('module/controller/action', array('alias'=>$this->alias));
    }
    public function getClickUrl()
    {
        $rezult = '#';
        //if($this->url) $rezult = "/banner/go?u=".base64_encode($this->id);
        if($this->url) $rezult = "/banner/go?u=".($this->id);
        return $rezult;
    }

    public function afterFind()
    {
        parent::afterFind();
        /*$arr = explode('~', $this->metadata);
        $this->metaDesc = $arr[0];
        $this->metaKeys = $arr[1];*/
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord){
            $this->from_time = time();
            $this->to_time = time()+3600*24*100;
        }
        if($this->flash_file_tmp && $this->flash_file_tmp !='del_curr_image')
            $this->setScenario('is_flash');
        return parent::beforeValidate();
    }
    public function beforeSave()
    {
        //$this->metadata = $this->metaDesc.'~'.$this->metaKeys;

        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        $success = parent::beforeDelete();

        //CatalogItemRel::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public function view(){
        $view = new BannerView();
        $view->banner_id = $this->id;
        $view->ip_address = $_SERVER['REMOTE_ADDR'];
        $view->referer = $_SERVER['HTTP_REFERER'];
        $view->save();
    }

    const TYPE_BANNER = 0;
    const TYPE_TIZER = 1;
    public static function typeList($val = null){
        $arr =  array(
            self::TYPE_BANNER=>'Баннер',
            self::TYPE_TIZER=>'Тизер',
        );
        if($val !== null) return $arr[$val];
        else return $arr;
    }
}