<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

/**
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends ActiveRecord
{

	public static function model($className=__CLASS__){
	    return parent::model($className);
    }

	public function tableName(){ return '<?php echo $tableName; ?>'; }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return CMap::mergeArray(parent::rules(),array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
		));
	}

	public function relations()
	{
		return array(
            //'author' => array(self::BELONGS_TO, 'User', 'author_id'),
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}

	public function attributeLabels()
	{
		return array(
<?php foreach($labels as $name=>$label): ?>
			<?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

<?php
foreach($columns as $name=>$column)
{
	if($column->type==='string')
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
	}
}
?>

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
    public static function getListRaw($limit = -1){
        $criteria=new CDbCriteria;
        //$criteria->order = 'ordering';
        $criteria->limit = $limit;
        return self::model()->findAll($criteria);
    }
}