<?php

$this->widget('AdminCP', array(
    'item_name'=>'content-item',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Новый элемент',
    'buttons'=>array('save','close','save_close')
));
?>


<script>$("#mod_act_title").html("Новый материал")</script>

<?php echo $this->renderPartial($this->viewDir.'_form', array('model'=>$model)); ?>