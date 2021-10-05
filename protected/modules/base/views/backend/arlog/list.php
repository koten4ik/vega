<?php
/** @var $this Controller */
/** @var $form ActiveForm */

$this->widget('AdminCP', array(
    'item_name'=>'arlog-item',
    'mod_title'=>$this->title,
    //'buttons'=>array('create','delete')
));
echo $this->renderPartial($this->viewDir.'_grid', array('model'=>$model));
?>