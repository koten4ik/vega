<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BannerPlace */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'banner-place-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <?= Html::divColumnOpen(500)?>

    <div class="row">
        <? echo $form->labelEx($model,'title_adm', array('style'=>'')); ?>
        <? echo $form->textField($model,'title_adm',array('size'=>60,'maxlength'=>255)); ?>
        <? echo $form->error($model,'title_adm'); ?>
    </div>

	<div class="row">
		<? echo $form->labelEx($model,'title', array('style'=>'')); ?>
		<? echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<? echo $form->error($model,'title'); ?>
	</div>

    <div class="row" style="" >
        <?php echo $form->labelEx($model,'stretches', array('style'=>'')); ?>
        <?php echo $form->dropDownList($model,'stretches',
            array(0=>'одно место - один баннер', 1=>'одно место - много баннеров')); ?>
        <?php echo $form->error($model,'stretches'); ?>
    </div>

    <div class="row">
        <? echo $form->labelEx($model,'elem_cnt', array('style'=>'')); ?>
        <? echo $form->textField($model,'elem_cnt',array()); ?>
        <? echo $form->error($model,'elem_cnt'); ?>
    </div>

    <div class="row">
        <? echo $form->labelEx($model, 'width', array('style' => '')); ?>
        <? echo $form->textField($model, 'width', array('size' => 5, 'maxlength' => 255)); ?>
        <? echo $form->error($model, 'width'); ?>
    </div>
    <div class="row">
        <? echo $form->labelEx($model, 'height', array('style' => '')); ?>
        <? echo $form->textField($model, 'height', array('size' => 5, 'maxlength' => 255)); ?>
        <? echo $form->error($model, 'height'); ?>
    </div>
    <!--div class="row">
        <? echo $form->labelEx($model, 'title_lim', array('style' => '')); ?>
        <? echo $form->textField($model, 'title_lim', array('size' => 5, 'maxlength' => 255)); ?>
        <? echo $form->error($model, 'title_lim'); ?>
    </div>
    <div class="row">
        <? echo $form->labelEx($model, 'descr_lim', array('style' => '')); ?>
        <? echo $form->textField($model, 'descr_lim', array('size' => 5, 'maxlength' => 255)); ?>
        <? echo $form->error($model, 'descr_lim'); ?>
    </div-->

    <div class="row">
        <? echo $form->labelEx($model, 'bg_color', array('style' => '')); ?>
        <? echo $form->textField($model, 'bg_color', array('size' => 8, 'maxlength' => 255)); ?>
        <? echo $form->error($model, 'bg_color'); ?>
    </div>

    <?= Html::divColumnNext(500)?>
    <div class="row">
        <? echo $form->labelEx($model, 'comment', array('style' => '')); ?>
        <? echo $form->textArea($model, 'comment', array('cols' => 48, 'rows'=>18, 'maxlength' => 255)); ?>
        <? echo $form->error($model, 'comment'); ?>
    </div>
    <?= Html::divColumnClose()?>

    <? echo CHtml::hiddenField('redirect');?>

<?php $this->endWidget(); ?>

</div><!-- form -->