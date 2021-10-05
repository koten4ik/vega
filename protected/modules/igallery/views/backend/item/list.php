<?php
/** @var $this Controller */
/** @var $form ActiveForm */


$this->widget('AdminCP', array(
    'item_name'=>'igallery-item',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));

echo $this->renderPartial($this->viewDir.'_grid', array('model'=>$model));

$this->widget('FilterCategoryGreed',array( 'model'=>$model, 'field'=>'cat_id', 'catModel'=>'IgalleryCategory' ));
?>


