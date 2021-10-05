<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationCity */

$this->widget('AdminCP', array(
    'item_name'=>'location-city',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Изменение элемента № '.$model->id,
    'buttons'=>array('save','close','save_close')
));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>