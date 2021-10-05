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
	'id'=>'catalog-item-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

<div class="fl" style="width: 75%">


    <? $this->widget('JuiTabs', array(
        'id'=>'item-tabs',
        'tabs'=>array(
            'Основное'=>
                $this->renderPartial('_mainTab', array('form'=>$form, 'model'=>$model),true),
            'Характеристики'=>
                $this->renderPartial('_attributeTab', array('form'=>$form, 'model'=>$model),true),
            'Опции'=>
                $this->renderPartial('_optionTab', array('form'=>$form, 'model'=>$model),true),
            'Изображения'=>
                $this->renderPartial('_imageTab', array('form'=>$form, 'model'=>$model),true),
            'Видео'=>
                $this->renderPartial('_videoTab', array('form'=>$form, 'model'=>$model),true),
            'Связанные товары'=>
                $this->renderPartial('_relatedTab', array('form'=>$form, 'model'=>$model),true),

        ),
        'options'=>array( 'disable'=>true  ),
    )); ?>

    <br>

    <div class="row">
        <?php echo $form->labelEx($model,'descr', array('style'=>'')); ?>
        <? echo $form->textArea($model,'descr',array( 'class'=>'elrte', 'rows'=>6, 'cols'=>20)); ?>
    </div>

</div>

<div style="margin-left: 75%; padding-left: 15px">

    <div class="row">
        <?php echo $form->labelEx($model,'metaTitle'); ?>
        <?php echo $form->textArea($model,'metaTitle',array('rows'=>1, 'style'=>'width:98%')); ?>
        <?php echo $form->error($model,'metaTitle'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'metaKeys'); ?>
		<?php echo $form->textArea($model,'metaKeys',array('rows'=>4, 'style'=>'width:98%')); ?>
		<?php echo $form->error($model,'metaKeys'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metaDesc'); ?>
		<?php echo $form->textArea($model,'metaDesc',array('rows'=>4, 'style'=>'width:98%')); ?>
		<?php echo $form->error($model,'metaDesc'); ?>
	</div>

	<div class="row">
		<?php echo CHtml::label('Просмотры товара: ','', array('style'=>'display:inline')); ?>
		<?php echo $model->hits; ?>
	</div>
    <br>
    <div class="row">
        <? $this->widget('FieldFile',
            array('field'=>'image', 'tmb_num'=>1, 'form'=>$form,'model'=>$model))?>
    </div>

</div>
<div class="fc"></div>

    <? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

