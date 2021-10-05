<?php

/**
 * This is the model class for table "{{content_page}}".
 *
 * The followings are the available columns in table '{{content_page}}':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $text
 * @property integer $published
 * @property string $metadata
 */
class ContentPage extends ActiveRecord
{
    public $published = 1;

    public $image_tmp;
    public $files_config = array(
        'image' => array(
            'path' => '/content/upload/content/page/', 'type' => 'image', 'time_dir' => false,
            'rule' => array('types' => 'jpg,jpeg,png,gif', 'maxSize' => 10, 'required' => false),
            'tmbs' => array(
                array('name' => 'normal', 'w' => 1200, 'h' => 1000, 'param' => self::RESIZE),
                array('name' => 'mid', 'w' => 500, 'h' => 500, 'param' => self::RESIZE_AND_CROP),
                array('name' => 'sml', 'w' => 100, 'h' => 100, 'param' => self::RESIZE_AND_CROP),
            )),
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
        return '{{content_page}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return CMap::mergeArray(parent::rules(), array(
            array('title_adm', 'required'),
            array('alias', 'unique'),
            array('published', 'numerical', 'integerOnly' => true),
            array('title, alias, module_id', 'length', 'max' => 255),
            array('title, title_l2, title_l3, alias, text, text_l2, text_l3,
                    published, published_l2, published_l3, in_menu, title_adm', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, alias, text, published, metadata', 'safe', 'on' => 'search'),
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
            'title' => 'Заголовок H1 (на сайте)',
            'title_l2' => 'Заголовок H1  l2',
            'title_l3' => 'Заголовок H1  l3',
            'title_adm'=>'Название (в админке)',
            'alias' => 'Псевдоним',
            'image_tmp' => 'Изображение:',
            'published' => 'Опубликовано',
            'published_l2' => 'Опубликовано l2',
            'published_l3' => 'Опубликовано l3',
            'text' => 'Текст страницы',
            'text_l2' => 'Текст страницы l2',
            'text_l3' => 'Текст страницы l3',
            'in_menu' => 'Отображать в меню',
            'module_id' => 'Модуль'
        );
    }

    public function afterFind()
    {
        parent::afterFind();
        if (Y::app()->params['cfgName'] == 'frontend') {
            $this->text = str_replace('<sscript', '<script', $this->text);
            $this->text = str_replace('</sscript>', '</script>', $this->text);
        }
    }

    public function beforeSave()
    {

        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if ($this->alias == '') $this->alias = Y::translitIt($this->title);
        return parent::beforeValidate();
    }

    public function search()
    {
        $this->StateProcess(get_class($this) . '_' . Y::app()->params['cfgName']);
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('published', $this->published);
        $criteria->compare('metadata', $this->metadata, true);
        $criteria->compare('module_id', $this->module_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => Config::$data['base']->pageSize)
        ));
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('content/item/view', array('alias' => $this->alias));
    }

    public static function getMenu()
    {
        return self::model()->findAll('in_menu=1');
    }

    public static function modules()
    {
        $arr = array();
        foreach (yii::app()->modules as $id => $elem)
            $arr[$id] = $id;

        unset($arr['gii']);
        unset($arr['base']);
        unset($arr['files']);
        unset($arr['menu']);

        return $arr;
    }

    public static function getByAlias($alias)
    {
        $model=self::model()->find('alias=:al', array(':al'=>$alias));
        return $model;
    }

}