<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model Comments */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'comments-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

	<div class="row">
		<? echo $form->labelEx($model,'user_id', array('style'=>'display:inline-block')); ?>:
		<?echo CHtml::link($model->user->first_name.' '.$model->user->first_name,
            '/'.BACKEND_NAME.'/user/manage/update?id='.$model->user_id); ?>
		<? //echo $form->error($model,'user_id'); ?>
	</div>

    <div class="row">
        <? echo $form->labelEx($model,'create_time', array('style'=>'display:inline-block')); ?>
        <? echo Y::date_print($model->create_time,'d.m.Y - H:i'); ?>
        <? //echo $form->error($model,'create_time'); ?>
    </div>

	<!--div class="row">
		<? echo $form->labelEx($model,'name', array('style'=>'')); ?>
		<? echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<? echo $form->error($model,'name'); ?>
	</div-->

	<div class="row">
		<? echo $form->labelEx($model,'text', array('style'=>'')); ?>
		<? echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); ?>
		<? echo $form->error($model,'text'); ?>
	</div>

	<!--div class="row">
		<? echo $form->labelEx($model,'parent_id', array('style'=>'')); ?>
		<? echo $form->textField($model,'parent_id'); ?>
		<? echo $form->error($model,'parent_id'); ?>
	</div-->


	<!--div class="row">
		<? echo $form->labelEx($model,'like_cnt', array('style'=>'')); ?>
		<? echo $model->like_cnt;//echo $form->textField($model,'like_cnt'); ?>
		<? //echo $form->error($model,'like_cnt'); ?>
	</div-->

    <div class="row" style="">
        <?php echo $form->checkBox($model, 'published'); ?>
        <?php echo $form->labelEx($model, 'published', array('class' => 'after_cbox')); ?>
        <?php echo $form->error($model, 'published'); ?>
    </div>

	<div class="row">
		<? //echo $form->labelEx($model,'item_id', array('style'=>'')); ?>
		<? //if($model->model_key == Comments::CONTENT_ITEM)
                //echo CHtml::link()
        ?>
		<? //echo $form->error($model,'item_id'); ?>
	</div>

	<div class="row">
		<? echo $form->labelEx($model,'model_key', array('style'=>'display:inline-block')); ?>:
		<? echo $model->modelList($model->model_key); ?>
		<? //echo $form->error($model,'model_key'); ?>
	</div>

    <? echo CHtml::hiddenField('redirect');?>

<?php $this->endWidget(); ?>

</div><!-- form -->