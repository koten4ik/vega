<?php

/**
 * This is the model class for table "cre_ru.tbl_ar_log".
 *
 * The followings are the available columns in table 'cre_ru.tbl_ar_log':
 * @property integer $id
 * @property integer $c_time
 * @property string $model_name
 * @property integer $model_id
 * @property integer $user_id
 * @property string $controller_id
 * @property string $action_id
 */
class ArLog extends ActiveRecord
{

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return 'tbl_base_ar_log'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_time, model_name, model_id, user_id, controller_id, action_id', 'safe'),
			array('c_time, model_id, user_id', 'numerical', 'integerOnly'=>true),
			array('model_name, controller_id, action_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, c_time, model_name, model_id, user_id, controller_id, action_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'c_time' => 'C Time',
			'model_name' => 'Model Name',
			'model_id' => 'Model ID',
			'user_id' => 'User',
			'controller_id' => 'Controller',
			'action_id' => 'Action',
		);
	}

	public function search()
	{
		// saved grid state (page sort ect.)
		// $this->StateProcess(get_class($this).'_'.Y::app()->params['cfgName']);

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('c_time',$this->c_time);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('user.username',$this->user_id,true);
		$criteria->compare('controller_id',$this->controller_id,true);
		$criteria->compare('action_id',$this->action_id,true);

        $criteria->with = 'user';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array('defaultOrder'=>'t.id DESC'),
            'pagination'=>array('pageSize'=>Config::$data['base']->pageSize)
		));
	}


}