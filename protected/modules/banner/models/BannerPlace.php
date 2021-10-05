<?php

/**
 * This is the model class for table "{{banner_place}}".
 *
 * The followings are the available columns in table '{{banner_place}}':
 * @property integer $id
 * @property string $title
 */
class BannerPlace extends ActiveRecord
{
    public $published = 1;
    public $position = 0;
    public $elem_cnt = 0;
    public $width = 0;
    public $height = 0;
    public $title_lim = 0;
    public $descr_lim = 0;

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{banner_place}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('title_adm', 'required'),
            array('title, title_adm, stretches, width, height, title_lim, descr_lim,
                type, bg_color, comment', 'safe'),
            array('elem_cnt', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Имя позиции',
            'title_adm' => 'Имя поз.(адм)',
            'stretches'=>'Отображать',
            'elem_cnt' => 'Кол-во баннеров',
            'width' => 'Ширина баннера',
            'height' => 'Высота баннера',
            'title_lim' => 'Макс. символов в заголовке',
            'descr_lim' => 'Макс. символов в описании',
            'type' => 'Тип',
            'bg_color' => 'Цвет фона(FFFFFF)',
            'comment'=>'Коментарий'
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		 $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('title_adm',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'id DESC'),
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

    protected function afterFind()
    {
        parent::afterFind();
    }

    protected function beforeValidate()
    {
        return parent::beforeValidate();
    }
    public function afterValidate(){
        parent::afterValidate();
        //if($this->hasErrors()){ $this->cdate = null; }
    }

    protected function beforeSave()
    {
        //if ($this->isNewRecord){$this->create_time = time();}
        return parent::beforeSave();
    }

    protected function beforeDelete()
    {
        $success = parent::beforeDelete();

        //Model::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public static function getListRaw($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        return self::model()->findAll($criteria);
    }
    public static function getList($limit = -1){
        $criteria=new CDbCriteria;
        $criteria->order = 'title asc';
        $criteria->limit = $limit;
        //return CMap::mergeArray(array(''=>''),CHtml::listData(self::model()->findAll($criteria),'id','title'));
        return CHtml::listData(self::model()->findAll($criteria),'id','title_adm');
    }


}