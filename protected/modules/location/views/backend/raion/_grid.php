<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationRaion */

$this->widget('GridView', array(
	'id'=>'location-raion-grid',
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
            'value' => 'CHtml::link($data->title." (".$data->childCnt().")",  array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'htmlOptions'=>array('style'=>''),
   		),
        array(
            'name' => 'country_id',
            'value' => '$data->country->title',
            'htmlOptions'=>array('style'=>'width:110px;'),
            'filter'=>LocationCountry::getList()
        ),
        array(
            'name' => 'oblast_id',
            'value' => '$data->oblast->title',
            'htmlOptions'=>array('style'=>'width:220px;'),
            'filter'=>LocationOblast::getList($_GET['LocationRaion']['country_id'])
        ),
        /*array(
            'name' => 'capital_id',
            'value' => '$data->capital ? $data->capital->title : $data->capital_id',
            'htmlOptions'=>array('style'=>'width:130px;'),
        ),*/
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