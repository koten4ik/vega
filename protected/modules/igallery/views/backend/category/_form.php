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

<table width="100%" class="pad" style="" border="0">
    <tr>
        <td style="padding-right: 7px;">

            <div class="row">
                <span>Родительская категория: </span>
                <span id="parent_name" style="font-weight: bold;">
                    <? echo $parent_model->title; ?>
                </span>
            </div>
            <?
                if(Y::app()->params['multiLang'])
                    $this->widget('JuiTabs', array( 'id'=>'lang-tabs',  'tabs'=>array(
                        'Русский'=>$this->renderPartial($this->viewDir.'_ltab',array('lng'=>'','model'=>$model, 'form'=>$form),true),
                        'English'=>$this->renderPartial($this->viewDir.'_ltab',array('lng'=>'_l2','model'=>$model, 'form'=>$form),true),
                        //'DE'=>$this->renderPartial($this->viewDir.'_ltab',array('lng'=>'_l3','model'=>$model, 'form'=>$form),true),
                    ), 'options'=>array( 'disable'=>true  ),  ));
                else $this->renderPartial($this->viewDir.'_ltab',array('lng'=>'','model'=>$model, 'form'=>$form));
            ?>

        </td>
        <td width="250px" style="padding-left: 10px;">

            <div class="row">
                <?php echo $form->labelEx($model,'alias'); ?>
                <?php echo $form->textField($model,'alias', array( 'style'=>'width:99%', 'maxlength'=>150, 'disabled'=>$model->notDeleted)); ?>
                <?php echo $form->error($model,'alias'); ?>
            </div>

            <div class="row" style="padding: 5px 0px;">
                <?php echo $form->checkBox($model,'published'); ?>
                <?php echo $form->labelEx($model,'published', array('class'=>'after_cbox')); ?>
                <?php echo $form->error($model,'published'); ?>
            </div>
            <div class="row">
                <? $this->widget('FieldFile',
                    array('field'=>'image', 'tmb_num'=>1, 'form'=>$form,'model'=>$model, 'local_allow'=>1))?>
            </div>
            <div class="row">
            </div>
        </td>
    </tr>

</table>

<?php $this->endWidget(); ?>

</div><!-- form -->
