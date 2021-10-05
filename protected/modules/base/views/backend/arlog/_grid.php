<?php

$this->widget('GridView', array(
	'id'=>'arlog-grid',
	'dataProvider'=>$model->search(),
    //'ajaxUrl'=>Y::app()->request->url,
	'filter'=>$model,
	'columns'=>array(

        array(
            'name' => 'id',
            'value' => '$data->id',
            'htmlOptions'=>array('style'=>'width:40px;'),
        ),
        array(
            'name' => 'model_name',
            'value' => '$data->model_name',
            'htmlOptions'=>array('style'=>'width:100px;'),
        ),
        array(
            'name' => 'model_id',
            'value' => '$data->model_id',
            'htmlOptions'=>array('style'=>'width:100px;'),
        ),
        array(
            'name' => 'action_id',
            'value' => '$data->action_id',
            'htmlOptions'=>array('style'=>'width:100px;'),
        ),
        array(
            'name' => 'controller_id',
            'value' => '$data->controller_id',
            'htmlOptions'=>array('style'=>'width:100px;'),
        ),
        array(
            'name' => 'module_id',
            'value' => '$data->module_id',
            'htmlOptions'=>array('style'=>'width:100px;'),
        ),
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->user->username,
                            array("/user/manage/update","id"=>$data->user->id) )',
            'htmlOptions'=>array('style'=>''),
        ),
        array(
            'name' => 'c_time',
            'value' => 'date("d-m-Y H:i",$data->c_time)',
            'htmlOptions'=>array('style'=>'width:100px;'),
        ),
	),
));
?>
