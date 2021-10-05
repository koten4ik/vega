<?php
?>

<h1 id="page_title"><?php echo Y::t('Изменение пароля'); ?></h1>

<div id="page_content" >
    <div class="form">
    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'changePass-form',
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'password', array('style'=>'')); ?>
            <?php echo $form->passwordField($model,'password',array('style'=>'')); ?>
            <?php echo $form->error($model,'password'); ?>
            <!--p class="hint"><?php echo Yii::t('user',"Minimal password length 4 symbols."); ?></p-->
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyPassword', array('style'=>'')); ?>
            <?php echo $form->passwordField($model,'verifyPassword',array('style'=>'')); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>

        <div class="row submit">

            <input type="submit"  value="<?=Y::t('Сохранить',0)?>" class="button">
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->

</div>