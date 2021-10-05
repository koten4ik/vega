<?
/** @var $this Controller */
/** @var $model CatalogItem */
$model = $data;
?>

<div class="_view_product">

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
    <br>

    <? if($model->category->alias == 'reserve') { ?>
    <a class="purchase_butt" href="<? echo $model->url; ?>" onclick="purchase(this,<? echo $model->id.', \''.str_replace('\'','',$model->name).'\'' ?>); return false" >Забронировать</a>
    <? } else { ?>
        <a class="purchase_butt" href="<? echo $model->url; ?>" onclick="purchase(this,<? echo $model->id.', \''.str_replace('\'','',$model->name).'\'' ?>); return false" >В корзину</a>
    <? } ?>
</div>