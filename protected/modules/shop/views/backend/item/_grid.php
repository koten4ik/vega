
<?php
$model->commandBuilder->schema->refresh();
$model->refreshMetaData();

$this->widget('GridView', array(
	'id'=> 'catalog-item-grid',
	'dataProvider'=>$model->search(),
    //'ajaxUrl'=>Y::app()->request->url,
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
            'name' => 'name',
            'type'=>'raw',
            'value' => 'CHtml::link($data->name, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'name_tr',
            'htmlOptions'=>array('class'=>'name_td'),
   		),
        array(
            'name' => 'model',
            'value' => '$data->model',
            'id'=>'model_tr',
            'htmlOptions'=>array('class'=>'model_td'),
   		),
        array(
            'name' => 'price',
            'value' => '$data->price',
            'id'=>'price_tr',
            'htmlOptions'=>array('class'=>'price_td'),
   		),
        array(
            'name' => 'count',
            'value' => '$data->count',
            'id'=>'count_tr',
            'htmlOptions'=>array('class'=>'count_td'),
        ),
        array(
            'name' => 'published',
            //'value' => '$data->published',
            'id'=>'published_tr',
            'htmlOptions'=>array('class'=>'published_td'),
            'filter'=>array('1'=>'Да', '0'=>'Нет'),
            'class' => 'FlagColumn',
   		),
        array(
            'name' => 'cat_id',
            'type'=>'raw',
            'value' => 'CHtml::link($data->category->title,
                            array("/".BACKEND_NAME."/shop/category/list?update/".$data->category->id) )',
            'htmlOptions' => array('style' => 'width:200px;'),
            'filter' => Html::categoryFilter($model,'cat_id')
   		),
        array(
            'name' => 'hits',
            'value' => '$data->hits',
            'id'=>'hit_tr',
            'htmlOptions'=>array('class'=>'hit_td'),
            'filter'=>'',
   		),
		array(
			'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template'=>'{delete}'
		),
	),
));

