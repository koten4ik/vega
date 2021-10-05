<?php

/**
 * This is the model class for table "{{menu}}".
 *
 * The followings are the available columns in table '{{menu}}':
 * @property string $id
 * @property string $lft
 * @property string $rgt
 * @property integer $level
 * @property string $title
 * @property string $title_l2
 * @property string $title_l3
 * @property string $rule
 * @property string $rule2
 * @property string $rule3
 * @property string $descr
 * @property string $image
 * @property integer $published
 * @property integer $published_l2
 * @property integer $published_l3
 * @property string $metadata
 * @property string $params
 */
class MenuItem extends ActiveRecord
{
    public $published = 1;
    public $parentId;
    public $notDeleted;

    public $cat_id;

    public $image_tmp;
    public $files_config = array(
        'image'=>array(
            'path'=>'/content/upload/menu/item/', 'type'=>'image', 'time_dir'=>false,
            'rule'=>array('types'=>'jpg,jpeg,png,gif','maxSize'=>10, 'required'=>false),
            'tmbs'=>array(
                array('name'=>'mid','w'=>300,'h'=>300,'param'=>self::RESIZE),
                array('name'=>'sml','w'=>100,'h'=>100,'param'=>self::RESIZE),
        )),
    );

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{menu}}'; }

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

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
            array('title', 'required'),
			array('lft, rgt, level, title, title_l2, title_l3, menu_id, smenu_id, url, rule1, rule2, rule3, descr, image,
			    published_l2, published_l3, metadata, params, css_class', 'safe'),
			array('level, published', 'numerical', 'integerOnly'=>true),
			array('lft, rgt', 'length', 'max'=>10),
			array('title', 'length', 'max'=>150),
			array('title_l2, title_l3, rule1, rule2, rule3, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lft, rgt, level, title, title_l2, title_l3, rule1, rule2, rule3, descr, image, published, published_l2, published_l3, metadata, params', 'safe', 'on'=>'search'),
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
			'lft' => 'Lft',
			'rgt' => 'Rgt',
			'level' => 'Level',
            'title' => 'Имя',
            'url' => 'Ссылка',
            'descr' => 'Описание',
            'published' => 'Опубликовано',
            'image_tmp' => 'Изображение:',
			'rule1' => 'Правило',
			'rule2' => 'Правило 2',
			'rule3' => 'Правило 3',
			'metadata' => 'Metadata',
			'params' => 'Params',
            'menu_id' => 'menu_id',
            'smenu_id' => 'smenu_id',
		);
	}

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

        /*if( $this->alias == 'root'
            //||  $this->alias == 'articles'
        ) $this->notDeleted = true;*/
    }
    public function _beforeSave()
    {
        //if($this->alias == '') $this->alias = Y::translitIt($this->title);
    }
}