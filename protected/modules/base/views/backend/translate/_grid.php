<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BaseSourceMessage */

$this->widget('GridView', array(
	'id'=>'base-source-message-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'saveState'=>true,
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array( 'value' => '$data->id', ),
            'htmlOptions'=>array('style'=>'width:20px;'),
   		),

        array(
            'name' => 'message',
            'type'=>'raw',
            'value' => 'CHtml::link($data->message,  array("update","id"=>$data->id) )',
   		),
        array(
            'name' => 'category',
            'value' => '$data->category',
            'htmlOptions'=>array('style'=>'width:100px;'),
   		),

		array(
			'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template'=>'{update} {delete}'
		),
	),
));