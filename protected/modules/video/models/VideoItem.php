<?php

/**
 * This is the model class for table "{{video_item}}".
 *
 * The followings are the available columns in table '{{video_item}}':
 * @property integer $id
 * @property string $title
 * @property integer $c_time
 * @property integer $u_time
 * @property integer $user_id
 * @property integer $published
 * @property integer $position
 * @property string $url
 * @property integer $date
 * @property integer $views
 * @property string $image
 */
class VideoItem extends ActiveRecord
{
    public $catList = '';
    public $cat_id = 0;

    public $image_tmp;
    public $files_config = array(
        'image' => array(
            'path' => '/content/upload/video/item/', 'type' => 'image', 'time_dir' => false,
            'rule' => array('types' => 'jpg,jpeg,png,gif', 'maxSize' => 10, 'required' => false),
            'tmbs' => array(
                array('name' => 'normal', 'w' => 1200, 'h' => 1000, 'param' => self::RESIZE),
                array('name' => 'mid', 'w' => 320, 'h' => 180, 'param' => self::RESIZE_AND_CROP),
                array('name' => 'sml', 'w' => 160, 'h' => 90, 'param' => self::RESIZE_AND_CROP),
            )),

    );

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{video_item}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
            array('title', 'required'),
			array('title, title_l2, title_l3, intro_text, intro_text_l2, intro_text_l3, full_text, full_text_l2, full_text_l3,
			    c_time, u_time, user_id, published, position, url, date, views, image, catList, media_code', 'safe'),
			array('c_time, u_time, user_id, published, position, date, views', 'numerical', 'integerOnly'=>true),
			array('title, url, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, c_time, u_time, user_id, published, position, url, date, views, image', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'm_cat' => array(self::MANY_MANY, 'VideoCategory', 'tbl_video_item_cat(item_id,cat_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'title' => 'Заголовок',
            'title_l2' => 'Заголовок l2',
            'title_l3' => 'Заголовок l3',
			'c_time' => 'C Time',
			'u_time' => 'U Time',
			'user_id' => 'User',
			'published' => 'Опубликовано',
			'position' => 'Position',
			'url' => 'Ютуб-ссылка',
            'media_code' => 'Код видео',
			'date' => 'Дата',
            'intro_text' => 'Краткое описание',
            'intro_text_l2' => 'Краткое описание l2',
            'intro_text_l3' => 'Краткое описание l3',
            'full_text' => 'Текст материала',
            'full_text_l2' => 'Текст материала l2',
            'full_text_l3' => 'Текст материала l3',
			'views' => 'Просмотры',
			'image_tmp' => 'Изображение',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('c_time',$this->c_time);
		$criteria->compare('u_time',$this->u_time);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('published',$this->published);
		$criteria->compare('position',$this->position);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('date',$this->date);
		$criteria->compare('views',$this->views);
		$criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'t.date DESC'),
            'pagination'=>array('pageSize'=>Config::get()->pageSize)
		));
	}


    public function search_front($cur_elem=0)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.published',1);

        //для расчета страници в списке, поле должно совпадать с defaultOrder
        if($cur_elem) $criteria->compare('t.date>',$cur_elem->date);

        if($this->cat_id){
            $criteria->with[] = 'm_cat';
            $criteria->together = true;
            $criteria->group = 't.id';
            $criteria->compare('m_cat.id', $this->cat_id);
        }

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'t.date DESC'),
            // !!! для расчета страници в списке pageSize увеличить
            'pagination'=>array('pageSize'=> $cur_elem ? 100 : 10 )
        ));
    }

    public function getUrl(){
        return Yii::app()->createUrl('/video/item/view', array('id'=>$this->id));
    }
    public function getUtkey(){
        $v = parse_url($this->url,PHP_URL_QUERY);
        parse_str($v,$v);
        return $v['v'];
    }

    protected function afterFind(){
        $this->catList = implode(',', VideoItemCat::getCats($this->id));
        parent::afterFind();
    }

    protected function beforeValidate()
    {
        $fname = '/content/upload/temp/video.jpg';
        @copy('https://img.youtube.com/vi/'.$this->utkey.'/maxresdefault.jpg', $_SERVER['DOCUMENT_ROOT'].$fname);
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$fname))
            $this->image_tmp = $fname;

        return parent::beforeValidate();
    }
    public function afterValidate(){
        parent::afterValidate();
    }

    public function afterSave()
    {
        if (1)
        {
            VideoItemCat::model()->deleteAll('item_id=' . $this->id);
            $arr = explode(',', $this->catList);
            foreach ($arr as $elem) {
                $rel = new VideoItemCat();
                $rel->item_id = $this->id;
                $rel->cat_id = $elem;
                $rel->save();
            }
        }
    }

    protected function beforeSave(){
        if ($this->isNewRecord){ if($this->date==0) $this->date = time(); };
        return parent::beforeSave();
    }

    protected function beforeDelete(){
        $success = parent::beforeDelete();
        VideoItemCat::model()->deleteAll('item_id='.$this->id);
        //Model::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public static function getList($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'order_field';
        $criteria->limit = $limit;
        return CHtml::listData(self::model()->findAll($criteria),'id','field');
    }

    public function catNames(){
        $names = array();
        foreach(VideoItemCat::getCats($this->id) as $elem)
            if($elem!=1)$names[] = VideoCategory::byPK($elem)->title;
        return '<span style="font-size:80%;">'.implode(',<br>',$names ).'</span>';
    }
}