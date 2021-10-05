<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model VideoItem */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">

    <?=Html::tableColumnOpen()?>

        <?php $form=$this->beginWidget('ActiveForm', array('id'=>'video-item-form')); ?>

        <?=Html::tableColumnOpen(550)?>
            <?= $form->textFieldW($model,'title',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 )); ?>
        <?=Html::tableColumnNext()?>
            <?=$form->checkBoxW($model,'published',array( 'ml_lng'=>1 ));?>
        <?=Html::tableColumnClose()?>

        <?= $form->timeFieldW($model, 'date', array( 'l_w'=>100, 'f_w'=>100, 'inl'=>1 )); ?>

        <?= $form->textFieldW($model, 'url', array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 )); ?>
        <b>или</b><br><br>
        <?=$form->textAreaW($model,'media_code',array( 'inl'=>1, 'f_h'=>100, 'no_editor'=>1 )); ?>
        <br>

        <?//=$form->textAreaW($model,'full_text',array( 'ml_lng'=>1, 'elrte_class'=>'elrte full' )); ?>
         <?=$form->textAreaW($model,'intro_text',array( 'ml_lng'=>1, 'elrte_class'=>'elrte short' )); ?>

        <? echo CHtml::hiddenField('redirect');?>

    <?=Html::tableColumnNext(283,array('style'=>'padding-left:15px;'))?>

        <?= $form->fileFieldW($model, 'image', array( 'l_w'=>100, 'f_w'=>300, 'tmb'=>2,'inl'=>1 )); ?>
        <? $this->renderPartial($this->viewDir . '_m_cat',array('model'=>$model,'form'=>$form)); ?>

    <?=Html::tableColumnClose()?>

<?php $this->endWidget(); ?>
</div><!-- form -->

