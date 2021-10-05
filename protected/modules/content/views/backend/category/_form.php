<?
/** @var $this Controller */
/** @var $form ActiveForm */

$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>250)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form" style="margin-top: 0px;">
<?php $form=$this->beginWidget('ActiveForm', array('id'=>'content-category-form')); ?>

<?=Html::tableColumnOpen()?>

    <input type="hidden" id="cat_id" value="<? echo $model->id; ?>" />
    <input type="hidden" id="parent_id"
           name="<? echo $this->modelName.'[parent_id]' ?>"
           value="<? echo $parent_model->id; ?>"
    />
    <div class="row">
        <span>Родительская категория: </span>
        <span id="parent_name" style="font-weight: bold;" class="ib">
            <? echo $parent_model->title; ?>
        </span>
    </div>

    <?=Html::tableColumnOpen(430)?>
        <?= $form->textFieldW($model,'title',array( 'l_w'=>100, 'f_w'=>300, 'inl'=>1, 'ml_lng'=>1 )); ?>
    <?=Html::tableColumnNext()?>
        <?=$form->checkBoxW($model,'published',array( 'ml_lng'=>1 ));?>
    <?=Html::tableColumnClose()?>

    <?=$form->textAreaW($model,'descr',array( 'ml_lng'=>1, 'no_editor'=>0 )); ?>

    <?=Html::tableColumnNext(220,array('style'=>'padding-left:25px;'))?>

        <?=$form->fileFieldW($model,'image',array( 'tmb'=>1, 'img_w'=>220 ));?>
        <?= $form->textFieldW($model,'alias',array( 'l_w'=>85, 'f_w'=>220, 'inl'=>0 )); ?>

        <?=$form->textAreaW($model,'metaTitle',array( 'f_w'=>220, 'f_h'=>50, 'ml_lng'=>1, 'no_editor'=>1 )); ?>
        <?=$form->textAreaW($model,'metaKeys',array( 'f_w'=>220, 'f_h'=>50, 'ml_lng'=>1, 'no_editor'=>1 )); ?>
        <?=$form->textAreaW($model,'metaDesc',array( 'f_w'=>220, 'f_h'=>50, 'ml_lng'=>1, 'no_editor'=>1 )); ?>

    <?=Html::tableColumnClose()?>


<?php $this->endWidget(); ?>
</div><!-- form -->
