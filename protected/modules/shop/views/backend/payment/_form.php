<?
/** @var $this Controller */
/** @var $form ActiveForm */

$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>200)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'catalog-payment-form',
	'enableAjaxValidation'=>false,
)); ?>


    <div class="row fl">
        <?php echo $form->labelEx($model,'name', array('style'=>'display:inline-block; width:85px')); ?>
        <?php echo $form->textField($model,'name',array('maxlength'=>150, 'style'=>'width:300px')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row fl" style="margin-left: 60px; padding-top: 5px;" >
        <?php echo $form->checkBox($model,'published'); ?>
        <?php echo $form->labelEx($model,'published', array('class'=>'after_cbox')); ?>
        <?php echo $form->error($model,'published'); ?>
    </div>

    <div class="row fl " style="margin-left: 60px;">
        <?php echo $form->labelEx($model,'ordering', array('style'=>'display:inline-block; width:130px')); ?>
        <?php echo $form->textField($model,'ordering',array('maxlength'=>150, 'style'=>'width:30px')); ?>
        <?php echo $form->error($model,'ordering'); ?>
    </div>


    <div class="fc"></div>
<br>
    <div class="row">
        <?php echo $form->labelEx($model,'descr', array('style'=>'display:inline-block; width:88px', 'class'=>'fl')); ?>
        <?php echo $form->textArea($model,'descr',array( 'id'=>'descr', 'class'=>'fl elrte')); ?>
        <?php echo $form->error($model,'descr'); ?>
    </div>



<?php $this->endWidget(); ?>

</div><!-- form -->



<script>$(function(){  $('input:first').focus();  });</script>