<?php
/** @var $this Controller */
/** @var $model ContentItem */
?>

<div id="page_title"><span><? echo Yii::t('user','Your profile') ?></span></div>

<div id="page_content" >

    <?php if(Yii::app()->user->hasFlash('profileMessage')) { ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
        </div>
        <br>
    <?php } ?>

    <div class="form">
    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'profile-form',
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($user,'first_name'); ?>
            <?php echo $form->textField($user,'first_name'); ?>
            <?php echo $form->error($user,'first_name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($user,'last_name'); ?>
            <?php echo $form->textField($user,'last_name'); ?>
            <?php echo $form->error($user,'last_name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($user,'email'); ?>
            <?php echo $form->textField($user,'email'); ?>
            <?php echo $form->error($user,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($user, 'password_new'); ?>
            <?php echo $form->passwordField($user, 'password_new') ?>
            <?php echo $form->error($user, 'password_new'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($user, 'verifyPassword_new'); ?>
            <?php echo $form->passwordField($user, 'verifyPassword_new') ?>
            <?php echo $form->error($user, 'verifyPassword_new'); ?>
        </div>

        <div class="row">
            <? $this->widget('FieldFile',
            array('field' => 'avatar', 'tmb_num' => 1, 'server_allow'=>false, 'form' => $form, 'model' => $user))?>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton(Yii::t('user',"Save")); ?>
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->


</div>