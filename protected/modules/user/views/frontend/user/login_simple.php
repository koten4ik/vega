<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('user',"Login");
$this->breadcrumbs = array(
    Yii::t('user',"Login"),
);
?>

<div id="page_title"><span><?php echo Yii::t('user',"Login"); ?></span></div>

<div id="page_content">

    <?php if (Yii::app()->user->hasFlash('loginMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>
    <?php endif; ?>


    <div class="form">
        <?php $form = $this->beginWidget('ActiveForm', array(
        'id' => 'login-form',
    )); ?>

        <div class="row">
            <?php echo $form->labelEx($model, 'username', array('style' => '')); ?>
            <?php echo $form->textField($model, 'username', array('style' => '')); ?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'password', array('style' => '')); ?>
            <?php echo $form->passwordField($model, 'password', array('style' => '')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>


        <div class="row">
            <?php echo $form->error($model, 'status'); ?>
        </div>


        <div class="row">
            <p class="hint">
                <?php echo CHtml::link(Yii::t('user',"Register"), array("/user/registration")); ?>
                | <?php echo CHtml::link(Yii::t('user',"Lost Password?"), array("/user/recovery")); ?>
            </p>
        </div>

        <div class="row rememberMe">
            <?php echo $form->checkBox($model, 'rememberMe'); ?>
            <?php echo $form->labelEx($model, 'rememberMe', array('class' => 'after_cbox')); ?>
        </div>

        <div class="row submit">
            <input type="submit" value="<?=Y::t('Войти',0)?>" class="button">
        </div>

        <?php $this->endWidget(); ?>
    </div>
    <!-- form -->

</div>

