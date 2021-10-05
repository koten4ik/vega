//const SHIFT = 16;
const KEY_T = 84;
$(window).keydown(function(event){ if(event.keyCode == KEY_T) { translate_on();  } });
$(window).keyup(function(event){ if(event.keyCode == KEY_T) { translate_off(); } });
var tr_click = false;

function translate_on()
{
    tr_click = true;
    $(".lang_span").addClass("lang_span_class");
    $(".lang_span").off('click');
    $(".lang_span").click(function()
    {
        translate_off();
        //var url = "/"+BACKEND_NAME+"/base/translate/find?text=" + $(this).html();
        var url = "/"+BACKEND_NAME+"/base/translate/find?text=" + $(this).attr('data');
        var parent = $(this).parent();
        if(parent.is('a')) parent.click(function(){
            if(tr_click){ tr_click = false; return false; } else return true;
        });
        window.open(url,"_blank")
    })
}
function translate_off()
{
    $(".lang_span").off('click');
    $(".lang_span").removeClass("lang_span_class");
}