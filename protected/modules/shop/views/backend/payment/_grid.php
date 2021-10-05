<?php

$this->widget('GridView', array(
	'id'=> 'catalog-payment-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
    'saveState'=>true,
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array( 'value' => '$data->id', ),
            'id'=>'check_tr',
            'htmlOptions'=>array('class'=>'check_td'),
   		),
        array(
            'name' => 'name',
            'type'=>'raw',
            'value' => 'CHtml::link($data->name, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'name_tr',
            'htmlOptions'=>array('class'=>'name_td'),
   		),
        array(
            'name' => 'published',
            'id'=>'published_tr',
            'htmlOptions'=>array('class'=>'published_td'),
            'class' => 'FlagColumn',
   		),
        array(
            'name' => 'ordering',
            'value' => '$data->ordering',
            'id'=>'ordering_tr',
            'htmlOptions'=>array('class'=>'ordering_td'),
   		),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));

