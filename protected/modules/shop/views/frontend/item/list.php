<?php
/** @var $this Controller */
/** @var $form ActiveForm */


?>

<div id="page_title"><span><? echo $title; ?></span></div>

<div id="page_content">
    <? if(strlen($category->descr) > 1) {?>
        <div id="category_descr">
            <? echo $category->descr; ?>
        </div>
    <? } ?>
    <? echo $this->renderPartial('_list', array('model'=>$model, 'category'=>$category));  ?>
</div>
