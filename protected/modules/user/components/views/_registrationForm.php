

    <div class="form">
    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'registration-form',
        'action'=>'https://'.Y::app()->request->serverName,
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
    ));?>


        <div class="row">
        	<?php echo $form->labelEx($model,'first_name'); ?>
        	<?php echo $form->textField($model,'first_name'); ?>
        	<?php echo $form->error($model,'first_name'); ?>
        </div>

    	<div class="row">
    		<?php echo $form->labelEx($model,'username'); ?>
    		<?php echo $form->textField($model,'username') ?>
            <?php echo $form->error($model,'username'); ?>
    	</div>

    	<div class="row">
    		<?php echo $form->labelEx($model,'password'); ?>
    		<?php echo $form->passwordField($model,'password') ?>
            <?php echo $form->error($model,'password'); ?>
    	</div>

        <div class="row">
            <?php //echo $form->labelEx($profile,'gender'); ?>
            <?php //echo $form->textField($profile,'gender'); ?>
            <?php //echo $form->error($profile,'gender'); ?>
        </div>

    	<div class="row submit ib">
            <input type="submit" class="button" value="<? echo Yii::t('user',"Registration") ?>" onclick="
                $('#registration_process').show();
                $.post('/user/registration', $('#registration-form').serialize(),
                function(data)
                {
                    $('#item-tabs_tab_1').html(data);
                });
                return false;
            ">

    	</div>
        <img src="<?=LOAD_ICO?>" style="display: none;" id="registration_process">

    <?php $this->endWidget(); ?>
</div><!-- form -->