Забронированые товары:

<? $this->widget('GridView', array(
    'id'=>'catalog-reserv-grid',
    'dataProvider'=>$reserv->search(),
    'selectableRows'=>false,
    'filter'=>$reserv,
    'columns'=>array(
        array(
            'name' => 'item_id',
            'type'=>'raw',
            'value' => 'CHtml::link($data->item->name, array("/shop/item/update","id"=>$data->item_id) )',
            'id'=>'item_id_tr',
            'htmlOptions'=>array('class'=>'item_id_td'),
            'filter'=>CHtml::listData( CatalogItem::getByCatAlias('reserve'), 'id','name')
        ),
        array(
            'name' => 'count',
            'value' => '$data->count',
            'id'=>'count_tr',
            'htmlOptions'=>array('class'=>'count_td'),
        ),
        array(
            'name' => 'cdate',
            'value' => '$data->cdate',
            'htmlOptions' => array('style' => 'width:120px; text-align:center;'),
            'filter' => ''//Html::dateFilter($model,'cdate','dd.mm.yy')
        ),
        array(
            'name' => 'order_id',
            'type'=>'raw',
            'value' => 'CHtml::link("Заказ №".$data->order_id, array("/shop/order/update","id"=>$data->order_id) )',
            'id'=>'order_id_tr',
            'htmlOptions'=>array('class'=>'order_id_td'),
        ),
    ),
));?>