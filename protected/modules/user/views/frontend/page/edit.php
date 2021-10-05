<?
/** @var $this Controller */
/** @var $model User */
?>

<h1 id="page_title"><? echo Y::t('Изменение личных данных'); ?></h1>

<div id="page_content">
    <? $this->drawFlash('mod-msg','info_success')?>
    <? $this->drawFlash('mod-msg-err','info_error')?>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>