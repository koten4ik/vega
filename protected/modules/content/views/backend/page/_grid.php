<?php

$this->widget('GridView', array(
	'id'=>'content-page-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'saveState'=>true,
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array( 'value' => '$data->id', ),
            'id'=>'check_tr',
            'htmlOptions'=>array('class'=>'check_td'),
   		),
        array(
            'name' => 'title_adm',
            'type'=>'raw',
            'value' => 'CHtml::link($data->title_adm, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'title_tr',
            'htmlOptions'=>array('class'=>'title_td'),
   		),
        array(
            'name' => 'alias',
            'value' => '$data->alias',
            'id'=>'alias_tr',
            'htmlOptions'=>array('style'=>'width:250px;'),
   		),
        array(
            'name' => 'module_id',
            'value' => '$data->module_id',
            'id'=>'alias_tr',
            'htmlOptions'=>array('style'=>'width:100px;'),
            'filter'=>ContentPage::modules(),
            'visible'=>$this->module->id=='content'
   		),
        /*array(
            'name' => 'published',
            'id'=>'published_tr',
            'htmlOptions'=>array('class'=>'published_td'),
            'class' => 'FlagColumn',
   		),*/

		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));