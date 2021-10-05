<?php $this->beginContent('//layouts/site_wrap'); ?>

<div id="left_coll" class="fl">

    <? $this->widget('CartWidget', array('id'=>'cart_widget')) ?>
    <? $this->widget('CartDialogWidget', array('id'=>'cart_dialog')) ?>

    <? $this->widget('CatalogWidget', array('id' => 'catalog')) ?>
    <? $this->widget('CatalogFilterWidget', array('id' => 'catalog_filter')) ?>
    <? //$this->widget('ArticleListWidget', array('id'=>'art_list', 'maxItems'=>'10')) ?>

</div>


<div id="right_coll">

    <?php echo $content; ?>

</div>
<div class="fc"></div>

<?php $this->endContent(); ?>