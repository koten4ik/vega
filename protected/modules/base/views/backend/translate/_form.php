<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BaseSourceMessage */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    //$('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'base-source-message-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'message', array('style'=>'display:inline-block; width:85px; vertical-align:top;')); ?>
        <?php echo $form->textArea($model,'message',
            array('maxlength'=>150, 'style'=>'width:72%', 'disabled'=>!$model->isNewRecord)); ?>
        <?php echo $form->error($model,'message'); ?>
    </div>
    <br>

    <?
    foreach($this->langs as $lang){ ?>
        <div class="row">
            <? echo CHtml::label($lang,'',array('style'=>'display:inline-block; width:85px; vertical-align:top;'))?>
            <? $val = $model->isNewRecord ? '' : BaseMessage::model()->find('id='.$model->id.' and language="'.$lang.'"')->translation;
            echo CHtml::textArea('tr_'.$lang, $val, array('style'=>'width:72%')   )?>
        </div>
    <? } ?>

    <br>
    <div class="row">
        <?php echo $form->labelEx($model,'category', array('style'=>'display:inline-block; width:85px')); ?>
        <?php echo $form->textField($model,'category',array('maxlength'=>150, 'style'=>'width:72%')); ?>
        <?php echo $form->error($model,'category'); ?>
    </div>

    <? echo CHtml::hiddenField('redirect');?>

<?php $this->endWidget(); ?>

</div><!-- form -->