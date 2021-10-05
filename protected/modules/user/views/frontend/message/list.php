<?
/** @var $this Controller */
/** @var $model UserMsgGroup */
?>

<h1 id="page_title"><?=Y::t('Ваши сообщения') ?></span></h1>

<div id="page_content">
    <?
    $this->widget('ListViewFront', array(
    	'id'=>'user-msg-group-list',
    	'dataProvider'=>$model->search_front(),
        'itemView'=>'_view',
        )
    );
    ?>
</div>