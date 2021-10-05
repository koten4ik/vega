<?
/** @var $this Controller */
/** @var $form ActiveForm */

$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>380)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form pad">
<?php $form=$this->beginWidget('ActiveForm', array('id'=>'content-page-form')); ?>

<?=Html::tableColumnOpen()?>

    <?=Html::tableColumnOpen(650)?>
        <?= $form->textFieldW($model,'title_adm',array( 'l_w'=>180, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>0 )); ?>
        <?= $form->textFieldW($model,'title',array( 'l_w'=>180, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 )); ?>
    <?=Html::tableColumnNext()?>
        <?//=$form->checkBoxW($model,'published',array( 'ml_lng'=>1 ));?>
    <?=Html::tableColumnClose()?>

    <?=$form->textAreaW($model,'text',array( 'f_w'=>'100%', 'f_h'=>550,'ml_lng'=>1, 'no_editor'=>0 )); ?>

<?=Html::tableColumnNext(220,array('style'=>'padding-left:25px;'))?>

    <?= $form->textFieldW($model,'alias',array( 'l_w'=>85, 'f_w'=>220, 'inl'=>0 )); ?>
    <? if($this->module->id=='content') echo $form->selectFieldW($model,'module_id',ContentPage::modules(),array( 'l_w'=>85, 'f_w'=>220, 'inl'=>0 )); ?>

    <?=$form->fileFieldW($model,'image',array( 'tmb'=>1, 'img_w'=>275 ));?>

    <?=$form->textAreaW($model,'metaTitle',array( 'f_w'=>220, 'f_h'=>100, 'ml_lng'=>1, 'no_editor'=>1 )); ?>
    <?=$form->textAreaW($model,'metaKeys',array( 'f_w'=>220, 'f_h'=>100, 'ml_lng'=>1, 'no_editor'=>1 )); ?>
    <?=$form->textAreaW($model,'metaDesc',array( 'f_w'=>220, 'f_h'=>100, 'ml_lng'=>1, 'no_editor'=>1 )); ?>

<?=Html::tableColumnClose()?>

<? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
