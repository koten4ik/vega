<?php


$this->widget('AdminCP', array(
    'item_name'=>'catalog-order',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Изменение элемента № '.$model->id,
    'buttons'=>array('save','close','save_close')
));
?>


<?php echo $this->renderPartial('_form', array('model'=>$model, 'positions'=>$positions)); ?>