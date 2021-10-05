<?php

/**
 * This is the model class for table "{{article_item}}".
 *
 * The followings are the available columns in table '{{article_item}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $cat_id
 * @property integer $published
 * @property integer $access_id
 * @property string $intro_text
 * @property string $full_text
 * @property integer $cdate
 * @property integer $mdate
 * @property integer $author_id
 * @property string $meta_key
 * @property string $meta_desc
 * @property integer $hits
 * @property integer $like
 * @property integer $unlike
 */
class ContentItem extends ActiveRecord
{
    public $image;
    public $catList = '';
    public $multiCat = true;
    public $cat_id=0;
    public $moderated = 0;

    public $moderate_apply = 0;

    public $image_tmp, $image_prev_tmp, $file_tmp;
    public $files_config = array(
        'image' => array(
            'path' => '/content/upload/content/item/', 'type' => 'image', 'time_dir' => false,
            'rule' => array('types' => 'jpg,jpeg,png,gif', 'maxSize' => 10, 'required' => true),
            'tmbs' => array(
                array('name' => 'normal', 'w' => 1200, 'h' => 1000, 'param' => self::RESIZE),
                array('name' => 'mid', 'w' => 320, 'h' => 240, 'param' => self::RESIZE_AND_CROP),
                array('name' => 'sml', 'w' => 120, 'h' => 80, 'param' => self::RESIZE_AND_CROP),
            )),
        'image_prev' => array(
            'path' => '/content/upload/content/item/', 'type' => 'image', 'time_dir' => false,
            'rule' => array('types' => 'jpg,jpeg,png,gif', 'maxSize' => 10, 'required' => false),
            'tmbs' => array(
                array('name' => 'mid', 'w' => 320, 'h' => 240, 'param' => self::RESIZE_AND_CROP),
                array('name' => 'sml', 'w' => 160, 'h' => 120, 'param' => self::RESIZE_AND_CROP),
            )),
        'file' => array(
            'path' => '/content/upload/content/item/file/', 'time_dir' => false,
            'rule' => array('types' => 'pdf', 'maxSize' => 10, 'required' => false),
        ),
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{content_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.

        return CMap::mergeArray(parent::rules(), array(
            array('title, full_text', 'required'),
            array('alias', 'unique'),
            array('cat_id, published, archived, access_id,  author_id, hits', 'numerical', 'integerOnly' => true),
            array('title, alias', 'length', 'max' => 255),
            array('title, title_l2, title_l3, alias, cat_id, published, published_l2, published_l3, catList,
                access_id, intro_text, intro_text_l2, intro_text_l3, full_text, full_text_l2, full_text_l3,
                image, file, cdate, mdate, author_id, hits, moderated, moderate_descr, moderate_apply', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alias, cat_id, published, access_id, intro_text, full_text, cdate, mdate, author_id, hits', 'safe', 'on' => 'search'),
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
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'category' => array(self::BELONGS_TO, 'ContentCategory', 'cat_id'),
            'tag' => array(self::MANY_MANY, 'ContentTag', 'tbl_content_item_tag(owner_id,item_id)'),
            'm_cat' => array(self::MANY_MANY, 'ContentCategory', 'tbl_content_item_cat(item_id,cat_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Заголовок',
            'title_l2' => 'Заголовок l2',
            'title_l3' => 'Заголовок l3',
            'alias' => 'Псевдоним',
            'cat_id' => 'Категория',
            'published' => 'Опубликовано',
            'published_l2' => 'Опубликовано l2',
            'published_l3' => 'Опубликовано l3',
            'access_id' => 'Доступ',
            'intro_text' => 'Краткое описание',
            'intro_text_l2' => 'Краткое описание l2',
            'intro_text_l3' => 'Краткое описание l3',
            'full_text' => 'Текст материала',
            'full_text_l2' => 'Текст материала l2',
            'full_text_l3' => 'Текст материала l3',
            'image_tmp' => 'Изображение:',
            'cdate' => 'Дата',
            'mdate' => 'Дата изменения',
            'author_id' => 'Автор',
            'hits' => 'Хиты',
            'archived' => 'В архиве',
            'file_tmp' => 'pdf файл',
            'moderated'=>Y::t('Проверено'),
            'moderate_descr'=>Y::t('Причина отказа'),
            'moderate_apply'=>Y::t('Причина отказа устранена'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($arc = 0)
    {
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName'] . $this->cat_id);

        $criteria = new CDbCriteria;
        $criteria->with = array();

        $criteria->compare('t.title', $this->title, true);

        //$criteria->compare('cat_id', $this->cat_id);
        if ( $this->cat_id > 0 && !$this->multiCat) { // для большого кол-ва катов - медленно
            $cat = ContentCategory::model()->findByPk($this->cat_id);
            $rows = ContentCategory::model()->findAll('lft>=' . $cat->lft . ' and rgt<=' . $cat->rgt);
            foreach ($rows as $row) $cats[] = $row->id;
            $criteria->addInCondition('t.cat_id', $cats);
        }

        if($this->multiCat){
            $criteria->with[] = 'm_cat';
            $criteria->together = true;
            $criteria->group = 't.id';
            $criteria->compare('m_cat.id', $this->cat_id);
        }

        $criteria->compare('t.published', $this->published);
        $criteria->compare('mdate', $this->mdate);
        $criteria->compare('hits', $this->hits);
        $criteria->compare('archived', $arc);
        $criteria->compare('author_id', $this->author_id);
        if ($this->cdate) {
            $criteria->addBetweenCondition('cdate',
                CDateTimeParser::parse($this->cdate, 'dd.MM.yyyy'),
                CDateTimeParser::parse($this->cdate, 'dd.MM.yyyy') + 60 * 60 * 24
            );
        }

        $criteria->with[] = 'category';
        $criteria->with[] = 'author';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'author_id' => array( 'asc'=>$expr = 'author.username', 'desc'=>$expr.' DESC' ),
                    'id', 'title', 'published', 'cdate', 'hits'
                ),
                'defaultOrder' => 'cdate DESC'
            ),
            'pagination' => array('pageSize' => Config::$data['base']->pageSize)
        ));
    }

    public function search_simple()
    {
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName'] . $this->cat_id);
        $criteria = new CDbCriteria;
        $criteria->compare('t.title', $this->title, true);
        //$criteria->compare('t.published', $this->published);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'cdate DESC'),
            //'pagination' => array('pageSize' => Config::$data['base']->pageSize)
        ));
    }

