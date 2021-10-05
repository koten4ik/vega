
<div id="ret_tab" style="">
    <?
    if(!$model->isNewRecord)
    {
        $model_list=new CatalogItem();
        $model_list->unsetAttributes();  // clear any default values
        if(isset($_GET['CatalogItem']))
            $model_list->attributes=$_GET['CatalogItem'];
        $this->widget('GridView', array(
            'id'=>'catalog-item-grid',
            'dataProvider'=>$model_list->search(),
            'filter'=>$model_list,
            'htmlOptions'=>array('style'=>'padding:0px; width: 52%; float:left'),
            'columns'=>array(
                array(
                    'name' => 'name',
                    'value' => '$data->name',
                    'htmlOptions'=>array('class'=>'hit_td', 'style'=>'text-align:left;'),
                    'filter'=>CHtml::textField('rel_search_item_name')
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

        $this->widget('GridView', array(
             'id'=>'rel-item-grid',
             'dataProvider'=> CatalogItemRel::model()->search($model->id),
            'htmlOptions'=>array('style'=>'margin-left:54%'),
             'columns'=>array(
                 array(
                     'name' => 'item_id',
                     'value' => '$data->item->name',
                     'htmlOptions'=>array('class'=>'id_td', 'style'=>''),
                 ),
                 array('class'=>'CButtonColumn',
                     'buttons'=>array(
                         'delele'=>array(
                             'label'=>'удалить',
                             //'imageUrl'=>'/assets_static/images/back/delete.png',
                             'url'=>'$data->id',
                             'click'=>'function(){
                                 if(confirm("подтверждение удаленеия"))
                                     $.post("deleteRelated?id="+$(this).attr("href"), function(data){
                                         $.fn.yiiGridView.update("rel-item-grid");
                                     });
                                 return false;
                             }',
                         ),
                     ),
                       'template'=>'{delele}'
                 ),
             ),
         ));
        echo '<div class="fc"></div> ';
    }
    else echo 'Для добавления связей сохраните товар.';
    ?>
</div>