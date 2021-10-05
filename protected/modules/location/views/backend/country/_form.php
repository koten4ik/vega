<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationCountry */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">
    <?php $form = $this->beginWidget('ActiveForm', array('id' => 'location-country-form')); ?>

    <div class="row">
        <? echo $form->labelEx($model, 'capital_id', array('style' => '')); ?>
        <? echo $model->capital ? $model->capital->title : $model->capital_id; ?>
    </div>
    <br>
    <?= $form->textFieldW($model, 'title', array('l_w' => 100, 'f_w' => 300, 'inl' => 1)); ?>
    <?= $form->textFieldW($model, 'title_en', array('l_w' => 100, 'f_w' => 300, 'inl' => 1)); ?>
    <br>
    <?= $form->checkBoxW($model, 'published', array('style'=>'margin-left:100px;'))?>
    <?= $form->textFieldW($model, 'position', array('l_w' => 100, 'f_w' => 50, 'inl' => 1)); ?>

    <? echo CHtml::hiddenField('redirect');?>

    <?php $this->endWidget(); ?>
</div><!-- form -->

<style type="text/css">
    label{ display: inline-block !important; width: 100px;}
</style>