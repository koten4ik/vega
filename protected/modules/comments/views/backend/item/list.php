<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model Comments */

$this->widget('AdminCP', array(
    'item_name'=>'comments',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>