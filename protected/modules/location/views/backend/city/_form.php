<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationCity */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">
<?php $form=$this->beginWidget('ActiveForm', array('id'=>'location-city-form')); ?>

    <label class="ib">Район</label>
    <? $this->widget('LocationMultiWidget', array('id'=>'location_model','model_name'=>$this->modelName,
            'fields'=>array( 'country_id'=>$model->country_id, 'oblast_id'=>$model->oblast_id,
                'raion_id'=>$model->raion_id, null
    )));?>
    <br>

    <?= $form->textFieldW($model, 'title', array('l_w' => 100, 'f_w' => 300, 'inl' => 1)); ?>
    <?= $form->textFieldW($model, 'title_en', array('l_w' => 100, 'f_w' => 300, 'inl' => 1)); ?>

    <br>
    <?= $form->checkBoxW($model, 'published', array('style'=>'margin-left:100px;'))?>

    <? echo CHtml::hiddenField('redirect');?>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<style type="text/css">
    label{ display: inline-block !important; width: 100px;}
</style>