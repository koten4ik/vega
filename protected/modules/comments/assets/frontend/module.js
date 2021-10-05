
function sendComment(item_id,model_key)
{
    if(!$('#comments_input').val()){
        alert('Укажите сообщение');
        $('#comments_input').focus();
        return false;
    }
    $('#comment_loading').show();
    $.post('/comments/item/post?item_id='+item_id
        +'&model_key='+model_key+'&text='+$('#comments_input').val(),
        function(data)
        {
            if($('.comment_leaf').length)
                $('.comment_leaf').last().after(data);
            else $('.comments_blocks').after(data);

            $('#comment_loading').hide();
            $('#comments_input').val('');
            $('.comment_cnt').text( ( parseInt($('.comment_cnt').text())+1 ) )
        });
}


function sendSubComment(item_id,model_key)
{
    var parent_id = $('#comment_parent_id').val();
    if(!$('#sub_comments_input').val()){
        alert('Укажите сообщение');
        $('#sub_comments_input').focus();
        return false;
    }
    $('#sub_comment_loading').show();
    $.post('/comments/item/post?item_id='+item_id
        +'&model_key='+model_key+'&text='+$('#sub_comments_input').val()
        +'&parent_id='+parent_id,
        function(data)
        {
            if($('#comment_leaf_'+parent_id+' .comment_leaf').length)
                $('#comment_leaf_'+parent_id+' .comment_leaf').last().after(data);
            else $('#comment_leaf_'+parent_id+' .comment_block').after(data);

            $('#sub_comment_loading').hide();
            $('#sub_comments_input').val('');
            $('#sub_comments_form').hide();
            $('#comments_form').show();
            $('.comment_cnt').text( ( parseInt($('.comment_cnt').text())+1 ) )
        });
}

function renderCommentForm(leaf_id){
    //alert(leaf_id)
    $('#sub_comments_form').appendTo($('#comment_leaf_'+leaf_id));
    $('#sub_comments_form').show();
    $('#comments_form').hide();
    $('#comment_parent_id').val(leaf_id);
    $('#sub_comments_input').focus();
}