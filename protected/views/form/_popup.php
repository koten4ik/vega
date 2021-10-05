<?php


?>

<?if($success){?>
    <b>Ваша заявка отправлена на модерацию</b>
<?}else{?>

<div class="form pad">
    <?php $form=$this->beginWidget('CActiveForm', array('id'=>'popup-form')); ?>
    
    <div class="row">
        <? echo $form->labelEx($model,'fio', array('style'=>'')); ?>
        <? echo $form->textField($model,'fio',array()); ?>
        <? echo $form->error($model,'fio'); ?>
    </div>


    <div class="row">
        <? echo $form->labelEx($model,'phone', array('style'=>'')); ?>
        <? echo $form->textField($model,'phone',array()); ?>
        <? echo $form->error($model,'phone'); ?>
    </div>
    <div class="row">
        <? echo $form->labelEx($model,'email', array('style'=>'')); ?>
        <? echo $form->textField($model,'email',array()); ?>
        <? echo $form->error($model,'email'); ?>
    </div>


    <div class="button" onclick="
        $.post('/form/popup', $('#popup-form').serialize(),
            function(data){ $('#popup-form-wrap').html(data);  }
    );">
        Отправить
    </div>
    
    <?php $this->endWidget(); ?>
</div>

<?}?>

<style type="text/css">
    input,textarea{width: 400px;}
</style>

