
<div class="banner" style="display: inline-block;  width: 100%;" time="<?=$banner->rotation_time*1000?>">

    <? if($banner->flash_file)
    {?>
        <a href="<?=$banner->clickUrl?>" target="<?=$banner->target?>"
            style="background: url(<?=$banner->fileUrl('image')?>); display: inline-block;
                width:<?=$banner->flash_width?>px; height:<?=$banner->flash_height?>px;">
            <object>
                <embed width="<?=$banner->flash_width?>" height="<?=$banner->flash_height?>"
                   src="<?= $banner->fileUrl('flash_file')?>" type="application/x-shockwave-flash">
            </object>
        </a>
    <?}else
    {?>
        <a href="<?=$banner->clickUrl?>" target="<?=$banner->target?>"><img style="" src="<?=$banner->fileUrl('image')?>"></a>
    <?}?>

</div>