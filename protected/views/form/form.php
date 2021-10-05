<?php

$this->setSEO(array('title'=>$data->metaTitle));
?>

<h1><?=$data->title?></h1>

<div id="page_content" >

<div>
    <?= nl2br($data->text)?>
</div>
<br>

<?if($success){?>
    <b>Ваша заявка отправлена на модерацию</b>
<?}else{?>

<div class="form pad">
    <?php $form=$this->beginWidget('CActiveForm', array('id'=>'radio-request-form')); ?>
    
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


    <button type="submit" class="button">Отправить</button>
    
    <?php $this->endWidget(); ?>
</div>

<?}?>

<style type="text/css">
    input,textarea{width: 400px;}
</style>

</div>