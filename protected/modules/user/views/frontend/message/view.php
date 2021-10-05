<?
/** @var $this Controller */
/** @var $model UserMsgGroup */
?>

<h1 id="page_title"><?=Y::t('Диалог: Вы и').' '.$user->fio?></h1>

<div id="page_content">

    <label><?=Y::t('Сообщение')?></label><br>
    <textarea id="msg_area" rows="4" cols="60" style="margin-bottom: 5px;"></textarea>
    <br>
    <button class="button" style="width: 150px;" onclick="sendMsg(<?=$group->id?>,$('#msg_area').val())">
        <?=Y::t('Отправить')?>
    </button>
    <br><br>
    <?
    $this->widget('ListViewFront', array(
    	'id'=>'user-msg-group-list',
        'emptyText'=>Y::t('Нет сообщений'),
        'ajaxUpdate'=>true,
    	'dataProvider'=>$model->search_front(),
        'itemView'=>'_msg',
        )
    );
    ?>
</div>