<?php

/**
 * This is the model class for table "{{catalog_item}}".
 *
 * The followings are the available columns in table '{{catalog_item}}':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $model
 * @property integer $sku
 * @property double $price
 * @property double $price_type
 * @property double $price_main
 * @property integer $price_stock
 * @property integer $price_special
 * @property integer $count
 * @property integer $cat_id
 * @property integer $manuf_id
 * @property integer $published
 * @property string $descr
 * @property string $position
 * @property string $image
 * @property string $video
 * @property integer $cdate
 * @property integer $mdate
 * @property string $metadata
 * @property integer $demand
 * @property double rating_sum
 * @property integer rating_cnt
 * @property integer $hits
 */
class CatalogItem extends ActiveRecord implements IECartPosition
{
    public $price = 0;
    public $rating;

    // castom by user vals
    public $optionsData;
    public $quantity;

    const PRICE_MAIN = 0;
    const PRICE_SPECIAL = 1;
    const PRICE_STOCK = 2;

    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/shop/item/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'mid','w'=>200,'h'=>160,'param'=>self::RESIZE),
            )
        ),
    );

	public static function model($className=__CLASS__){
		return parent::model($className);
	}

    function getId(){ return 'CatalogItem'.$this->id.$this->optionsData; }

    public function getPrice(){

        //if($this->category->alias == 'reserve') return 0;
        $options_price = 0;
        $arr = explode('^',$this->optionsData);
        foreach($arr as $elem){
            $a = explode(';',$elem);
            $options_price += $a[1];
        }
        if($this->price_special > 0) return $this->price_special+$options_price;
        else return $this->price_main+$options_price;
    }
    public function selectedOptions(){
        $arr = explode('^',$this->optionsData);
        foreach($arr as $elem){
            $a = explode(';',$elem);
            if(!$a[0]) continue;
            $ids[] = $a[0];
        }
        $cr = new CDbCriteria();
        $cr->order = 'optionVal.position, option.position';
        $cr->with = array('option', 'optionVal');
        $elems = CatalogItemOption::model()->findAllByPk($ids, $cr);
        foreach($elems as $elem)
            echo $elem->option->title.': '.$elem->optionVal->value.' '.$elem->option->sufix.'<br>';
        //VarDumper::dump($ids);
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()	{
		return '{{catalog_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('name, cat_id', 'required'),
            array('alias','unique'),
			array('sku, count, cat_id, manuf_id, published, price_type, cdate, mdate, hits', 'numerical', 'integerOnly'=>true),
			array('price, price_main, price_special, price_stock', 'numerical'),
			array('name, alias', 'length', 'max'=>150),
			array('model, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('name, alias, model, sku, price, count, cat_id, manuf_id, published, descr, position, price_type, image, video, cdate, mdate, demand, hits, rating_sum, rating_cnt', 'safe'),
			array('id, name, alias, model, sku, price, count, cat_id, manuf_id, published, descr, image, cdate, mdate, metadata, hits', 'safe', 'on'=>'search'),
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
            'category'=>array(self::BELONGS_TO, 'CatalogCategory', 'cat_id'),
            'manufacturer'=>array(self::BELONGS_TO, 'CatalogManufacturer', 'manuf_id'),
            //'manufacturer'=>array(self::BELONGS_TO, 'CatalogManufacturer', 'manuf_id'),
            //'attrGroup'=>array(self::BELONGS_TO, 'CatalogAttrGroup', 'attr_group_id'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'alias' => 'Псевдоним',
			'model' => 'Модель',
			'sku' => 'Артикул',
			'price' => 'Цена',
            'price_main' => 'Основная цена',
            'price_special'=>'Спецпредложение.',
            'price_stock'=>'Акция',
			'count' => 'Кол-во',
			'cat_id' => 'Категория',
			'manuf_id' => 'Производитель',
			'published' => 'Опубликован',
			'descr' => 'Описание',
            'position' => 'Позиция',
			'image_tmp' => 'Изображение',
            'video' => 'Видео',
			'cdate' => 'Дата',
			'mdate' => 'Дата изменения',
            'demand' => 'Голоса',
            'hits' => 'Просм.',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
        if($_GET['rel_search_item_name'])
            $criteria->compare('t.name',$_GET['rel_search_item_name'],true);
		else $criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.alias',$this->alias,true);
		$criteria->compare('t.model',$this->model,true);
		$criteria->compare('t.sku',$this->sku);

		$criteria->compare('t.price',$this->price);

		$criteria->compare('t.count',$this->count);

        //$criteria->compare('t.cat_id', $this->cat_id);
        if($this->cat_id){ // для большого кол-ва катов - медленно
            $cat = CatalogCategory::model()->findByPk($this->cat_id);
            $rows = CatalogCategory::model()->findAll('lft>='.$cat->lft.' and rgt<='.$cat->rgt);
            foreach($rows as $row) $cats[] = $row->id;
            $criteria->addInCondition('t.cat_id',$cats);
        }

		$criteria->compare('t.manuf_id',$this->manuf_id);
		$criteria->compare('t.published',$this->published);
        $criteria->compare('t.price_special',$this->price_special);
        $criteria->compare('t.price_stock',$this->price_stock);
		$criteria->compare('t.descr',$this->descr,true);
        $criteria->compare('t.position',$this->position);
		$criteria->compare('t.image',$this->image,true);
		$criteria->compare('t.cdate',$this->cdate);
		$criteria->compare('t.mdate',$this->mdate);
		$criteria->compare('t.metadata',$this->metadata,true);
		$criteria->compare('t.hits',$this->hits);

        $criteria->with = array( 'category' );

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position, cdate desc'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
        ));
	}

    public function front_search()
   	{
   		$criteria=new CDbCriteria;

   		$criteria->compare('t.id',$this->id);
   		$criteria->compare('t.name',$this->name,true);
   		$criteria->compare('t.alias',$this->alias,true);
   		$criteria->compare('t.model',$this->model,true);
   		//$criteria->compare('t.sku',$this->sku);
        $criteria->compare('t.count',$this->count);
        $criteria->compare('t.cat_id',$this->cat_id);
        $criteria->compare('t.manuf_id',$this->manuf_id);
        $criteria->compare('t.published',1);
        $criteria->compare('t.hits',$this->hits);
        $criteria->compare('t.position',$this->position);

        /* =============== key ===================================*/
        $keys = explode(' ', $_GET['key']);
        foreach($keys as $i=>$key){
            if($i > 2) break;
            $criteria->compare('t.name', $key,true);
            $criteria->compare('t.descr',$key,true, 'or');
        }

        /* =============== adv ===================================*/
        $condition = $_GET['filter_price_from'] > 0 ? 'price >= '.$_GET['filter_price_from'] : '';
        $criteria->mergeWith(new CDbCriteria(array('condition'=>$condition)));
        $condition = $_GET['filter_price_to'] > 0 ? 'price <= '.$_GET['filter_price_to'] : '';
        $criteria->mergeWith(new CDbCriteria(array('condition'=>$condition)));

        if($_GET['adv_search'])
        {
            foreach(CatalogAttribute::getList() as $attr){
                $condition = '';
                if($attr->type == 1){
                    foreach( CatalogAttrVal::getList($attr->id) as $value)
                       if($_GET['filter-'.$attr->id.'-'.$value->id])
                           $condition .= ($condition == '' ? '' : ' OR ').'attr'.$attr->id.' = "'.$value->value.'"';
                    $criteria->mergeWith(new CDbCriteria(array('condition'=>$condition)));
                }
                if($attr->type == 2){
                    if($_GET['filter-'.$attr->id] > 0)
                        $condition .= 'attr'.$attr->id.' = '.$_GET['filter-'.$attr->id];
                    $criteria->mergeWith(new CDbCriteria(array('condition'=>$condition)));
                }
                if($attr->type == 3){
                    $condition = $_GET['filter-'.$attr->id.'_from'] > 0 ? 'attr'.$attr->id.' >= '.$_GET['filter-'.$attr->id.'_from'] : '';
                    $criteria->mergeWith(new CDbCriteria(array('condition'=>$condition)));
                    $condition = $_GET['filter-'.$attr->id.'_to'] > 0 ? 'attr'.$attr->id.' <= '.$_GET['filter-'.$attr->id.'_to'] : '';
                    $criteria->mergeWith(new CDbCriteria(array('condition'=>$condition)));
                }
            }
        }

        /* для выпад. скиска сортировка
        $order = 't.cdate DESC';
        if(Y::cookie('sort_select')) $order = 't.'.str_replace( '.',' ',Y::cookie('sort_select') ).', '.$order;
        $criteria->order = $order;*/

        $criteria->with = array( 'category' );

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position, cdate desc'),
            'pagination'=>array('pageSize'=>
                Y::cookie('listPageSize') > 0 ? Y::cookie('listPageSize') : Config::$data['base']->pageSizeFront)
        ));
   	}

    public function rel_search()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('t.published',1);

        $rels = CatalogItemRel::model()->findAll('owner_id='.$this->id);
        foreach($rels as $elem) $list[] = $elem->item_id;
        $criteria->addInCondition('id',$list);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'position, cdate desc'),
            'pagination'=>array('pageSize'=>isset($_GET['p_all']) ? 1000:3)
        ));
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->calcRating();
    }
    public function calcRating(){
        if($this->rating_cnt)
            $this->rating = round(($this->rating_sum / $this->rating_cnt), 0);
    }

    public function beforeSave()
    {

        switch($this->price_type){
            case self::PRICE_MAIN:    $this->price = $this->price_main;    break;
            case self::PRICE_SPECIAL: $this->price = $this->price_special; break;
            case self::PRICE_STOCK:   $this->price = $this->price_stock;   break;
        }

        // fill attributes
        $attribs = CatalogAttribute::getList(-1);
        foreach($attribs as $attrib){
            $attrName = 'attr'.$attrib->id;
            $post = $_POST['CatalogItem'][$attrName];
            if(isset($post)) $this->$attrName = $post;
        }

        //$this->name = str_replace ( '"', "'", $this->name );

        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        parent::beforeDelete();

        CatalogItemRel::model()->deleteAll('owner_id='.$this->id);
        CatalogItemOption::model()->deleteAll('item_id='.$this->id);

        $images = CatalogItemImage::model()->findAll('item_id='.$this->id);
        foreach($images as $elem) $elem->delete();

        return true;
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->cdate = time();
            $this->mdate = time();

        }
        $this->mdate = time();
        if($this->alias == '') $this->alias = Y::translitIt($this->name);
        return parent::beforeValidate();
    }

    public function afterValidate()
    {
        parent::afterValidate();

        if($this->hasErrors())
        {
            $this->cdate = null;
            $this->mdate = null;
        }
    }

    public static  function getFeaturedList()
    {
        return CatalogItem::model()->findAll('price_type ='.self::PRICE_SPECIAL);
    }


    public static  function getByCatAlias($alias)
    {
        $category = CatalogCategory::model()->find('alias=:al', array(':al'=>$alias));
        return CatalogItem::model()->findAll('cat_id ='.$category->id);
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('shop/item/view', array('i_id'=>$this->id, 'i_alias'=>$this->alias));
    }

    private static $currentItem = null;
    public static function getCurrent(){
        if( self::$currentItem == null && isset($_GET['i_id']) )
            self::$currentItem = self::model()->find('id=:id',array(':id'=>$_GET['i_id']));
        return self::$currentItem;
    }

    public function getServerVideo(){
        if(!$this->video) return false;
        if( stripos($this->video, 'http://www.youtube.com') == false )
            return $this->video;
        return false;
    }
    public function getYoutubeVideo(){
        if(!$this->video) return false;
        if( stripos($this->video, 'http://www.youtube.com') )
            return $this->video;
        return false;
    }

    public function getOptions()
    {
        $cr = new CDbCriteria();
        $cr->compare('item_id',$this->id);
        $cr->order = 'optionVal.position, option.position';
        $cr->with = array('option', 'optionVal');
        $elems = CatalogItemOption::model()->findAll($cr);
        $options = array();
        foreach($elems as $elem)
            if(!in_array($elem->option_id,$options))
                $options[$elem->option_id] = array();
        foreach($options as $key=>$option)
            foreach($elems as $elem)
                if($key == $elem->option_id) $options[$key][] = $elem;

        return $options;
    }
}