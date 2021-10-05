<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model Banner */

$this->registerScript("
    $('.elrte').elrte(".Y::elrteOpts(array('height'=>230)).");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form pad">
<?php $form=$this->beginWidget('ActiveForm', array('id'=>'banner-form')); ?>

<?=Html::tableColumnOpen()?>

    <?=Html::tableColumnOpen(550)?>

        <?= $form->textFieldW($model,'title_adm',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>0 )); ?>
        <?= $form->textFieldW($model,'title',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 )); ?>
        <?= $form->textFieldW($model,'url',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 )); ?>
        <?= $form->selectFieldW($model,'place_id', BannerPlace::getList(), array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 )); ?>
        <?//= $form->selectFieldW($model,'type', BannerPlace::typeList(), array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 )); ?>

    <?=Html::tableColumnNext()?>

        <?=$form->checkBoxW($model,'published',array( 'ml_lng'=>0 ));?>
        <?= $form->textFieldW($model,'position',array( 'l_w'=>85, 'f_w'=>60, 'inl'=>1 )); ?>
        <?= $form->textFieldW($model,'rotation_percent',array( 'l_w'=>85, 'f_w'=>60, 'inl'=>1 )); ?>

    <?=Html::tableColumnClose()?>

    <?=$form->textAreaW($model,'text',array( 'f_w'=>400, 'f_h'=>100, 'ml_lng'=>1, 'no_editor'=>0 )); ?>

<?=Html::tableColumnNext('22%',array('style'=>'padding-left:25px;'))?>

    <?= $form->timeFieldW($model,'from_time',array( 'l_w'=>110, 'f_w'=>130, 'inl'=>1 ));?>
    <?= $form->timeFieldW($model,'to_time',array( 'l_w'=>110, 'f_w'=>130, 'inl'=>1 ));?>

    <?= $form->fileFieldW($model,'image',array( 'tmb'=>1 ));?>
    <br>
    <?= $form->fileFieldW($model,'flash_file',array());?>

    <?= $form->textFieldW($model,'flash_width',array( 'l_w'=>85, 'f_w'=>160, 'inl'=>1 )); ?>
    <?= $form->textFieldW($model,'flash_height',array( 'l_w'=>85, 'f_w'=>160, 'inl'=>1 )); ?>

<? if(!$model->isNewRecord){?>
    <br>
    <b>Статистика:</b>
    <img id="stat_loading" src="<?=LOAD_ICO?>" style="vertical-align: -4px; margin-left: 10px; display: none;">
    <br>
    <div style="margin-top: 5px;" class="ib">Период</div>
    <?= Html::dateInput('from', array('onchange' => 'getStat()','size'=>10))?>
    -
    <?= Html::dateInput('to', array('onchange' => 'getStat()','size'=>10))?>
    <a href="#" onclick="$('#from').val(''),$('#to').val('');$('#from').trigger('change'); return false;">x</a>
    <br><br>
    <div id="stat_rezult"></div>
    <script type="text/javascript">
        function getStat() {
            $('#stat_loading').show();
            $("#stat_rezult").load(
                "getStat?from=" + $('#from').val() + "&to=" + $('#to').val() + "&banner_id=<?=$model->id?>",
                function () { $('#stat_loading').hide(); }
            );
        }
        $('#from').trigger('change');
    </script>
    <style>
        .st_lb { width: 120px; display: inline-block; padding-bottom: 5px;}
        .stat input { width: 90px; }
    </style>
<?}?>

<?=Html::tableColumnClose()?>

<? echo CHtml::hiddenField('redirect');?>

<?php $this->endWidget(); ?>
</div><!-- form -->


<? $this->beginWidget('JuiDialog', array('id'=>'stat_dialog','title'=>'Выгрузить переходы'));?>
    <form action="getStats?banner_id=<?=$model->id?>" method="post">
        <input type="text" style="width: 0px; border: none;"><br>
        <? echo $form->labelEx($model, 'stat_from', array('style' => '')); ?><br>
        <? $this->widget('FieldTime', array('style' => 'text-align:center;',
                    'field' => 'stat_from', 'model' => $model ))?>
        <br><br>
        <? echo $form->labelEx($model, 'stat_to', array('style' => '')); ?><br>
        <? $this->widget('FieldTime', array('style' => 'text-align:center;',
                    'field' => 'stat_to', 'model' => $model ))?>
        <br><br>
        <button type="submit" >Выгрузить</button>
    </form>
<? $this->endWidget('JuiDialog'); ?>