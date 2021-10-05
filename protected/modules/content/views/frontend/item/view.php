<?php
/** @var $this Controller */
/** @var $model ContentItem */
$this->registerScript(" $('a[rel=item_image]').fancybox(); ");
?>

<h1 id="page_title">
    <span><? echo $model->title; ?></span>
    <?$this->widget('EditButton', array( 'model'=>$model, 'url'=>'/content/item' ) )?>
</h1>

<div id="page_content">

    <?if($model->image){?>
        <a href="<? echo $model->fileUrl( 'image',1) ?>" rel="item_image">
            <img src="<? echo $model->fileUrl( 'image',2); ?>" class="fl" style="margin: 0 15px 10px 0;">
        </a>
    <?}?>

    <span><? echo $model->full_text; ?></span>

    <div class="fc"></div>

    <? //$this->widget('ReletedMatsWidget', array( 'item_id'=>$model->id ) )?>

    <? //$this->widget('TagsWidget', array( 'item'=>$model ) )?>

    <? $this->widget('CommentsWidget', array( 'item_id'=>$model->id, 'model_key'=>Comments::CONTENT_ITEM ) )?>

</div>

