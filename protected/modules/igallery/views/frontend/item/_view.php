<?
/** @var $this Controller */
/** @var $data ContentItem */
?>

<div class="">

    <a class=""  href="<? echo $data->getUrl() ?>">
        <img style="" src="<? echo $data->fileUrl('image',2) ?>" alt="" />
        <?php echo CHtml::encode($data->title); ?>
    </a>

</div>