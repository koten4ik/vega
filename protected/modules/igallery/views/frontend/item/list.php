<?php
/** @var $this Controller */
/** @var $form ActiveForm */
?>

<h1 id="page_title"><span>Альбомы</span></h1>

<div id="page_content">
     <? $this->widget('ListViewFront', array(
        'id'=>'gallery-item-list',
        'itemView'=>'_view',
        'dataProvider'=>$model->front_search(),
     )); ?>
</div>