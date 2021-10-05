<?
?>

<h1 id="page_title"><?php echo Y::t('Восстановление пароля'); ?></h1>

<div id="page_content" >
    <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
    <?php else: ?>

        <div class="form">
        <?php $form=$this->beginWidget('ActiveForm', array(
            'id'=>'restore-form',
        )); ?>

            <div class="row">
                <?php echo $form->labelEx($model,'username', array('style'=>'')); ?>
                <?php echo $form->textField($model,'username',array('style'=>'')); ?>
                <?php echo $form->error($model,'username'); ?>
                <p class="hint"><?php echo Y::t('Пожалуйста, введите Ваш адрес электронной почты.'); ?></p>
            </div>

            <div class="row submit">
                <input type="submit"  value="<?=Y::t('Восстановить',0)?>" class="button">
            </div>

        <?php $this->endWidget(); ?>
        </div><!-- form -->

    <?php endif; ?>

</div>