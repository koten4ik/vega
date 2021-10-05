<?
/** @var $this Controller */
/** @var $data User */
?>

<div class="_view" style="margin-bottom: 15px;">

    <div class="fr" style="color: #555; font-size: 80%;"><?=Y::date_print($data->c_time,'d.m.Y')?></div>
    <?= CHtml::link($data->title, $data->getUrl()); ?>
    <?if(Y::user_id()==$data->user_id){?>
        (<?=$data->published ? '' : Y::t('черновик').', '?>
        <a href="<?=$this->createUrl('/user/post/update',array('id'=>$data->id))?>"><?=Y::t("изменить")?></a>)
    <?}?>
    <div class="fc" style="margin-top: 5px; max-height: 48px; overflow: hidden;">
        <?=$data->text?>
    </div>
    <a href="<?=$data->getUrl()?>" class="fr" style="color: #555;"><?=Y::t('подробнее')?></a>
    <span style="color: #555;"><?=Y::t('Коментарии:')?> 0</span>
    <div class="fc"></div>

</div>