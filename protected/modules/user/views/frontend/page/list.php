<?
/** @var $this Controller */
/** @var $model User */
?>

<h1 id="page_title"><span><? echo Y::t('Elements') ?></span></h1>

<div id="page_content">
    <? $this->widget('ListViewFront', array(
    	'id'=>'user-list',
    	'dataProvider'=>$model->search_front(),
        'itemView'=>'_view',
        )
    );?>
</div>