<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
$sys_view = User::isAdmin() || YII_DEBUG;
$page = ContentPage::getByAlias('e404');
?>

<div id="page_title">
    <span>
    <?if($sys_view){?>
        Error <?php echo $code; ?>
    <?}else{?>
        <?=$page->title?>
    <?}?>
    </span>
</div>

<div id="page_content" class="error" >

    <?if($sys_view){?>
        <?php echo CHtml::encode($message); ?>
    <?}else{?>
        <?=$page->text?>
    <?}?>
</div>