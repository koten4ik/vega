<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model VideoItem */

$this->widget('AdminCP', array(
    'item_name'=>'video-item',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Изменение элемента № '.$model->id,
    'buttons'=>array('save','close','save_close')
));
?>

<?php echo $this->renderPartial($this->viewDir.'_form', array('model'=>$model)); ?>