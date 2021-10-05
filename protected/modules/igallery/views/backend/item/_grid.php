
<?php


$this->widget('GridView', array(
	'id'=>'igallery-item-grid',
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
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id' => 'id_tr',
            'htmlOptions' => array('style' => 'width:30px;'),
        ),
        array(
            'name' => 'title',
            'type'=>'raw',
            'value' => 'CHtml::link($data->title, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'title_tr',
            'htmlOptions'=>array('class'=>'title_td'),
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
                array("/".BACKEND_NAME."/igallery/category/list?update=".$data->category->id) )',
            'htmlOptions' => array('style' => 'width:180px;'),
            'filter' => Html::categoryFilter($model,'cat_id')
   		),
		array(
			'class'=>'CButtonColumn',
            'afterDelete'=>'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template'=>'{delete}'
		),
	),
));