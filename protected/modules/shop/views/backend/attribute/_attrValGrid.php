Значения:
<input id="attr_val"/>
<a href="#" onclick="
        $.post('<? echo $this->createUrl('/shop/attribute/addVal', array('attr_id'=>$model->id)) ?>'+'&val='+$('#attr_val').val(),
            function(data){$.fn.yiiGridView.update('catalog-attrVal-grid<?=$model->id?>'); $('#attr_val').val('')}
        );
        return false;
    ">добавить</a>
<br>

<? $this->widget('GridView', array(
    'id'=>'catalog-attrVal-grid'.$model->id,
    'dataProvider'=>CatalogAttrVal::model()->search($model->id),
    'hideHeader'=>true,
    'selectableRows'=>false,
    'summaryText'=>'&nbsp',
    'ajaxUpdate'=>true,
    //'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'value',
            'type'=>'raw',
            'value' => '$data->value',
            'id'=>'value_tr',
            'htmlOptions'=>array('class'=>'value_td'),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/shop/attribute/removeVal", array("id"=>$data->id))',
                ),
            )
        ),
    ),
));?>