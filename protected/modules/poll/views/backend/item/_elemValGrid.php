<br>
<div class="row" style="">
    <label style="display: inline-block; width:80px;">Значения:</label>
    <input id="elem_val" style="width: 400px;"/>
    <a href="#" onclick="
        $.post('<? echo $this->createUrl('/poll/item/addElem', array('poll_id' => $poll_id)) ?>'+'&val='+$('#elem_val').val(),
        function(data){$.fn.yiiGridView.update('poll-element-grid'); $('#elem_val').val('')})
        ">добавить</a>
</div>
<br>
<?
$this->widget('GridView', array(
    'id' => 'poll-element-grid',
    'dataProvider' => PollElement::model()->search($poll_id),
    'hideHeader' => false,
    'selectableRows' => false,
    'htmlOptions' => array('style' => 'margin-top:-15px;'),
    'columns' => array(
        array(
            'name' => 'title',
            'value' => function($data)
            {
                echo CHtml::textField('title', $data->title, array(
                    'style' => 'width:400px; padding:3px 5px;', 'id'=>'title_'.$data->id, 'onchange' => '
                        $.post("setTitle?item_id=' . $data->id . '&title="+$(this).val(), function(data){
                            if(data==1){ $("#title_' . $data->id . '").css("backgroundColor","#e6efc2"); }
                            else{ $("#title_' . $data->id . '").css("backgroundColor","#ea9999"); }
                        });
                    '));
            },
            'htmlOptions' => array('style' => 'width:40px;'),
        ),
        array(
            'name' => 'position',
            'value' => function($data)
            {
                echo CHtml::textField('position', $data->position, array(
                    'style' => 'width:40px;', 'id'=>'position_'.$data->id, 'onchange' => '
                        $.post("setPosition?item=' . $data->id . '&position="+$(this).val(), function(data){
                            if(data==1){ $("#position_' . $data->id . '").css("backgroundColor","#e6efc2"); }
                            else{ $("#position_' . $data->id . '").css("backgroundColor","#ea9999"); }
                        });
                    '));
            },
            'htmlOptions' => array('style' => 'width:40px;'),
        ),
        array('class' => 'CButtonColumn',
            'buttons' => array(
                'delele' => array(
                    'label' => 'удалить',
                    //'imageUrl'=>'/assets_static/images/back/delete.png',
                    'url' => '$data->id',
                    'click' => 'function(){
                          if(confirm("подтверждение удаленеия"))
                              $.post("deleteElem?id="+$(this).attr("href"), function(data){
                                  $.fn.yiiGridView.update("poll-element-grid");
                              });
                          return false;
                      }',
                ),
            ),
            'template' => '{delele}'
        ),
    ),
));
echo '<div class="fc"></div>';
