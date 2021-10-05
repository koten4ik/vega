<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model Banner */


$this->widget('GridView', array(
	'id'=>'banner-grid',
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
            'name' => 'title_adm',
            'type'=>'raw',
            'value' => 'CHtml::link($data->title_adm,  array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'htmlOptions'=>array('style'=>''),
   		),
        array(
            'name' => 'place_id',
            'value' => '$data->place->title_adm',
            'htmlOptions'=>array('style'=>'width:220px;'),
            'filter'=>BannerPlace::getList(),
   		),
        array(
            'name' => 'position',
            'value' => '$data->position',
            'htmlOptions'=>array('style'=>'width:40px;'),
        ),
        array(
            'name' => 'rotation_percent',
            'value' => '$data->rotation_percent',
            'htmlOptions'=>array('style'=>'width:65px;'),
        ),
        array(
            'name' => 'published',
            'htmlOptions'=>array('style'=>'width:50px; text-align:center'),
            'filter'=>array('1'=>'Да', '0'=>'Нет'),
            'class' => 'FlagColumn',
   		),
        array(
            'name' => 'from_time',
            'value' => 'Y::date_print($data->from_time,"d-m-Y")',
            'htmlOptions' => array('style' => 'width:110px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'from_time','dd-mm-yy')
        ),
        array(
            'name' => 'to_time',
            'value' => 'Y::date_print($data->to_time,"d-m-Y")',
            'htmlOptions' => array('style' => 'width:110px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'to_time','dd-mm-yy')
        ),
		array(
			'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template'=>'{delete}'
		),
	),
));
?>

