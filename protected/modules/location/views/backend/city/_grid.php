<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationCity */

$this->widget('GridView', array(
	'id'=>'location-city-grid',
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
        /*array(
            'name' => 'level',
            'value' => '$data->level',
            'htmlOptions'=>array('style'=>'width:40px;'),
        ),*/
        array(
            'name' => 'country_id',
            'value' => '$data->country->title',
            'htmlOptions'=>array('style'=>'width:110px;'),
            'filter'=>LocationCountry::getList()
        ),
        array(
            'name' => 'oblast_id',
            'value' => '$data->oblast->title',
            'htmlOptions'=>array('style'=>'width:170px;'),
            'filter'=>LocationOblast::getList($_GET['LocationCity']['country_id'])
        ),
        array(
            'name' => 'raion_id',
            //'header'=>$_GET['LocationCity']['oblast_id'],
            'value' => '$data->raion->title',
            'htmlOptions'=>array('style'=>'width:170px;'),
            'filter'=>LocationRaion::getList($_GET['LocationCity']['oblast_id'])
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