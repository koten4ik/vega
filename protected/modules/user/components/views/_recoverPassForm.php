<h1><?=Y::t('Восстановление пароля')?></h1><br>
<?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
<?php else: ?>

    <div class="form">
    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'recovery-form',
        'action'=>'',
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>false,
        ),
    ));?>


        <div class="row">
            <?php echo CHtml::activeLabel($model,'username'); ?>
            <?php echo CHtml::activeTextField($model,'username') ?>
            <?php echo CHtml::error($model,'username') ?>

        </div>


        <div class="row submit ib">
            <input type="submit" class="button" value="<? echo Yii::t('user',"Restore") ?>" onclick="
                $('#restore_process').show();
                $.post('/user/recovery', $('#recovery-form').serialize(),
                function(data)
                {
                    $('#item-tabs_tab_2').html(data);
                });
                return false;
            ">

        </div>
        <img src="<?=LOAD_ICO?>" style="display: none;" id="restore_process">

    <?php $this->endWidget(); ?>
    </div><!-- form -->

<?php endif; ?>