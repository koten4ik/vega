<?php
$this->widget('GridView', array(
	'dataProvider'=>$model->search(),
    //'ajaxUrl'=>Y::app()->request->url,
    'id'=>'user-grid',
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
			'name' => 'id',
			//'type'=>'raw',
			'value' => '$data->id',
            'filter'=>'',
            'id'=>'id_tr',
            'htmlOptions'=>array('class'=>'id_td'),
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("manage/update","id"=>$data->id),
			    array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id'=>'username_tr',
            'htmlOptions'=>array('class'=>'username_td'),
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
            'id'=>'email_tr',
            'htmlOptions'=>array('class'=>'email_td'),
		),
		array(
			'name' => 'create_time',
			'value' => 'date("d.m.Y - H:i:s",$data->create_time)',
            'htmlOptions' => array('style' => 'width:120px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'create_time','dd.mm.yy')
		),
		array(
			'name' => 'last_visit_time',
			'value' => '(($data->last_visit_time)?date("d.m.Y - H:i:s",$data->last_visit_time):Yii::t(\'user\',"Not visited"))',
            'htmlOptions' => array('style' => 'width:120px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'last_visit_time','dd.mm.yy')
		),
		array(
            'class' => 'UserStatusColumn',
			'name'=>'status',
			'filter'=>User::statusList(),
            'id'=>'status_tr',
            'htmlOptions'=>array('class'=>'status_td'),
		),
		array(
			'name'=>'role',
			'value'=>'$data->roleName()',
			'filter'=>User::roleList(),
            'id'=>'role_tr',
            'htmlOptions'=>array('class'=>'role_td'),
		),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}'
		),
	),
));