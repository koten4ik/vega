<?
/** @var $this Controller */
/** @var $model VideoItem */
?>

<h1 id="page_title"><span><?=$title?></span></h1>

<div id="page_content">
    <?
    $this->widget('ListViewFront', array(
    	'id'=>'video-item-list',
        'separator'=>'<div class="separator"></div>',

    	'dataProvider'=>$model->search_front(),
        'itemView'=>'_view',
        )
    );
    ?>
</div>