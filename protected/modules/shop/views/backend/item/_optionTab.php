<div id="image_tab" style="width: 60%;">
    <? if(!$model->isNewRecord){?>

    Опция:
    <?
    echo ' '.CHtml::dropDownList('','', CMap::mergeArray(array(''=>''),CHtml::listData(CatalogOption::model()->findAll(),'id','title')),
        array('id'=>'item-option-search', 'style'=>'margin-top:5px; min-width:150px;', 'onchange'=>"
            $.fn.yiiGridView.update('catalog-option-grid', { data: 'option_id='+$('#item-option-search').val()});
        "));
    ?>
    <a href="#" onclick="$('#option_dialog').dialog('open'); return false;" style="margin-left:20px;" >Добавить</a>

    <? $this->widget('GridView', array(
        'id'=>'catalog-option-grid'.$model->id,
        'dataProvider'=>CatalogItemOption::model()->search($model->id),
        'hideHeader'=>false,
        'selectableRows'=>false,
        'saveState'=>false,
        //'summaryText'=>'&nbsp',
        //'filter'=>$model,
        'columns'=>array(
            array(
                'name' => 'option_id',
                'value' => '$data->option->title."(".$data->option->title_add.")"',
                'htmlOptions'=>array('style'=>'min-width:120px;'),
            ),
            array(
                'name' => 'option_value_id',
                'value' => '$data->optionVal->value',
                'htmlOptions'=>array('class'=>'image_td'),
            ),
            array(
                'name' => 'price',
                'value' => function($data){
                    echo CHtml::textField('opt_price',$data->price, array('style'=>'width:40px;', 'onchange'=>'
                        $.post("setOptionPrice?item='.$data->id.'&opt_price="+$(this).val(), function(data){
                            //$.fn.yiiGridView.update("catalog-option-grid");
                            if(data==1){
                                $(\'#optVal_y'.$data->id.'\').show();
                                $(\'#optVal_n'.$data->id.'\').hide();
                            }
                            else{ $(\'#optVal_y'.$data->id.'\').hide();
                                  $(\'#optVal_n'.$data->id.'\').show(); }
                        });
                    '));
                    echo CHtml::image('/assets_static/images/back/publish_y.png','',
                            array('id'=>'optVal_y'.$data->id, 'style'=>'display:none; width:12px;'));
                    echo CHtml::image('/assets_static/images/back/publish_n.png','',
                            array('id'=>'optVal_n'.$data->id, 'style'=>'display:none; width:12px;'));
                },
                'htmlOptions'=>array('style'=>'width:60px;'),
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{delete}',
                'buttons'=>array(
                    'delete' => array(
                            'url' => 'Yii::app()->createUrl("/shop/item/removeOptionVal", array("id"=>$data->id))',
                    ),
                )
            ),
        ),
    ));?>

    <? }
    else echo 'Для добавления опций сохраните товар.';
    ?>
</div>

<?
$this->renderPartial('_option_dialog',array(
	'model'=>$model));
?>