<?php
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('user',"Login");
$this->breadcrumbs=array(
	Yii::t('user',"Login"),
);
?>

<div style="padding-top: 100px; " align="center">

    <fieldset style="border: 1px solid; padding: 20px; padding-left: 40px; width: 460px; border-radius: 6px 6px 6px 6px;"; >
        <legend><h2  style="vertical-align: 0px"><?php echo 'Вход в административный раздел' ?></h2></legend>
        <div align="left" >

            <?php if(Yii::app()->user->hasFlash('loginMessage')): ?>
                <div class="success">
                    <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
                </div>
            <?php endif; ?>

            <p><?php echo Yii::t('user',"Please fill out the following form with your login credentials:"); ?></p>

            <br>
            <!--span style="font-size: 130%;">Для демонстрации используйте логин/пароль - demo/demo</span-->

            <div class="form" >
            <?php $form=$this->beginWidget('ActiveForm', array(
                'id'=>'login-form',
            )); ?>

                <div class="fl" style="width: 250px;">
                    <div class="row">
                        <?php echo $form->labelEx($model,'username', array('style'=>'')); ?>
                        <?php echo $form->textField($model,'username',array('style'=>'width:250px;')); ?>
                        <?php echo $form->error($model,'username',array('style'=>'font-size:80%;')); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model,'password', array('style'=>'')); ?>
                        <?php echo $form->passwordField($model,'password',array('style'=>'width:250px;')); ?>
                        <?php echo $form->error($model,'password',array('style'=>'font-size:80%;')); ?>
                    </div>
    
                    <div class="row rememberMe">
                           <?php echo $form->checkBox($model,'rememberMe'); ?>
                           <?php echo $form->labelEx($model,'rememberMe', array('class'=>'after_cbox')); ?>
                   	</div>

                    <div class="row submit">
                        <?php echo CHtml::submitButton(Yii::t('user',"Login"),array('id'=>'enter')); ?>
                    </div>
                </div>
                <div class="fl" style="padding: 20px; margin-left: 30px;">
                    <img src="/assets_static/images/back/lock_ico.png" />
                </div>
                <div class="fc"></div>
                
            <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </fieldset>

</div>
    <script type="text/javascript">$('#enter').focus()</script>

<?php
$form = new CForm(array(
    'elements'=>array(
        'username'=>array(
            'type'=>'text',
            'maxlength'=>32,
        ),
        'password'=>array(
            'type'=>'password',
            'maxlength'=>32,
        ),
        'rememberMe'=>array(
            'type'=>'checkbox',
        )
    ),

    'buttons'=>array(
        'login'=>array(
            'type'=>'submit',
            'label'=>'Login',
        ),
    ),
), $model);
?>