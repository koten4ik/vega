
<?php
$arc = (int)($this->id == 'archive');

$grid = $this->widget('GridView', array(
	'id'=>'contact-grid',
	'dataProvider'=>($arc) ? $model->search(1) : $model->search(0),
    //'ajaxUrl'=>Y::app()->request->url,
	'filter'=>$model,
    'saveState'=>true,
	'columns'=>array(
        array(
            'class'=>'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array( 'value' => '$data->id', ),
            'id'=>'check_tr',
            'htmlOptions'=>array('class'=>'check_td'),
   		),
        array(
   			'name' => 'subject',
   			'type'=>'raw',
   			'value' => 'CHtml::link(CHtml::encode($data->subject), array("view","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'subject_tr',
            'htmlOptions'=>array('class'=>'subject_td'),
   		),

        array(
            'name' => 'cdate',
            'value' => 'date("d.m.Y - H:i:s",$data->cdate)',
            'htmlOptions' => array('style' => 'width:120px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'cdate','dd.mm.yy')
      	),
        array(
   			'name' => 'name',
   			'type'=>'raw',
   			'value' => 'CHtml::encode($data->name)',
            'id'=>'name_tr',
            'htmlOptions'=>array('class'=>'name_td'),
   		),
        array(
   			'name'=>'email',
   			'type'=>'raw',
   			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
            'id'=>'email_tr',
            'htmlOptions'=>array('class'=>'email_td'),
   		),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));

?>