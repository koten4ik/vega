
var timeout_id;
function showModMsg(msg) {
    if (msg == null) {
        clearTimeout(timeout_id);
        if (!$("#mod_message").is(":hidden"))
            $("#mod_message").animate({ width:"toggle" });
    }
    else
        $("#mod_message")
            .html(msg)
            .animate({ width:"toggle"}, function () {
                timeout_id = setTimeout(
                    function () {
                        $("#mod_message").animate({ width:"toggle"});
                    },
                    5000
                );
            });
}

// ==========================  ajax CP code ===============================
function ajax_open(url,model_alias)
{
    $('#'+model_alias+'-data').empty();
    $('#'+model_alias+'-data').load(url,function(textStatus,responseText){
        if(responseText=='error') $('#'+model_alias+'-data').html(textStatus);
        $('#'+model_alias+'-dialog').dialog('open');
    })

    return false;
}
function ajax_save(url,data,model_alias,callback)
{
    //$('#'+model_name+'-data').empty();
    $.post( url, data,
        function(data) {
            $('#'+model_alias+'-data').html(data);
            if(callback) callback();
    });
    return false;
}
function ajax_close(model_alias)
{
    $.fn.yiiGridView.update(model_alias+'-grid');
    $('#'+model_alias+'-dialog').dialog('close');
    return false;
}
/*non_cp_ajax=0
function clear_grid_events(){
    $('#ajax_content .grid-view').each(function(){
        //alert( $(this).attr('id') );
        //$("#"+$(this).attr('id')+" a.delete").remove();
        //$("#"+$(this).attr('id')+" a.add").die()
    })
}
function ajax_load(a,id)
{
    if(non_cp_ajax) return true;
    clear_grid_events();
    $('#main_content').hide();
    $('#ajax_content').show();
    $('#ajax_content').html('');
    $('#ajax_content').load(a.href,function(textStatus,responseText){
        //alert(responseText);
        if(responseText=='error') $('#ajax_content').html(textStatus);
    })
    //history.pushState(null, null, a.href);
    if(id) location.hash = 'update/'+id;
    return false;
}
function ajax_save(url,data,callback)
{
    clear_grid_events();
    $('#ajax_content').empty();
    //$('#act_loading').show();
    $.post( url, data,
        function(data) {
            $('#ajax_content').html(data);
            if(callback) callback();
        }
    );
    return false;
}
function ajax_close(grid_name)
{
    $.fn.yiiGridView.update(grid_name);
    $('#ajax_content').hide();$('#main_content').show(); // duble from hashchange for ie8
    //history.pushState(null, null, this.href);
    location.hash = '';
    return false;
}
$(document).ready(function()
{
    if(location.hash.split('/')[0]=='#update')
    {
        item_id=location.hash.split('/')[1];
        //ajax_load({href:'update?id='+item_id},item_id)
    }
});
$(window).bind('hashchange', function()
{
      if(location.hash=='') {
          $('#ajax_content').hide();$('#main_content').show();
      }
});*/
// ==========================  ajax CP code ===============================
