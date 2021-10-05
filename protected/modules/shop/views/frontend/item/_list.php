
<?
/** @var $this Controller */


/*
echo CHtml::dropDownList('sort_select', Y::cookie('sort_select'),
    array(
        ''=>'По умолчанию',
        'name'=>'Имени от А до Я',
        'name.desc'=>'Имени от Я до А',
        'price'=>'Ценам: Низкие > Высокие',
        'price.desc'=>'Ценам: Высокие < Низкие',
    ),
    array('onchange'=>'
        $.cookie($(this).attr("name"), $(this).val())
        $.fn.yiiListView.update("catalog-item-list", {
            url: "?ajax=catalog-item-list&CatalogItem_sort=" + $(this).val()
        });
    ')
);*/
?>

<?

$this->widget('ListViewFront', array(
	'id'=>'catalog-item-list',
    'emptyText'=>'Товаров не найдено.',
	'dataProvider'=>$model->front_search(),
    //'ajaxUrl'=>Y::app()->request->requestUri,
    'ajaxUpdate' => false,
    'itemView'=>$category->alias == 'demand' ? '_view_demand' : '_view',
    'sortableAttributes'=>array(
        'name'=>'имя',
        'price'=>'цена',
    ),
));
?>