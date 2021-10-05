<?php
/** @var $this Controller */
/** @var $form ActiveForm */

$this->widget('AdminCP', array(
    'item_name'=>'banner',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<?
echo $this->renderPartial('_grid', array('model'=>$model));

//$this->widget('FilterCategory',array( 'model'=>$model, 'field'=>'cat_id', 'catModel'=>'CatalogCategory' ));
?>

