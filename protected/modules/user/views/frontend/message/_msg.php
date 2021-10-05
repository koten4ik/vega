<?
/** @var $this Controller */
/** @var $data UserMsgGroup */
?>

<div class="_view" style="margin: 20px 0;">

    <span class="fr" style="color: gray; font-size: 80%;"><?=Y::date_print($data->c_time,'d.m.Y',1)?></span>
    <?if($data->user){ ?>
        <img src="<?=$data->user->fileUrl('avatar',3)?>" style="width: 50px; margin-right: 15px;" class="fl">
    <?}else{?>
        <?=Y::t('Пользователь удален')?>
    <?}?>

    <b><?=$data->user->first_name?>:</b><br>
    <?=$data->text?>
    <div class="fc"></div>
</div>