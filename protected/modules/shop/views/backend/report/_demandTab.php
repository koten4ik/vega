Спрос на товары:

<? $this->widget('GridView', array(
    'id'=>'catalog-demand-grid',
    'dataProvider'=>$demand->search(),
    'selectableRows'=>false,
    'ajaxUpdate'=>true,
    //'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'name',
            'type'=>'raw',
            'value' => 'CHtml::link($data->name, array("/shop/item/update","id"=>$data->id) )',
            'id'=>'name_tr',
            'htmlOptions'=>array('class'=>'name_td'),
        ),
        array(
            'name' => 'demand',
            'value' => '$data->demand',
            'id'=>'demand_tr',
            'htmlOptions'=>array('class'=>'demand_td'),
        ),
    ),
));?>