<?
/** @var $this Controller */
/** @var $data UserMsgGroup */
$user = $data->user->id == Y::user_id() ? $data->user2 : $data->user;
$noReadedCnt = UserMsg::noReadedCnt($data->id);
?>

<div class="_view" style="padding: 10px 0; border-bottom: 1px solid gray">


    <?if($user){ ?>
        <img src="<?=$user->fileUrl('avatar',3)?>" style="width: 50px; margin-right: 15px;" class="fl">
    <?}else{?>
        <?=Y::t('Пользователь удален')?>
    <?}?>

    <a href="<?=$user->url?>" target="_blank">
        <?=$user->fio?>
    </a>
    <br><br>
    <a href="<?=$data->getUrl()?>">
        <?= Y::t('Последнее сообщение: ').Y::date_print($data->last_msg->c_time,'d.m.Y',1)?>.
        <? if($noReadedCnt) echo '<span style="color:green">('.Y::t('Новых: ').$noReadedCnt.')</span>' ?>
    </a>
    <div class="fc"></div>

</div>