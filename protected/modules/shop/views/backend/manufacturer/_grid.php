<?php

$this->widget('GridView', array(
	'id'=> 'catalog-manufacturer-grid',
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
            'name' => 'id',
            'type'=>'raw',
            'value' => 'CHtml::link($data->id, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'id_tr',
            'htmlOptions'=>array('class'=>'id_td'),
   		),
        array(
            'name' => 'name',
            'type'=>'raw',
            'value' => 'CHtml::link($data->name, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'title_tr',
            'htmlOptions'=>array('class'=>'title_td'),
   		),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));

