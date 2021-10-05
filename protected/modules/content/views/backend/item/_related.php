

<div class="row" style="margin-top:20px;">
    <b>Связанные материалы:</b>
    <? if (!$model->isNewRecord) {
        echo CHtml::link('Добавить', '#', array('onclick' => '$("#rel_item_dialog").dialog("open"); return false;'));
        $this->widget('GridView', array(
            'id' => 'rel-item-grid',
            'dataProvider' => ContentItemRel::model()->search($model->id),
            'htmlOptions' => array('style' => ''),
            'columns' => array(
                array(
                    'name' => 'item_id',
                    'value' => '$data->item->title',
                    'htmlOptions' => array('class' => 'id_td', 'style' => ''),
                ),
                array('class' => 'CButtonColumn',
                    'buttons' => array(
                        'delele' => array(
                            'label' => 'удалить',    'url' => '$data->id',
                            'click' => 'function(){
                                 if(confirm("подтверждение удаленеия"))
                                     $.post("deleteRelated?id="+$(this).attr("href"), function(data){
                                         $.fn.yiiGridView.update("rel-item-grid");
                                     });
                                 return false;
                             }',
                        ),
                    ),
                    'template' => '{delele}'
                ),
            ),
        ));
    } else echo '<br>для добавления сохраните материал!';

    $this->beginWidget('JuiDialog', array('id'=>'rel_item_dialog','title'=>'Выбор материала'));
        $model_list=new ContentItem();
        $model_list->unsetAttributes();  // clear any default values
        if(isset($_GET['ContentItem']))  $model_list->attributes=$_GET['ContentItem'];
        $this->widget('GridView', array(
            'id'=>'content-r-item-grid',
            'dataProvider'=>$model_list->search_simple(),
            'filter'=>$model_list,
            'htmlOptions'=>array('style'=>'padding:10px;'),
            'columns'=>array(
                array(
                    'name' => 'title',
                    'value' => '$data->title',
                    'htmlOptions'=>array('style'=>'width:400px;'),
                    //'filter'=>CHtml::textField('rel_search_item_name')
                ),
                array(
                    'class'=>'CButtonColumn',
                    'htmlOptions'=>array('class'=>'hit_td', 'style'=>'width:50px;'),
                    'buttons'=>array(
                        'add'=>array(
                            'label'=>'добавить',
                            'url'=>'$data->id',
                            'click'=>'function(){
                                $.post("addRelItem?item='.$model->id.'&rel="+$(this).attr("href"), function(data){
                                    $.fn.yiiGridView.update("rel-item-grid");
                                });
                                return false;
                            }',
                        ),
                    ),
                    'template'=>'{add}',
                ),
            ),
        ));
    $this->endWidget('JuiDialog');
    ?>

</div>
