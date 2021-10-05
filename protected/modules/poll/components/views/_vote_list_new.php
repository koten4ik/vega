
<form action="?" class="question">
    <ul class="question-radio-list">
        <?foreach ($elems as $elem){?>
            <li>
                <label class="radio-label question-radio-label">
                    <input type="radio" class="radio" value="<?=$elem->id?>" name="poll" required>
                    <span><?=$elem->title?></span>
                </label>
            </li>
        <?}?>
    </ul>
    <button type="submit" class="btn btn-block submit" onclick="
        vote = $('input[name=\'poll\']:checked').val();
        if(vote > 0){
            //$('#poll_widget_loading').show();
            $.post('/poll/item/vote?poll=<?=$this->poll->id;?>&vote='+vote,  function(data){
            $('#poll_widget_<?=$this->poll->id?>').html(data)
            $.cookie('poll_<?=$this->poll->id;?>',1, {'path':'/','expires':300});
            });
        }else alert('Выберите пункт');
        return false;
    ">Голосовать!</button>
</form>
