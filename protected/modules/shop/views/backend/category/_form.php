<?
$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>170)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form" style="margin-top: 0px;">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'article-category-form',
	'enableAjaxValidation'=>false,
)); ?>

    <input type="hidden" id="cat_id" value="<? echo $model->id; ?>" />
    <input type="hidden" id="parent_id"
           name="<? echo $this->modelName.'[parent_id]' ?>"
           value="<? echo $parent_model->id; ?>"
    />

    <? $this->widget('JuiTabs', array(
        'id'=>'cat-tabs',
        'tabs'=>array(
            'Основное'=>
                $this->renderPartial('_mainTab', array('form'=>$form, 'model'=>$model, 'parent_model'=>$parent_model),true),
            'Характеристики'=>
                $this->renderPartial('_attributeTab', array('form'=>$form, 'model'=>$model),true),
        ),
        'options'=>array( 'disable'=>true  ),
    )); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
