<?
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model BannerPlace */

$this->widget('AdminCP', array(
    'item_name'=>'banner-place',
    'mod_title'=>$this->title,
    'buttons'=>array('create','delete')
));
?>

<? echo $this->renderPartial('_grid', array('model'=>$model)); ?>