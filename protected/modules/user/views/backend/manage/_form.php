<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype'=>'multipart/form-data'),
)); ?>

    <div class="fl" style="width: 50%">
        <div class="row">
            <?php echo $form->labelEx($model,'username', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->textField($model,'username',array('maxlength'=>255, 'style'=>'width:300px','autocomplete'=>"off")); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'password', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->passwordField($model,'password',array('maxlength'=>255, 'style'=>'width:300px')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'email', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->textField($model,'email',array('maxlength'=>255, 'style'=>'width:300px')); ?>
            <?php echo $form->error($model,'email'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'last_name', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->textField($model,'last_name',array('maxlength'=>255, 'style'=>'width:300px')); ?>
            <?php echo $form->error($model,'last_name'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'first_name', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->textField($model,'first_name',array('maxlength'=>255, 'style'=>'width:300px')); ?>
            <?php echo $form->error($model,'first_name'); ?>
        </div>

        <div class="row">
            <?php echo $form->labelEx($model,'role', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->dropDownList($model,'role',User::roleList(),array('style'=>'width:300px')); ?>
            <?php echo $form->error($model,'role'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'status', array('style'=>'display:inline-block; width:85px')); ?>
            <?php echo $form->dropDownList($model,'status',User::statusList(),array('style'=>'width:300px')); ?>
            <?php echo $form->error($model,'status'); ?>
        </div>

    </div>

    <div style="margin-left: 50%; padding-left: 15px">
        <div class="row">
            <? $this->widget('FieldFile',
                array('field'=>'avatar', 'tmb_num'=>1, 'form'=>$form,'model'=>$model))?>
        </div>
        <!--div class="row">
            <?php //echo $form->labelEx($profile,'gender', array('style'=>'display:inline-block; width:85px')); ?>
            <?php //echo $form->textField($profile,'gender',array('maxlength'=>255, 'style'=>'width:300px')); ?>
            <?php //echo $form->error($profile,'gender'); ?>
        </div-->
    </div>

    <div class="fc"></div>
    <? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>
</div><!-- form -->
