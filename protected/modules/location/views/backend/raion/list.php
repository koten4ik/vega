<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationRaion */

$this->widget('AdminCP', array(
    'item_name'=>'location-raion',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial($this->viewDir.'_grid', array('model'=>$model)); ?>