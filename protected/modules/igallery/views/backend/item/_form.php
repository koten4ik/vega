<?
/** @var $this Controller */
/** @var $form ActiveForm */

$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>150)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form pad">

<?php $form = $this->beginWidget('ActiveForm', array(
    'id' => 'igallery-item-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<table>
    <tr>
        <td style="width: 50%; padding-right: 30px;">

            Изображения:
            <?
            if (!$model->isNewRecord) {
                $this->renderPartial('_images',array('form'=>$form, 'model'=>$model));
            } else echo 'Для добавления изображений сохраните альбом.';
            ?>

        </td>

        <td style=" ">

            <div class="fl" style="width: 60%;">

                <div class="row" style="height: 25px">
                    <?php echo $form->labelEx($model, 'cat_id', array('style' => 'width:80px; display:inline-block;')); ?>
                    <? $this->widget('FieldCategory', array('field' => 'cat_id', 'form' => $form, 'model' => $model,
                            'catModel' => 'IgalleryCategory', 'style'=>'width:68%;'))?>
                    <?php echo $form->error($model, 'cat_id'); ?>
                </div>

                <div class="row" style="height: 25px;">
                    <?php echo $form->labelEx($model, 'cdate', array('style' => 'width:80px; display:inline-block')); ?>
                    <?php $this->widget('FieldTime', array('field' => 'cdate', 'model' => $model, 'style' => 'width:68%'))?>
                    <?php echo $form->error($model, 'cdate'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'alias', array('style' => 'width:80px; display:inline-block')); ?>
                    <?php echo $form->textField($model, 'alias', array('maxlength' => 150, 'style' => 'width:68%')); ?>
                    <?php echo $form->error($model, 'alias'); ?>
                </div>

                <div class="row">
                    <?php echo $form->labelEx($model, 'position', array('style' => 'width:80px; display:inline-block')); ?>
                    <?php echo $form->textField($model, 'position', array('maxlength' => 150, 'style' => 'width:68%')); ?>
                    <?php echo $form->error($model, 'position'); ?>
                </div>
            </div>
            <div class="row" style="">
                <? $this->widget('FieldFile',
                array('field' => 'image', 'tmb_num' => 2, 'form' => $form, 'model' => $model))?>
                <style>#IgalleryItem_image_tmp_block{width: 210px;}</style>
            </div>
            <div class="fc"></div>

            <?
            if (Y::app()->params['multiLang'])
                $this->widget('JuiTabs', array('id' => 'lang-tabs', 'tabs' => array(
                    'Русский' => $this->renderPartial($this->viewDir.'_ltab', array('lng' => '', 'model' => $model, 'form' => $form), true),
                    'English' => $this->renderPartial($this->viewDir.'_ltab', array('lng' => '_l2', 'model' => $model, 'form' => $form), true),
                    //'DE' => $this->renderPartial($this->viewDir.'_ltab', array('lng' => '_l3', 'model' => $model, 'form' => $form), true),
                ), 'options' => array('disable' => true),));
            else $this->renderPartial($this->viewDir.'_ltab', array('lng' => '', 'model' => $model, 'form' => $form));
            ?>

        </td>
    </tr>
</table>

<? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
