<?
/** @var $this Controller */
/** @var $form ActiveForm */

$this->registerScript("
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
?>

<div class="form pad">
<?php $form=$this->beginWidget('ActiveForm', array('id'=>'content-item-form')); ?>

    <?=Html::tableColumnOpen()?>

        <?=Html::tableColumnOpen(550)?>
            <?= $form->textFieldW($model,'title',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 )); ?>
        <?=Html::tableColumnNext()?>
            <?=$form->checkBoxW($model,'published',array( 'ml_lng'=>1 ));?>
        <?=Html::tableColumnClose()?>

        <?=$form->textAreaW($model,'full_text',array( 'f_w'=>'100%', 'ml_lng'=>1, 'elrte_class'=>'elrte full' )); ?>
        <?=$form->textAreaW($model,'intro_text',array( 'f_w'=>'100%', 'ml_lng'=>1, 'elrte_class'=>'elrte short' )); ?>

        <?=$form->textAreaW($model,'metaTitle',array( 'f_h'=>50, 'ml_lng'=>1, 'no_editor'=>1 )); ?>
        <?=$form->textAreaW($model,'metaKeys',array( 'f_h'=>50, 'ml_lng'=>1, 'no_editor'=>1 )); ?>
        <?=$form->textAreaW($model,'metaDesc',array( 'f_h'=>50, 'ml_lng'=>1, 'no_editor'=>1 )); ?>

    <?=Html::tableColumnNext(283,array('style'=>'padding-left:15px;'))?>

        <?if($model->multiCat)
            echo $form->categoryMultyFieldW($model,'catList','ContentCategory');
        else echo $form->categoryFieldW($model,'cat_id','ContentCategory',
                  array( 'l_w'=>85, 'f_w'=>190, 'inl'=>1 ));  ?>

        <?=$form->timeFieldW($model,'cdate',array( 'l_w'=>85, 'f_w'=>193, 'inl'=>1, 'format'=>'d-m-Y',
            'style'=>'text-align:left !important;'));?>
        <?= $form->textFieldW($model,'alias',array( 'l_w'=>85, 'f_w'=>193, 'inl'=>1, 'ml_lng'=>0 )); ?>

        <div class="row">
            <?php echo CHtml::label('Просмотры материала: ', '', array('style' => 'display:inline')); ?>
            <?php echo $model->hits; ?>
        </div>
        <br>

        <?=$form->fileFieldW($model,'image',array( 'tmb'=>1, 'img_w'=>275 ));?>
        <?//=$form->fileFieldW($model,'file',array());?>

        <? //$this->renderPartial($this->viewDir . '_related',array('model'=>$model)); ?>
        <? //$this->renderPartial($this->viewDir . '_tags',array('model'=>$model)); ?>

    <?=Html::tableColumnClose()?>

    <? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->

