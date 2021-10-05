<?php
/** @var $this Controller */
/** @var $model ContentItem */
$this->registerScript("
    $('a[rel=item_image]').fancybox(
    {
        'transitionIn'      : 'none',
        'transitionOut'     : 'none',
        'titlePosition'     : 'over',
        'titleFormat'       :
        function(title, currentArray, currentIndex, currentOpts)
        {
            return '<span id=\"fancybox-title-over\">[ '
                + (currentIndex + 1) + ' / ' + currentArray.length + ' ] '
                + (title.length ? '   ' + title : '') + '</span>';
        }
    })
");
?>

<div id="page_title"><span><? echo $model->title ?></span></div>

<div id="page_content">

    <? if($model->descr) echo $model->descr.'<br><br>' ?>

    <div class="">
        <? foreach (IgalleryItemImage::getList($model->id) as $item) { ?>
            <div class="img_block">
                <a title="<?=$item->descr?>" href="<? echo $item->fileUrl( 'image',1) ?>" rel="item_image">
                    <img class="img_imem" src="<? echo $item->fileUrl( 'image', 2) ?>" alt=""/>
                </a>
            </div>
        <? } ?>
    </div>

    <? //$this->widget('CommentsWidget', array( 'item_id'=>$model->id, 'model_key'=>Comments::IGALLERY_ITEM ) )?>
</div>

<style type="text/css">
    .img_block{
        text-align: center;
        //width: 300px;
        display: inline-block;
        margin: 10px;
        vertical-align: middle;
        border: 0px solid
    }
    .img_imem{
        width: 220px;
    }
</style>