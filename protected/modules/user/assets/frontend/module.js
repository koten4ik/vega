
function addContant(id){
    if(confirm('Подтвердите действие')){
        $.post('/user/contacts/add?id='+id,function(){
            $('#contact_butt').hide();
            $('#contact_remove_butt').show();
        })
    }
}

function removeContant(id,callback){
    if(confirm('Подтвердите действие')){
        $.post('/user/contacts/remove?id='+id,function(){
            if(callback) callback();
            else{
                $('#contact_butt').show();
                $('#contact_remove_butt').hide();
            }
        })
    }
}

function sendMsg(group_id,text){
    $.post('/user/message/add?group_id='+group_id+'&text='+text,function(){
        $.fn.yiiListView.update('user-msg-group-list');
        $('#msg_area').val('')
    })
}