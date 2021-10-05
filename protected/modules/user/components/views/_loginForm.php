<div class="form">
    <?php $form = $this->beginWidget('ActiveForm', array(
    'id' => 'login-form',
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

    <div class="row submit ib">
        <input type="submit" style="padding: 2px 20px;" class="button" value="<? echo Y::t('Вход',0) ?>" onclick="
                $('#login_process').show();
                $.post('/user/login/loginA', $('#login-form').serialize(),
                function(data)
                {
                    $('#item-tabs_tab_0').html(data);
                });
                return false;
            ">
        <!--div class="ib" style=" margin-left: 15px; vertical-align: 2px; ">
            <a href="#" onclick="$('#item-tabs_tab_2').slideToggle(); return false;"><?=Y::t("Забыли пароль?")?></a>
        </div-->
    </div>
    <img src="<?=LOAD_ICO?>" style="display: none;" id="login_process">

    <div class="row">
            <label><?=Yii::t('user', 'Войти через')?>:</label>
            <span style="vertical-align: -10px; display: inline-block;">
                <? $this->widget('uLoginWidget'); ?>
            </span>
        </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->