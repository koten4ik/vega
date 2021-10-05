<?php

$this->widget('AdminCP', array(
    'item_name'=>'config',
    'mod_title'=>$this->title,
    'mod_act_title'=>'',
    'buttons'=>array('close'),

));
?>

<script>$("#mod_act_title").html("Сообщение №<?php echo $model->id; ?>")</script>
<br>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'cssFile'=>false,
	'attributes'=>array(
		//'id',
        array(
            'name' => 'cdate',
            'value' => date("d.m.Y - H:i:s",$model->cdate),
        ),
		'name',
		'email',
		'subject',
        array('name'=>'message', 'cssClass'=>'view_message'),
		//'archived',
		//'ip',
	),
)); ?>
