
<?if($leaf_draw)
    echo '<div id="comment_leaf_'.$model->id.'" class="comment_leaf '.
        ($parent_id==0 ? 'level0':'').'">';?>

<div class="comment_block">

    <span class="comment_user"><?=$model->user->first_name . ' ' . $model->user->last_name?></span>
    <span class="comment_time"><?=Y::date_print($model->create_time, 'd.m - H:i', 1)?></span>

    <div class="commment_text"><?=$model->text?></div>

    <?if( $model->user_id != Y::user_id() && Y::user_id() ){?>
        <a href="#" class="comment_reply_butt"
            onclick="renderCommentForm('<?=$model->id?>'); return false;">ответить</a>
    <?}elseif($model->user_id != Y::user_id()){?>
        <a href="#" class="comment_reply_butt" onclick="$('#login_dialog').dialog('open'); return false;"><?=Y::t('ответить')?></a>
    <?}?>

</div>

<?if($leaf_draw) echo '</div>';?>