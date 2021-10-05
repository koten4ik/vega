<?
/** @var $this Controller */
/** @var $model User */
$this->registerScript('$("a[rel=upl_img]").fancybox();');
?>

<h1 id="page_title"><?=Y::t('Личная страница')?>: <?=$model->last_name; ?><span>

</span></h1>

<div id="page_content" class="page">
    <?=Html::divColumnOpen(230)?>
    
        <a rel="upl_img" href="<?=$model->fileUrl('avatar',1)?>" style="margin-bottom: 5px;" class="ib">
            <img style="width: 200px; border-radius: 2px;"
                 src="<?=$model->fileUrl('avatar',2)?>">
        </a>
        <?if(Y::user_id() && Y::user_id()!=$model->id){?>

            <?// $in_contact = User::checkContact($model->id);?>
            <!--div class="button" id="contact_butt" onclick="addContant(<?=$model->id?>)"
                 style="width: 182px; margin-bottom: 5px; display: <?= $in_contact ? 'none':'block'?>">
                <?=Y::t('добавить в контакты')?>
            </div>
            <div class="button" id="contact_remove_butt" onclick="removeContant(<?=$model->id?>)"
                 style="width: 182px; margin-bottom: 5px; display: <?= !$in_contact ? 'none':'block'?>">
                <?=Y::t('убрать из контактов')?>
            </div-->

            <a href="<?=$this->createUrl('/user/message/send',array('user_id'=>$model->id))?>" class="button" style="width: 182px;">
                <?=Y::t('отправить сообщение')?>
            </a>
        <?}?>

    <?=Html::divColumnNext(230)?>






    <?=Html::divColumnClose()?>



</div>