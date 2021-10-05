
$(document).ready(function() {


    $(document).scroll(function () {
        if ($(document).scrollTop() >= 1200) {
            $('.to_top_butt').show(300)
        } else {
            $('.to_top_butt').hide(300)
        }
    });
    $('.to_top_butt').click(function () {
        $('html, body').animate({scrollTop: 0},500);
    })

    // content auto-height
 /*   var sub = ( $('#page_content').position().top + $('#page_content').height() ) -
              ( $('#left_coll').position().top + $('#left_coll').height() );
    if( sub < 0 ) $('#page_content').css('min-height',$('#page_content').height()- sub - 45);
    //window.console.log(  sub );
*/
});

function js_input_filled_check(checked_class, ch_butt_class)
{
    js_input_filled_check_proc(checked_class, ch_butt_class)
    $(checked_class).keyup(function(){
        js_input_filled_check_proc(checked_class, ch_butt_class)
    });
}
function js_input_filled_check_proc(checked_class, ch_butt_class){
    //alert(1)
    var all_filled = true;
    $(checked_class).each(function(){ if($(this).val()=='') all_filled=false; });
    if(all_filled=='') $(ch_butt_class).addClass('disabled');
    else $(ch_butt_class).removeClass('disabled');
}

function add_favorite(a) {
    title = document.title;
    url = document.location;
    try {
        // Internet Explorer
        window.external.AddFavorite(url, title);
    }
    catch (e) {
        try {
            // Mozilla
            window.sidebar.addPanel(title, url, "");
        }
        catch (e) {
            // Opera
            if (typeof(opera) == "object") {
                a.rel = "sidebar";
                a.title = title;
                a.url = url;
                a.href = url;
                return true;
            }
            else {
                // Unknown
                alert('Нажмите Ctrl + D чтобы добавить страницу в закладки');
            }
        }
    }
    return false;
}

function wnd_popup(url, w, h) {
    atr = 'toolbar=no,';
    if (w) {
        atr = atr + 'width=' + w + ',';
        atr = atr + 'height=' + h + ',';
    }
    else {
        atr = atr + 'width=700,';
        atr = atr + 'height=700,';
    }
    /*atr = atr + ' left=' + String((screen.width - w) / 2) + ', top=' + String((screen.height - h) / 2);*/
    new_window = window.open(url, '_blank', atr);
    new_window.focus();
}