<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model PollItem */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 150)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad" style="">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'poll-item-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <div class="fl" style="width: 60%">

        <div class="row">
            <? echo $form->labelEx($model,'title', array('style'=>'display: inline-block; width:80px;')); ?>
            <? echo $form->textField($model,'title',array('style'=>'width:500px;','maxlength'=>255)); ?>
            <? echo $form->error($model,'title'); ?>
        </div>

        <div class="row" style="display: inline-block; margin-left: 85px; margin-top: 2px;">
            <?php echo $form->checkBox($model, 'published'); ?>
            <?php echo $form->labelEx($model, 'published', array('class' => 'after_cbox')); ?>
            <?php echo $form->error($model, 'published'); ?>
        </div>
        <div class="row" style="display: inline-block; margin-left: 50px; margin-bottom: 10px;">
            <?php echo $form->checkBox($model, 'finished'); ?>
            <?php echo $form->labelEx($model, 'finished', array('class' => 'after_cbox')); ?>
            <?php echo $form->error($model, 'finished'); ?>
        </div>
        <div class="row ib" style="margin-left: 40px; vertical-align: 2px;">
            <?php echo $form->labelEx($model,'position', array('style'=>'display:inline-block; width:40px')); ?>
            <?php echo $form->textField($model,'position',array('maxlength'=>150, 'style'=>'width:40px')); ?>
            <?php echo $form->error($model,'position'); ?>
        </div>
        <br>

        <? if(!$model->isNewRecord) $this->renderPartial('_elemValGrid', array('poll_id'=>$model->id));
           else echo 'Для добавления значений сохраните элемент!<br>';
        ?>
        <br>

        <div class="row" style="">
            <? echo $form->labelEx($model,'descr', array('style'=>'')); ?>
            <? echo $form->textArea($model,'descr',array('class'=>'elrte','rows'=>6, 'cols'=>10)); ?>
            <? echo $form->error($model,'descr'); ?>
        </div>


    </div>

    <div style="margin-left: 65%; padding-left: 15px">
        <? if(!$model->isNewRecord){?>
            <? $this->widget('PollWidget', array('poll'=>PollItem::model()->find('id='.$model->id),
                'show_rez'=>true,  'show_arch'=>false)); ?>
        <?}?>
    </div>
    <div class="fc"></div>


    <? echo CHtml::hiddenField('redirect');?>

<?php $this->endWidget(); ?>

</div><!-- form -->