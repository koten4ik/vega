<?
/** @var $this Controller */
/** @var $form ActiveForm */

$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>280)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'catalog-manufacturer-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

<div class="fl" style="width: 75%">

    <div class="fl" style="width: 100%; border: 0px solid">
        <div class="row">
            <?php echo $form->labelEx($model,'name', array('style'=>'display:inline-block; width:130px')); ?>
            <?php echo $form->textField($model,'name',array('maxlength'=>150, 'style'=>'width:72%')); ?>
            <?php echo $form->error($model,'name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'alias', array('style'=>'display:inline-block; width:130px')); ?>
            <?php echo $form->textField($model,'alias',array('maxlength'=>150, 'style'=>'width:72%')); ?>
            <?php echo $form->error($model,'alias'); ?>
        </div>
    </div>
    <!--div style="margin-left:50%; padding-left: 20px; border: 0px solid" >

        <div class="row fl" style="padding-top: 5px;" >
            <?php //echo $form->checkBox($model,'published'); ?>
            <?php //echo $form->labelEx($model,'published', array('class'=>'after_cbox')); ?>
            <?php //echo $form->error($model,'published'); ?>
        </div>


    </div-->
    <div class="fc"></div>

    <div class="row">
        <?php echo $form->labelEx($model,'descr'); ?>
        <?php echo $form->textArea($model,'descr',array( 'class'=>'elrte', 'rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'descr'); ?>
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
        <? $this->widget('FieldFile',
            array('field'=>'image', 'tmb_num'=>1, 'form'=>$form,'model'=>$model))?>
    </div>

</div>
<div class="fc"></div>

    <? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>$(function(){  $('input:first').focus();  });</script>


