<?
/** @var $this Controller */
/** @var $data ContentItem */
$img_src = $data->image ? $data->fileUrl('image',3) : $data->fileUrl('image_prev',2)
?>

<div class="_view">

    <?if(1){//$data->image || $data->image_prev){?>
        <a href="<?=$data->getUrl()?>">
            <img style="vertical-align: top; width: 150px; margin-right: 20px; "
                class="fl" src="<?= $img_src; ?>" alt="">
        </a>
    <?}?>

    <div style="">
        <b><a href="<?=$data->getUrl()?>"><? echo $data->title;?></a></b>
        <br>
        <div style="margin-top: 3px; margin-bottom: 15px;"><?= date('d.m.y',$data->cdate)?></div>
        <? echo $data->intro_text;?>
        <br>
        <a href="<?=$data->getUrl()?>"><?= Y::t('Читать далее')?></a>
    </div>

    <div class="fc"></div>

</div>