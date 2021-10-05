<?php

foreach ($elems as $elem) $arr[$elem->id] = $elem->title;

echo CHtml::radioButtonList('poll', '', $arr, array('style' => 'vertical-align:-2px; margin-bottom:4px;', 'labelOptions' => array('style' => 'color:#000;cursor:pointer;')));
echo '<div style="height: 8px;"></div>';

?><span class="ib button" style="" onclick="
    vote = $('input[name=\'poll\']:checked').val();
    if(vote > 0){
        $('#poll_widget_loading').show();
        $.post('/poll/item/vote?poll=<?=$this->poll->id;?>&vote='+vote,  function(data){
        $('#poll_widget_<?=$this->poll->id?>').html(data)
        $.cookie('poll_<?=$this->poll->id;?>',1, {'path':'/','expires':300});
        });
    }else alert('Выберите пункт');
">
    Голосовать
</span>
<img id="poll_widget_loading" src="<?=LOAD_ICO?>" style="margin-left: 5px; vertical-align: -3px; display: none;">
<?