    public function search_front($arc = 0)
    {
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName']);

        $criteria = new CDbCriteria;

        $criteria->compare('t.published', 1);
        $criteria->compare('t.cat_id', $this->cat_id);

        /* =============== key ===================================*/
        $keys = explode(' ', $_GET['key']);
        foreach($keys as $i=>$key){
            if($i > 2) break;
            $criteria->compare('t.name', $key,true);
            $criteria->compare('t.descr',$key,true, 'or');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'cdate DESC'),
            'pagination' => array('pageSize' => 10)
        ));
    }

    public function searchByTag($tag_id)
    {
        // saved grid state (page sort ect.)
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName'].$tag_id);

        $criteria = new CDbCriteria;
        $criteria->with = array('tag');
        $criteria->together = true;
        $criteria->compare('tag.id', $tag_id);
        $criteria->compare('t.published', 1);
        $criteria->order = 't.cdate DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.cdate DESC'),
            'pagination' => array('pageSize' => Config::$data['base']->pageSize)
        ));
    }

    public function searchByCatId($cat_id = 0)
    {
        $criteria = new CDbCriteria;

        $criteria->compare('title', $this->title, true);
        $criteria->compare('cat_id', $cat_id ? $cat_id : $this->cat_id);
        $criteria->compare('published', $this->published);
        $criteria->compare('mdate', $this->mdate);
        $criteria->compare('hits', $this->hits);
        $criteria->compare('archived', $this->archived);
        $criteria->compare('author_id', $this->author_id);
        if ($this->cdate) {
            $criteria->addBetweenCondition('cdate',
                CDateTimeParser::parse($this->cdate, 'dd.MM.yyyy'),
                CDateTimeParser::parse($this->cdate, 'dd.MM.yyyy') + 60 * 60 * 24
            );
        }
        $criteria->with = array('author', 'category');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'author_id' => array(
                        'asc' => $expr = 'author.username',
                        'desc' => $expr . ' DESC',
                    ),
                    'title', 'published', 'cdate', 'hits'
                ),
                'defaultOrder' => 'cdate DESC'
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('content/item/view', array('alias' => $this->alias));
    }
    public function getTagUrl($tag_id)
    {
        return Yii::app()->createUrl('content/item/listByTag', array('tag_id' => $tag_id));
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->multiCat) {
            $this->catList = implode(',', ContentItemCat::getCats($this->id));
        }

        if(Y::app()->params['cfgName']=='frontend'){
            $this->full_text = str_replace('<sscript',  '<script', $this->full_text);
            $this->full_text = str_replace('</sscript>',  '</script>', $this->full_text);
        }
    }

    public function afterSave()
    {
        parent::afterSave();

        if ($this->multiCat && $this->catList !='')
        {
            ContentItemCat::model()->deleteAll('item_id=' . $this->id);
            $arr = explode(',', $this->catList);
            foreach ($arr as $elem) {
                $rel = new ContentItemCat();
                $rel->item_id = $this->id;
                $rel->cat_id = $elem;
                $rel->save();
            }
        }
    }

    public function beforeSave()
    {
        if($this->moderate_apply){
            $this->moderated = self::MODERATED_NONE;
            $this->moderate_descr = '';
        }
        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->cdate = $this->cdate ? $this->cdate : time();
            $this->author_id = Yii::app()->user->id;
        }
        $this->mdate = time();
        if ($this->alias == '') $this->alias = Y::translitIt($this->title);
        return parent::beforeValidate();
    }

    protected function afterValidate()
    {
        parent::afterValidate();

    }

    public function beforeDelete()
    {
        $success = parent::beforeDelete();
        ContentItemCat::model()->deleteAll('item_id='.$this->id);
        ContentItemRel::model()->deleteAll('owner_id='.$this->id);
        ContentItemTag::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public function commentNum(){
        return Comments::model()->count(
            'item_id='.$this->id.' and model_key='.Comments::CONTENT_ITEM.' and published=1');
    }

    public static function getByCatId($cat_id){
        $cr = new CDbCriteria();
        $cr->compare('t.published',1);
        $cr->compare('t.cat_id',$cat_id);
        $cr->order = 't.cdate desc';
        //$cr->limit = 20;
        return self::model()->findAll($cr);
    }

    /* select categorized-item for multicat*/
    public static function getarticlesOnMain(){
        $cr = new CDbCriteria();
        $cr->compare('t.published',1);
        $cr->order = 't.cdate desc';
        //$cr->limit = 20;
        $cr->with[] = 'm_cat';
        $cr->together = true;
        $cr->group = 't.id';
        $cr->compare('m_cat.id', 31);
        return self::model()->findAll($cr);
    }


    /* get category-data from item for multicat*/
    public static $article_cats = null;
    public function articleCat()
    {
        if(self::$article_cats == null){
            $category=ContentCategory::model()->findByPk(31);
            foreach($category->children()->findAll() as $elem)
                self::$article_cats[] = $elem->id;
        }
        $cr = new CDbCriteria();
        $cr->compare('item_id',$this->id);
        $cr->addInCondition('cat_id', self::$article_cats);
        $rel = ContentItemCat::model()->find($cr);
        return ContentCategory::byPK($rel->cat_id);
    }
}