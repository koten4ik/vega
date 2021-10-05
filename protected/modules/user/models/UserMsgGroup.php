<?php

/**
 * This is the model class for table "{{user_msg_group}}".
 *
 * The followings are the available columns in table '{{user_msg_group}}':
 * @property integer $id
 * @property integer $c_time
 * @property integer $user_id
 * @property integer $user_id2
 * @property integer $s_group_id
 * @property integer $position
 */
class UserMsgGroup extends ActiveRecord
{

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '{{user_msg_group}}'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
			array('c_time, user_id, user_id2, s_group_id, position', 'safe'),
			array('c_time, user_id, user_id2, s_group_id, position', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, c_time, user_id, user_id2, s_group_id, position', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'user2' => array(self::BELONGS_TO, 'User', 'user_id2'),
            'last_msg' => array(self::HAS_ONE, 'UserMsg', 'group_id', 'order'=>'last_msg.c_time DESC',),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'c_time' => 'C Time',
			'user_id' => 'User',
			'user_id2' => 'User Id2',
			's_group_id' => 'S Group',
			'position' => 'Position',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('c_time',$this->c_time);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_id2',$this->user_id2);
		$criteria->compare('s_group_id',$this->s_group_id);
		$criteria->compare('position',$this->position);

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
        $criteria->addCondition('t.user_id='. Y::user_id().' or t.user_id2='. Y::user_id());
        $criteria->with = 'last_msg';

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'last_msg.c_time DESC'),
            'pagination'=>array('pageSize'=>Config::get()->pageSizeFront)
        ));
    }

    public function getUrl(){
        return Yii::app()->createUrl('/user/message/view', array('id'=>$this->id));
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

    /*=========================================================================*/

    public static function loadGroupByUser($user_id)
    {
        if($user_id==Y::user_id())
            throw new CHttpException(400, 'Не возможно отправить сообщение самому себе.');

        $model = UserMsgGroup::model()->find(
            '(user_id=:user_id and user_id2='.Y::user_id().') or '.
            '(user_id2=:user_id and user_id='.Y::user_id().')',
            array(':user_id'=>$user_id)
        );
        if($model===null)
        {
            $model = new UserMsgGroup();
            $model->user_id = Y::user_id();
            $model->user_id2 = $user_id;
            $model->save();
        }

        return $model;
    }
}