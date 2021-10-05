<?php

$this->widget('GridView', array(
	'id'=>'catalog-attribute-grid',
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
            'name' => 'name',
            'type'=>'raw',
            'value' => 'CHtml::link($data->name, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'name_tr',
            'htmlOptions'=>array('class'=>'name_td'),
   		),

        array(
            'name' => 'type',
            'value' => 'CatalogAttribute::getType($data->type)',
            'id'=>'type_tr',
            'htmlOptions'=>array('class'=>'type_td'),
            'filter'=>CatalogAttribute::getTypeList(),
   		),
        /*array(
            'name' => 'cat_id',
            'type'=>'raw',
            'value' => 'CHtml::link($data->category->name,
                            array("/shop/category/list/update/".$data->category->id) )',
            'id'=>'cat_tr',
            'htmlOptions'=>array('class'=>'cat_td'),
            'filter'=>
                CHtml::hiddenField('CatalogAttribute[cat_id]',$_GET['CatalogAttribute']['cat_id'], array('id'=>'cat_id_filter','style'=>'display:inline;'))
                .CHtml::textField('cat_name_filter',$_GET['cat_name_filter'], array('id'=>'cat_name_filter', 'class'=>'cat_sel_butt'))
                .CHtml::tag('a', array('onclick'=>'$("#cat_name_filter").val(""); $("#cat_id_filter").val("").trigger("change");', 'class'=>'ui-icon ui-close-butt'))
   		),*/
        array(
            'name' => 'position',
            'value' => '$data->position',
            'id'=>'position_tr',
            'htmlOptions'=>array('class'=>'position_td'),
            'filter'=>''
   		),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));
