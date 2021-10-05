<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model PollItem */

$this->widget('AdminCP', array(
    'item_name'=>'poll-item',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>