
<div class="banner" style="display: inline-block; font-size: 110%;">

    <table cellpadding="0" cellspacing="0" border="0"
           style="background-color: #<?=$banner->place->bg_color?>; width: <?=$banner->place->width?>px"><tr>
        <td style="background: url('http://cre.ru/assets_static/images/tiz_rek.png') no-repeat #d2232a; width: 16px;">
        </td>
        <td>
            <a href="<?=$banner->clickUrl?>" target="_blank" style="margin-left: 3px;" class="ib">
                <img style=" vertical-align: top;
                    height: <?=$banner->place->height?>px;" src="<?=Y::imgUrl2($banner, 'image')?>">
            </a>
        </td>
        <td style="padding-left: 15px; text-align:left">
            <a href="<?=$banner->clickUrl?>" target="_blank" style="color: #000000; text-decoration: none;" >
                <span style="font-weight: bold;"><?=$banner->title?></span>
            </a><br>
            <a href="<?=$banner->clickUrl?>" target="_blank" style="" >
                <?=$banner->text?>
            </a>
        </td>
        <td valign="top">
            <div style="border: 2px solid #d2232a; width: 16px;
                height: <?=$banner->place->height - 4?>px; border-left: none;">&nbsp;</div>
        </td>
    </tr></table>
</div>