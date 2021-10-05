
$(function(){
    /*if ($.browser.opera) $("body").addClass("opera");
    if ($.browser.mozilla) $("body").addClass("mozilla");
    if ($.browser.webkit) $("body").addClass("webkit");
    if ($.browser.msie) $("body").addClass("msie");*/

    // simple dialog code
    jQuery(document).click( function(event){
    	if( $(event.target).closest(".simpleDialog").length ) return;
        if( $(event.target).closest(".dynatree-expander").length ) return; //fix for dynatree strucutre
        if( $(event.target).closest(".dynatree-title").length ) return; //fix for dynatree strucutre
    	jQuery(".simpleDialog").fadeOut();
    	event.stopPropagation();
    });
    jQuery('.simpleDialogButton').click(
    function(event) {
        jQuery(".simpleDialog").fadeOut();
        jQuery('#'+$(event.target).attr('sdtarget_id')).slideDown(90);
        return false;
    });

    // vega dialog code
    $(document).mouseup(function (e) {
        var div = $(".vega_dialog");
        if (div.is(e.target)
            && div.has(e.target).length === 0) {
            div.hide();
        }
        $(".vega_dialog .vega_dialog_close").click(function(){
            $(this).parent().parent().parent().hide();
        });
    });

    /* ============= open in new window */
    function setOnclick(a) {
    a.setAttribute("onclick",
        "popupWin = window.open(this.href,'contacts','location,width=1000px,height=800px,top="+(100)+",left="+((screen.width-1000)/2)+"'); popupWin.focus(); return false")
    }
    function externalLinks() {
    var links = document.getElementsByTagName("a");
      for (i=0; i<links.length; i++) {
        if (links[i].getAttribute("href") && links[i].getAttribute("rel") == "external") {
          setOnclick(links[i])
        }
      }
    }
    window.onload = externalLinks;
});

function vega_dialog_open(id){
    $('#'+id).attr('style','display: flex;');
    $('#'+id+' .vega_dialog_content').css('maxHeight',($(window).height()-150) );
}

function JSTimeXX(i){ if(i < 10) i="0" + i;  return i; }

jQuery.fn.center = function () {
    this.css("position","absolute");
    this.css("top",  (($(window).height() ) / 2 - this.outerHeight()/2 ) + $(window).scrollTop()  + "px");
    this.css("left", (($(window).width()  ) / 2 - this.outerWidth()/2  ) + $(window).scrollLeft() + "px");
    return this;
}

function LoadVideoPlayer(file, width, height, id){
	var flashvars = {"m":"video","comment":"","file":file,"st":"/assets_static/extentions/uppod-flv/skin.txt"};
	var params = {bgcolor:"#000000", wmode:"transparent", allowFullScreen:"true", allowScriptAccess:"always",id:id};
	new swfobject.embedSWF(
           "/assets_static/extentions/uppod-flv/uppod-video.swf",
           id, width, height, "9.0.115", false, flashvars, params
    );
}

function SetLang(lang,all){
    // по кукам
    $.cookie('site_lang', lang, {path: '/'} );
    location.reload();
    /*
    // по урлу, в all передавать все языки
    new_url = ''; url = location.href;
    for(i=0;i<all.length;i++) url = url.replace("/"+all[i]+"/","/");
    url = url.split('/');
    for(i=0;i<url.length;i++){  if(i==3) new_url += lang+'/';
        if(url[i] == '' && i == url.length-1) continue;    new_url += url[i]+'/';  }
    location.href = new_url;
    */
    return false;
}

$(document).on('click', '.ui-widget-overlay', function(){
    $('.ui-dialog:visible:last .ui-dialog-content').dialog('close');
});

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function ckeCreate(id) {
    ClassicEditor.create(document.querySelector('#'+id), {
        ckfinder: { uploadUrl: '/service/ckeUpload', }, mediaEmbed:{previewsInData:true},
        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
    }).then(editor => {  window.editor = editor; }).catch(err => {  console.error(err.stack); });
}

/* helper block */
(function($){
$(function() {

    $('div.helper_p_block').each(function() {
        var el = $(this);
        var title = el.attr('title');
        if (title && title != '') {
            el.attr('title', '').append('<div class=""><span class="lang_span">' + title + '</span></div>');
            var width = el.find('div').width();
            var height = el.find('div').height();
            el.hover(
                function() {
                    width = el.find('div').width();
                    height = el.find('div').height();
                    el.find('div')
                        .clearQueue()
                        .delay(100)
                        .show('fade',200);
                },
                function() {
                    el.find('div')
                        //.hide('fade',1000);
                        .hide();
                }
            ).mouseleave(function() {
                if (el.children().is(':hidden')) el.find('div').clearQueue();
            });
        }
    })

})
})(jQuery)