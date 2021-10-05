<?php

$model1=new CatalogAttribute('search');
$model1->unsetAttributes();  // clear any default values
if(isset($_GET['CatalogAttribute']))
    $model1->attributes=$_GET['CatalogAttribute'];

$this->widget('GridView', array(
	'id'=>'catalog-cat-attr-cat-grid',
	'dataProvider'=>$model1->searchByCat($model->id),
	//'filter'=>$model1,
    'saveState'=>false,
    'afterAjaxUpdate'=>'function(){$(".delete1").die("click");}',
	'columns'=>array(
        /*array(
            'class'=>'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array( 'value' => '$data->id', ),
            'id'=>'check_tr',
            'htmlOptions'=>array('class'=>'check_td'),
   		),*/
        array(
            'name' => 'name',
            'type'=>'raw',
            'value' => 'CHtml::link($data->name,
                            array("attribute/update","id"=>$data->id) )',
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
        array(
            'name' => 'position',
            'value' => '$data->position',
            'id'=>'position_tr',
            'htmlOptions'=>array('class'=>'position_td'),
            'filter'=>''
   		),
        array(
            'type' => 'raw',
            'id' => 'buttons_tr',
            'htmlOptions'=>array('class'=>'buttons_td'),
            'value' => 'CHtml::link(
                "удалить",
                Y::app()->controller->createUrl(
                    "deleteAttr", array("cat_id"=>'.$model->id.', "attr_id"=>$data->id)),
                array(
                    "onclick"=>\'
                        if(!confirm("Подтверждение удаления.")) return false;
                        $.post(this.href, function(){
                            $.fn.yiiGridView.update("catalog-cat-attr-cat-grid");
                        });
                        return false;\'
                )
            )',
        )
	),
));
