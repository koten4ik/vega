<?php
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model ContentItem */

?>


<div id="page_title"><span><?=Y::t('Новости')?> <?=Y::t('по тегу')?>: <?=$tag->title?></span></div>

<div id="page_content">
    <?
    $this->widget('ListViewFront', array(
            'id' => 'article-item-list',
            'separator'=>'<div class="separator"></div>',
            'dataProvider' => $model->searchByTag($tag->id),
            'itemView' => '_view',
        )
    );
    ?>
</div>