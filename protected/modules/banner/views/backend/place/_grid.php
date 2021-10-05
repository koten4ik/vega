<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BannerPlace */

$this->widget('GridView', array(
	'id'=>'banner-place-grid',
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
            'name' => 'title_adm',
            'type'=>'raw',
            'value' => 'CHtml::link($data->title_adm,  array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'htmlOptions'=>array('style'=>''),
   		),
        array(
            'name' => 'elem_cnt',
            'value' => '$data->elem_cnt',
            'htmlOptions'=>array('style'=>'width:40px;'),
        ),
		array(
			'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template'=>'{update} {delete}'
		),
	),
));