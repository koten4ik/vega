<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model ContentTag */

$this->widget('AdminCP', array(
    'item_name'=>'content-tag',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>