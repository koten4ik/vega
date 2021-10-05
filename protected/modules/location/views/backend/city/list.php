<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationCity */

$this->widget('AdminCP', array(
    'item_name'=>'location-city',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>