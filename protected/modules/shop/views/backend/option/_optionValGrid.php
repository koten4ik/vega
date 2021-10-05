Значения:
<input id="option_val"/>
<a href="#" onclick="
        $.post('<? echo $this->createUrl('/shop/option/addVal', array('option_id'=>$model->id)) ?>'+'&val='+$('#option_val').val(),
            function(data){$.fn.yiiGridView.update('catalog-optionVal-grid<?=$model->id?>'); $('#option_val').val(''); $('#option_val').focus();}
        );
        return false;
    ">добавить</a>
<br>



<? $this->widget('GridView', array(
    'id'=>'catalog-optionVal-grid'.$model->id,
    'dataProvider'=>CatalogOptionVal::model()->search($model->id),
    'hideHeader'=>false,
    'selectableRows'=>false,
    'summaryText'=>'&nbsp',
    'ajaxUpdate'=>true,
    //'filter'=>$model,
    'columns'=>array(
        array(
            'name' => 'value',
            'type'=>'raw',
            'value' => '$data->value',
            'id'=>'value_tr',
            'htmlOptions'=>array('class'=>'value_td'),
        ),
        array(
            'name' => 'position',
            'value' => function($data){
                echo CHtml::textField('position',$data->position, array('style'=>'width:40px;', 'onchange'=>'
                    $.post("setPosition?item='.$data->id.'&position="+$(this).val(), function(data){
                        if(data==1){
                            $(\'#optVal_y'.$data->id.'\').show();
                            $(\'#optVal_n'.$data->id.'\').hide();
                        }
                        else{ $(\'#optVal_y'.$data->id.'\').hide();
                              $(\'#optVal_n'.$data->id.'\').show(); }
                    });
                '));
                echo CHtml::image('/assets_static/images/back/publish_y.png','',
                        array('id'=>'optVal_y'.$data->id, 'style'=>'display:none; width:12px;'));
                echo CHtml::image('/assets_static/images/back/publish_n.png','',
                        array('id'=>'optVal_n'.$data->id, 'style'=>'display:none; width:12px;'));
            },
            'htmlOptions'=>array('style'=>'width:60px;'),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                'delete' => array(
                        'url' => 'Yii::app()->createUrl("/shop/option/removeVal", array("id"=>$data->id))',
                ),
            )
        ),
    ),
));?>