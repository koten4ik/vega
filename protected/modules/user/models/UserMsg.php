<?php

/**
 * This is the model class for table "{{user_msg}}".
 *
 * The followings are the available columns in table '{{user_msg}}':
 * @property integer $id
 * @property integer $c_time
 * @property integer $user_id
 * @property integer $group_id
 * @property string $text
 */
class UserMsg extends ActiveRecord
{

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{user_msg}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('c_time, user_id, group_id, text, readed', 'safe'),
			array('c_time, user_id, group_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, c_time, user_id, group_id, text', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'c_time' => 'C Time',
			'user_id' => 'User',
			'group_id' => 'Group',
			'text' => 'Text',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('c_time',$this->c_time);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('text',$this->text,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'t.id DESC'),
            'pagination'=>array('pageSize'=>Config::get()->pageSize)
		));
	}

    public function search_front()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('t.id',$this->id);
        $criteria->compare('t.group_id',$this->group_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'t.id DESC'),
            'pagination'=>array('pageSize'=>Config::get()->pageSizeFront)
        ));
    }

    public function getUrl(){
        //return Yii::app()->createUrl('/module/controller/action', array('id'=>$this->id));
    }

    protected function afterFind(){
        parent::afterFind();
    }

    protected function beforeValidate(){
        return parent::beforeValidate();
    }
    public function afterValidate(){
        parent::afterValidate();
    }

    protected function beforeSave(){
        //if ($this->isNewRecord){};
        return parent::beforeSave();
    }

    protected function beforeDelete(){
        $success = parent::beforeDelete();
        //Model::model()->deleteAll('owner_id='.$this->id);
        return $success;
    }

    public static function getList($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'order_field';
        $criteria->limit = $limit;
        return CHtml::listData(self::model()->findAll($criteria),'id','field');
    }

    public static function noReadedAllCnt(){
        return count(self::model()->findAll( 'readed=0 and user_id!='.Y::user_id() ));
    }
    public static function noReadedCnt($group_id){
        return count(self::model()->findAll( 'group_id='.$group_id.' and readed=0 and user_id!='.Y::user_id() ));
    }

    public static function sendByGroup($group_id,$text)
    {
        $model = new UserMsg();
        $model->group_id = $group_id;
        $model->text = $text;
        $model->save();
    }
    public static function sendByUser($user_id,$text)
    {
        $group=UserMsgGroup::loadGroupByUser($user_id);
        UserMsg::sendByGroup($group->id,$text);
    }
}