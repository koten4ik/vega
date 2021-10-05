<?php
/**
 * The followings are the available columns in table '{{igallery_image}}':
 * @property integer $id
 * @property integer $item_id
 * @property string $image
 * @property integer $position
 * @property integer $published
 */
class IgalleryItemImage extends ActiveRecord
{
    public $published = 1;

    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/igallery/item/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'normal','w'=>1200,'h'=>1000,'param'=>self::RESIZE),
                array('name'=>'mid','w'=>640,'h'=>480,'param'=>self::RESIZE_AND_CROP),
                array('name'=>'sml','w'=>240,'h'=>160,'param'=>self::RESIZE_AND_CROP),
        )),
    );

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{igallery_image}}';
	}

	public function rules()
	{
        return CMap::mergeArray(parent::rules(),array(
			array('item_id', 'required'),
			array('item_id, position', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
            array('id, item_id, image, position, published, descr, descr_l2, descr_l3', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, item_id, image, position', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'image' => 'Изображение',
			'position' => 'Сорт.',
            'published' => 'Опубл.',
            'descr'=>'Описание'
		);
	}

	public function search($item_id)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item_id',$item_id);
		$criteria->compare('image',$this->image,true);
		//$criteria->compare('position',$this->position);
        //$criteria->order = 'position';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array('pageSize'=>8),
            'sort'=>array('defaultOrder'=>'position desc, id desc'),
		));
	}

    public static function getList($item_id)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('item_id',$item_id);
        $criteria->compare('published',1);
        $criteria->order = 'position desc, id desc';
        //$criteria->limit = 5;
        return self::model()->findAll($criteria);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            if($this->position == 0)
                $this->position = count(self::findAll('item_id='.$this->item_id.' order by id desc'))+1;
        }
        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        parent::beforeDelete();

        return true;
    }
}