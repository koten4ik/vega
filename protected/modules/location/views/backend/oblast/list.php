<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationOblast */

$this->widget('AdminCP', array(
    'item_name'=>'location-oblast',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial($this->viewDir.'_grid', array('model'=>$model)); ?>