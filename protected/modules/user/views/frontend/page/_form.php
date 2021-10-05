<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model User */

$this->registerScript("
    /*$('.elrte').elrte(".Y::elrteOpts(array('height'=>200)).");*/
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END );
?>

<div class="form pad">
<?php $form=$this->beginWidget('ActiveForm', array('id'=>'user-edit-form')); ?>


    <?=Html::divColumnOpen(230)?>

        <?= $form->fileFieldW($model,'avatar',array( 'tmb'=>2, 'img_w'=>200)); ?>
    <?=Html::divColumnNext(230)?>

        <?= $form->textFieldW($model,'last_name',array( 'l_w'=>300, 'f_w'=>'96%;', 'inl'=>0, 'ml_lng'=>0 )); ?>
        <?= $form->textFieldW($model,'first_name',array( 'l_w'=>300, 'f_w'=>'96%;', 'inl'=>0, 'ml_lng'=>0 )); ?>
        <?= $form->textFieldW($model,'second_name',array( 'l_w'=>300, 'f_w'=>'96%;', 'inl'=>0, 'ml_lng'=>0 )); ?>

        <br>
        <? $this->widget('LocationMultiWidget', array('id'=>'location_model','model_name'=>$this->modelName,
                'fields'=>array( 'country_id'=>$model->country_id, 'oblast_id'=>$model->oblast_id,
                    'raion_id'=>$model->raion_id, 'city_id'=>$model->city_id
        )));?>
        <? //$this->widget('LocationAutoWidget', array('form'=>$form, 'model'=>$model, 'field'=>'city_id',
            //    'text'=>$model->city->title, 'f_w'=>300 ));?>

        <?= $form->textFieldW($model,'phone',array( 'l_w'=>300, 'f_w'=>'96%;', 'inl'=>0, 'ml_lng'=>0 )); ?>

        <br><br>
        <button class="button" style="padding: 2px 50px; margin-left: 0px;"><?=Y::t('Сохранить')?></button>


    <?=Html::divColumnClose()?>

<?php $this->endWidget(); ?>
</div><!-- form -->
