<?php
?>

<!-- рендер _формы в нужном месте-->
<!--div style="padding: 40px; padding-top: 80px;" id="popup-form-wrap">
    <?//$this->controller->renderPartial('application.views.form._popup',
      //  array('model'=>new CustomForm()))?>
</div-->

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
        $.post('/form/custom', $('#custom-form').serialize(),
            function(data){ $('#custom-form-wrap').html(data);  }
    );">
        Отправить
    </div>
    
    <?php $this->endWidget(); ?>
</div>

<?}?>

<style type="text/css">
    input,textarea{width: 400px;}
</style>
