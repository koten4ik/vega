<?
/** @var $this Controller */
/** @var $data VideoItem */
?>

<div class="_view" style="">

    <?if(1){//$data->image || $data->image_prev){?>
        <a href="<?=$data->getUrl()?>">
            <img style="vertical-align: top; width: 150px; margin-right: 20px; "
                class="fl" src="<?= $data->fileUrl('image',1); ?>" alt="">
        </a>
    <?}?>

    <div style="">
        <b><a href="<?=$data->getUrl()?>"><? echo $data->title;?></a></b>

        <div style="margin-top: 3px; margin-bottom: 0px;"><?= date('d.m.y',$data->c_time)?></div>
        <? echo $data->intro_text;?>
        <br>
        <!--a href="<?=$data->getUrl()?>"><?= Y::t('Смотреть')?></a-->
    </div>

    <div class="fc"></div>

</div>