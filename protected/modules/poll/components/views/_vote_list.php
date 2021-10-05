<?php

foreach ($elems as $elem){?>

<div class="poll-element list" data="<?=$elem->id?>" onclick="
    $('#poll-widget-loading').show();
    $.post('/poll/item/vote?poll=<?=$this->poll->id;?>&vote='+$(this).attr('data'),  function(data){
        $('#poll_widget_<?=$this->poll->id?> .data').html(data)
        $.cookie('poll_<?=$this->poll->id;?>',1, {'path':'/','expires':300});
    });
">
    <div class="poll-elem-title"><?=$elem->title?></div>
</div>

<?}?>

<div class="poll-stats">
    <img id="poll-widget-loading" src="<?=LOAD_ICO?>" style="display: none;">
</div>