<?php

/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 * @property integer $id
 * @property string $name
 * @property string $data
 */
class Config extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{config}}';
	}

    public static $data;
    public static function get($part='base')
    {
        if(self::$data == null)
        {
            $model = self::model()->findByPk(1);
            self::$data = array();
            foreach($model as $attr=>$value){
                if($attr == "id") continue;
                self::$data[$attr] = json_decode($value);
            }
        }
        return self::$data[$part];
    }

    public static function Set($data,$part='base')
    {
        $model = self::model()->findByPk(1);
        foreach($model as $attr=>$value)
        {
            if($attr == "id" || $attr != $part ) continue;

            if(is_array($data[$part]))
            {
                $temp = json_decode($value, true);
                $arr = CMap::mergeArray($temp, $data[$part] );
                $model->$attr = json_encode($arr);
            }
        }
        $model->save();
    }
}