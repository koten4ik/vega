<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model VideoItem */

$this->widget('AdminCP', array(
    'item_name'=>'video-item',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial($this->viewDir.'_grid', array('model'=>$model)); ?>