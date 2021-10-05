<?php
/*$this->pageTitle=Yii::app()->name . ' - Обратная связь';
$this->breadcrumbs=array(
	'Contact',
);*/
?>

<h1 id="page_title"><?=Y::t('Обратная связь')?></h1>

<div id="page_content">

    <?php if(Yii::app()->user->hasFlash('contact')): ?>

    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('contact'); ?>
    </div>

    <?php else: ?>

    <p><? echo ContentPage::model()->find('alias="contact-page"')->text; ?></p>
    <br>

    <div class="form">

    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'contact-form',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    )); ?>



        <?php //echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'name'); ?>
            <?php echo $form->textField($model,'name'); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'email'); ?>
            <?php echo $form->textField($model,'email'); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'subject'); ?>
            <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
            <?php echo $form->error($model,'subject'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'message'); ?>
            <?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>50)); ?>
            <?php echo $form->error($model,'message'); ?>
        </div>

        <?php if(CCaptcha::checkRequirements()): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>

            <div class="fl captcha" style="width: 150px;"> <?php $this->widget('CCaptcha'); ?></div>
            <?=Y::t('Введите символы из картинки')?> <span class="required">*</span><br>
            <?php echo $form->textField($model,'verifyCode'); ?>

            <?php echo $form->error($model,'verifyCode'); ?>
            <style>.captcha img{display: block;}</style>


        </div>
        <?php endif; ?>

        <br><br>
        <div class="row buttons">
            <?php echo CHtml::submitButton('Отправить'); ?>
        </div>

    <?php $this->endWidget(); ?>

    </div><!-- form -->

    <?php endif; ?>

</div>