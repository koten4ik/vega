<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BaseSourceMessage */

$this->widget('AdminCP', array(
    'item_name'=>'base-source-message',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>