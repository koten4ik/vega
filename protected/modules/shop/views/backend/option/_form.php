<?
/** @var $this Controller */
/** @var $form ActiveForm */

?>

<div class="form  pad wide">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'catalog-option-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="fl" style="width: 50%; ">
        <div class="row">
            <?php echo $form->labelEx($model,'title', array('style'=>'display:inline-block; ')); ?>
            <?php echo $form->textField($model,'title',array('maxlength'=>150, 'style'=>'width:300px;')); ?>
            <?php echo $form->error($model,'title'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'title_add', array('style'=>'display:inline-block; ')); ?>
            <?php echo $form->textField($model,'title_add',array('maxlength'=>150, 'style'=>'width:300px;')); ?>
            <?php echo $form->error($model,'title_add'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'sufix', array('style'=>'display:inline-block; ')); ?>
            <?php echo $form->textField($model,'sufix',array('maxlength'=>150, 'style'=>'width:50px;')); ?>
            <?php echo $form->error($model,'sufix'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'position', array('style'=>'display:inline-block; ')); ?>
            <?php echo $form->textField($model,'position',array('maxlength'=>150, 'style'=>'width:50px;')); ?>
            <?php echo $form->error($model,'position'); ?>
        </div>

    </div>

    <div id="option_val_block" style="margin-left: 50%; padding-left:15px; width: 400px;">
        <? if(!$model->isNewRecord) $this->renderPartial('_optionValGrid', array('model'=>$model));
           else echo 'Для добавления значений сохраните опцию.';
        ?>
    </div>

    <div class="fc"></div>
    <? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>$(function(){  $('input:first').focus();  });</script>

