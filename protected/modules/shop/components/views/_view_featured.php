<?
/** @var $this Controller */
/** @var $data CatalogItem */
$model = $data;
?>

<div class="_view_featured">

    <a class="name" href="<? echo $model->url; ?>"><?php echo CHtml::encode($model->name); ?></a>
    <br><br>

    <a href="<? echo $model->url; ?>" style="text-decoration: none; ">
        <img src="<? echo $model->fileUrl('image',1) ?>"  alt="" class="img" >
    </a>
    <br><br>

    <span class="price">
        <?php echo CHtml::encode($model->getAttributeLabel('price')); ?>:
        <span class="price_val"><?php echo CHtml::encode($model->price); ?></span>
        <? echo ShopModule::getCurrency(); ?>
    </span>
    <br><br>

    <a class="detail_butt" href="<? echo $model->url; ?>" >Подробнее</a>

</div>