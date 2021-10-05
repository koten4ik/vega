<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BaseSourceMessage */

$this->widget('AdminCP', array(
    'item_name'=>'base-source-message',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Новый элемент',
    'buttons'=>array('save','close','save_close')
));
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>