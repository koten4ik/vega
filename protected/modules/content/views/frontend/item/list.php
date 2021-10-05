<?php
/** @var $this Controller */
/** @var $form ActiveForm */


?>


<h1 id="page_title"><span><?= $cat ? $cat->title : 'Материалы'?></span></h1>

<div id="page_content">
    <?
    $this->widget('ListViewFront', array(
            'id' => 'article-item-list',
            'separator'=>'<div class="separator"></div>',
            'dataProvider' => $model->search_front(),
            'itemView' => '_view',
        )
    );
    ?>
</div>