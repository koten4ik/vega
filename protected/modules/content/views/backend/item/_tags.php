

<div class="row" style="margin-top:20px;">
    <b>Теги:</b>
    <? if (!$model->isNewRecord) {
        echo CHtml::link('Добавить', '#', array('onclick' => '$("#tag_dialog").dialog("open"); return false;'));
        $this->widget('GridView', array(
            'id' => 'tag-item-grid',
            'dataProvider' => ContentItemTag::model()->search($model->id),
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
                                     $.post("deleteTag?id="+$(this).attr("href"), function(data){
                                         $.fn.yiiGridView.update("tag-item-grid");
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

    $this->beginWidget('JuiDialog', array('id'=>'tag_dialog','title'=>'Выбор материала'));
        $model_list=new ContentTag();
        $model_list->unsetAttributes();  // clear any default values
        if(isset($_GET['ContentTag']))  $model_list->attributes=$_GET['ContentTag'];
        $this->widget('GridView', array(
            'id'=>'tag-grid',
            'dataProvider'=>$model_list->search(false),
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
                                $.post("addTag?item='.$model->id.'&tag="+$(this).attr("href"), function(data){
                                    $.fn.yiiGridView.update("tag-item-grid");
                                });
                                return false;
                            }',
                        ),
                    ),
                    'template'=>'{add}',
                ),
            ),
        ));

        echo '<br>'.CHtml::tag('b',array('style'=>'margin-left:10px;'),'Новый тег:');
        echo CHtml::textField('tag_inp','',array('id'=>'tag_inp', 'style'=>'margin: 0px 10px; width:200px;'));
        echo '<b>'.CHtml::link('Создать новый', '#', array('onclick'=>'
            if($("#tag_inp").val() ==""){ alert("Поле не должно быть пустым."); return false;}
            $.post("newTag?item='.$model->id.'&tag_t="+$("#tag_inp").val(), function(data){
                $.fn.yiiGridView.update("tag-item-grid");
                $.fn.yiiGridView.update("tag-grid");
                $("#tag_inp").val("");
            });
            return false;
        ')).'</b><br><br>';

    $this->endWidget('JuiDialog');
    ?>

</div>
