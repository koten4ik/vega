<script type="">
    busy = 0;
    function option_submit(){
        $.fn.yiiGridView.update('option-grid', { data: 'option_id='+$('#option-search').val()});}
</script>
<?
$option_val = new CatalogOptionVal();
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'option_dialog',
    'options'=>array(
        'title'=>'Значения опций',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>'auto'
    ),
));

    echo 'Опция: '.CHtml::dropDownList('','', CMap::mergeArray(array(''=>''),CHtml::listData(CatalogOption::model()->findAll(),'id','title')),
        array('id'=>'option-search', 'style'=>'margin-top:5px;  min-width:150px;', 'onchange'=>"
            $.fn.yiiGridView.update('option-grid', { data: 'option_id='+$('#option-search').val()});
        "));


    $this->widget('GridView', array(
        'id'=>'option-grid',
        'dataProvider'=>$option_val->search(),
        'htmlOptions'=>array('style'=>' min-width:500px; margin-top:-15px;'),
        'columns'=>array(
            array(
                'name' => 'option_id',
                'value' => '$data->option->title."(".$data->option->title_add.")"',
                'htmlOptions'=>array('class'=>'image_td'),
            ),
            array(
                'name' => 'value',
                'value' => '$data->value',
                'htmlOptions'=>array('class'=>'image_td'),
            ),
            array(
                'class'=>'CButtonColumn',
                'buttons'=>array(
                    'add'=>array(
                        'label'=>'добавить',
                        'url'=>'$data->id."~".$data->option_id',
                        'click'=>'function(){
                            $.post("addOption?item='.$model->id.'&option_data="+$(this).attr("href"), function(data){
                                $.fn.yiiGridView.update("catalog-option-grid'.$model->id.'");
                            });
                            return false;
                        }',
                    ),
                ),
                'template'=>'{add}',
            ),
        ),
    ));
    echo '<br>';


$this->endWidget('zii.widgets.jui.CJuiDialog');


