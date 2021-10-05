
<?
/** @var $this Controller */
?>
<div id="page_title"><span>Опросы</span></div>

<div id="page_content">
<?
    $this->widget('ListViewFront', array(
    	'id'=>'poll-item-list',
        'emptyText'=>'Пусто.',
    	'dataProvider'=>$model->search_front(),
        //'ajaxUrl'=>Y::app()->request->requestUri,
        'ajaxUpdate' => false,
        'itemView'=>'_view',
    ));
?>
</div>

