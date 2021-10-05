<?php $this->pageTitle=Yii::app()->name . ' - '.Yii::t('user',"Registration");
$this->breadcrumbs=array(
	Yii::t('user',"Registration"),
);
?>

<div id="page_title"><span><?php echo Yii::t('user',"Registration"); ?></span></div>

<div id="page_content" >

    <?php if(Yii::app()->user->hasFlash('registration')): ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('registration'); ?>
        </div>
    <?php else: ?>

    <div class="form">
    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'registration-form',
        'htmlOptions' => array('enctype'=>'multipart/form-data'),
    )); ?>

        <div class="row">
        	<?php echo $form->labelEx($model,'first_name'); ?>
        	<?php echo $form->textField($model,'first_name'); ?>
        	<?php echo $form->error($model,'first_name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'username'); ?>
            <?php echo $form->textField($model,'username'); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'password'); ?>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>

        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'verifyPassword'); ?>
            <?php echo $form->passwordField($model,'verifyPassword'); ?>
            <?php echo $form->error($model,'verifyPassword'); ?>
        </div>



        <?php if (UserModule::doCaptcha('registration')): ?>
        <div class="row">
            <?php echo $form->labelEx($model,'verifyCode'); ?>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model,'verifyCode'); ?>
            <?php echo $form->error($model,'verifyCode'); ?>

            <p class="hint"><?php echo Yii::t('user',"Please enter the letters as they are shown in the image above."); ?>
            <br/><?php echo Yii::t('user',"Letters are not case-sensitive."); ?></p>
        </div>
        <?php endif; ?>

        <div class="row submit">
            <input type="submit" value="<?=Y::t('Зарегистрироваться',0)?>" class="button">
        </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
    <?php endif; ?>

</div>