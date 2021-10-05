<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model LocationCountry */

$this->widget('AdminCP', array(
    'item_name'=>'location-country',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial($this->viewDir.'_grid', array('model'=>$model)); ?>