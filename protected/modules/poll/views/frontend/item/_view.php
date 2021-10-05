<?
/** @var $this Controller */
/** @var $model CatalogItem */
$model = $data;
?>

<div class="_view_poll" style="margin-bottom: 20px;">
    <?   $this->widget('PollWidget', array('poll'=>$model)); ?>
</div>