<?php
/** @var $this Controller */
/** @var $form ActiveForm */


$this->widget('AdminCP', array(
    'item_name'=>'catalog-manufacturer',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<?
echo $this->renderPartial('_grid', array('model'=>$model));
?>

