<? echo "<?\n";?>
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model <?php echo $this->modelClass ?> */

$this->widget('GridView', array(
	'id'=>'<? echo $this->class2id($this->modelClass)?>-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array( 'value' => '$data->id', ),
            'htmlOptions'=>array('style'=>'width:20px;'),
   		),
        array(
            'name' => 'id',
            'value' => '$data->id',
            'htmlOptions'=>array('style'=>'width:40px;'),
        ),
        array(
            'name' => 'title',
            'type'=>'raw',
            'value' => 'CHtml::link($data->title,  array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'htmlOptions'=>array('style'=>''),
   		),
        array(
            'name' => 'published',
            'htmlOptions'=>array('style'=>'width:50px; text-align:center;'),
            'filter'=>array('1'=>'Да', '0'=>'Нет'),
            'class' => 'FlagColumn',
   		),
		array(
			'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template'=>'{update} {delete}'
		),
	),
));