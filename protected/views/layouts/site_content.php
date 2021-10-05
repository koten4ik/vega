<?php $this->beginContent('//layouts/site_wrap'); ?>

<div id="left_coll" class="fl">

    <? $this->widget('ContentListPortlet', array('id'=>'art_list', 'maxItems'=>'10')) ?>

</div>


<div id="right_coll">

    <?php echo $content; ?>

</div>
<div class="fc"></div>

<?php $this->endContent(); ?>