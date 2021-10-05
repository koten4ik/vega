<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model VideoItem */

$this->widget('GridView', array(
	'id'=>'video-item-grid',
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
            'value' => 'CHtml::link($data->title,  array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'htmlOptions'=>array('style'=>''),
   		),
        array(
            'name' => 'date',
            'value' => 'Y::date_print($data->date,"d-m-Y")',
            'htmlOptions' => array('style' => 'width:90px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'date','dd.mm.yy')
        ),
        array(
            'header' => 'Категории',
            'value' => '$data->catNames()',
            'type'=>'raw',
            'id' => 'hit_tr',
            'htmlOptions' => array('style' => 'width:100px;'),
            'filter' => '',
        ),
        array(
            'name' => 'published',
            'id'=>'published_tr',
            'htmlOptions'=>array('style'=>'width:30px; text-align:center;'),
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