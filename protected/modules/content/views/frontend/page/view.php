<?php
/** @var $this Controller */
/** @var $model ContentItem */
$this->registerScript('$("a[rel=item_image]").fancybox();');
?>

<h1 id="page_title">

    <span><? echo $model->title; ?></span>
    <?$this->widget('PageEdit',array('model'=>$model))?>

</h1>

<div id="page_content">
    <? if($model->published) echo $model->text; else echo Y::t('Страница не опубликована.') ?>
    <div class="fc"></div>
</div>