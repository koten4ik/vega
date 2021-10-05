<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model ContentTag */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'content-tag-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<div class="row">
		<? echo $form->labelEx($model,'title', array('style'=>'')); ?>
		<? echo $form->textField($model,'title',array('size'=>80,'maxlength'=>255)); ?>
		<? echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($model,'descr', array('style'=>'')); ?>
		<? echo $form->textArea($model,'descr',array('cols'=>60,'maxlength'=>255)); ?>
		<? echo $form->error($model,'descr'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($model,'count', array('style'=>'display:inline')); ?>
		<? echo $model->count; ?>
	</div>

    <? echo CHtml::hiddenField('redirect');?>

<?php $this->endWidget(); ?>

</div><!-- form -->