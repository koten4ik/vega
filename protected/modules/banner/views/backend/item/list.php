<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model Banner */

$this->widget('AdminCP', array(
    'item_name'=>'banner',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>


