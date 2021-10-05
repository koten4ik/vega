
<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model Comments */

$this->widget('GridView', array(
	'id'=>'comments-grid',
	'dataProvider'=>$model->search(),
    //'ajaxUrl'=>Y::app()->request->url,
	'filter'=>$model,
    'saveState'=>true,
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
            'name' => 'text',
            'type'=>'raw',
            'value' => 'CHtml::link($data->text,  array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'htmlOptions'=>array('style'=>''),
   		),
        array(
            'name' => 'user_id',
            'value' => '$data->user->username',
            'htmlOptions'=>array('style'=>'width:100px;'),
            'filter'=>''//Comments::modelList(),
   		),
        array(
            'name' => 'item_id',
            'value' => '$data->item_id',
            'htmlOptions'=>array('style'=>'width:100px;'),
            'filter'=>''//Comments::modelList(),
   		),
        array(
            'name' => 'model_key',
            'value' => '$data->modelList($data->model_key)',
            'htmlOptions'=>array('style'=>'width:100px;'),
            'filter'=>Comments::modelList(),
   		),
        array(
            'name' => 'published',
            'htmlOptions'=>array('style'=>'width:50px; text-align:center;'),
            'filter'=>array('1'=>'Да', '0'=>'Нет'),
            'class' => 'FlagColumn',
   		),
        array(
            'name' => 'approved',
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