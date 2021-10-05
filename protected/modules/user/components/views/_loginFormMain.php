<div class="form" id="login_form_wrap">
    <?php $form = $this->beginWidget('ActiveForm', array(
    'id' => 'login-form_W',
    'action' => 'https://' . Y::app()->request->serverName,
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));?>


    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username') ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password') ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <? if ($model->getError('status')) { ?>
    <div class="row">
        <span class="errorMessage"><?php echo $model->getError('status'); ?></span>
    </div>
    <? } ?>

    <div class="submit ib">
        <input type="submit" class="button" style="padding: 3px 25px;"
               value="<? echo Yii::t('user', "Login") ?>"
               onclick="
                    $('#login_process_W').show();
                    $.post('/user/login/loginAMain', $('#login-form_W').serialize(),
                    function(data)
                    {
                        $('#user_login_block').html(data);
                    });
                    return false;
                ">
        <div class="ib" style="font-size: 80%; line-height: 1; margin-left: 5px; vertical-align: -3px; width: 50px;">
            <?php echo CHtml::link(Y::t("Забыли пароль?"), array("/user/recovery")); ?>
        </div>
    </div>
    <img src="<?=LOAD_ICO?>" style="display: none;" id="login_process_W">


    <?php $this->endWidget(); ?>
</div><!-- form -->


<a href="/user/login" class="button" style="padding: 3px 35px; margin-top: 10px;">
    <?=Y::t("Регистрация")?>
</a>
