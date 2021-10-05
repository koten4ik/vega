<?php

$list = new CList();


$this->widget('AdminCP', array(
    'item_name'=>'content-page',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Изменение элемента № '.$model->id,
    'buttons'=>array('save','close','save_close')
));
?>

<?php echo $this->renderPartial($this->viewDir.'_form', array('model'=>$model)); ?>