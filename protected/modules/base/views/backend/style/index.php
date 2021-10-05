<?php

$this->widget('AdminCP', array(
    'item_name'=>'style',
    'mod_title'=>$this->title,
    'mod_act_title'=>'',
    'buttons'=>array('save'),
    'non_cp_ajax'=>1
));
?>

<div class="form">

<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data', 'id'=>'style-form')); ?>

    <?php echo CHtml::textArea('style', $data['style'], array('style'=>'width:100%; height:520px;')); ?>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
<div class="fc"></div>
