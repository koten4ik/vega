<?php

$this->widget('GridView', array(
	'id'=>'catalog-order-grid',
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
            'value' => 'CHtml::link("Заказ №".$data->id, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'id_tr',
            'htmlOptions'=>array('class'=>'id_td'),
   		),
        array(
            'name' => 'customer',
            'value'=>'$data->customer',
            'id'=>'customer_tr',
            'htmlOptions'=>array('class'=>'customer_td'),
   		),
        array(
            'name' => 'status',
            'value'=>'CatalogOrder::statusList($data->status)',
            'filter'=>CatalogOrder::statusList(),
            'id'=>'status_tr',
            'htmlOptions'=>array('class'=>'status_td'),
   		),
        array(
            'name' => 'total_c',
            'value'=>'$data->total_c',
            'id'=>'total_tr',
            'htmlOptions'=>array('class'=>'total_td'),
   		),
        array(
            'name' => 'cdate',
            'value' => 'substr($data->cdate,0,10)',
            'htmlOptions' => array('style' => 'width:90px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'cdate','dd.mm.yy')
   		),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));
