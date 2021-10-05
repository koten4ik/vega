(function ($) {
    $.fn.vegaUploader = function (o)
    {
        var settings = $.extend({
            url: '/ajax/fileupload',
            field_name: 'file',
            allowed_files: [],
            start: function(){},
            success: function(){}
        }, o || {});

        var iid = Math.floor(Math.random() * 99999);
        var send_form = $('<form></form>').
            attr('action', settings['url']).
            attr('method', 'post').
            attr('target', 'iframe__'+iid).
            attr('id', 'form__' + iid).
            attr('enctype', 'multipart/form-data');

        var iframe = $('<iframe></iframe>').
            attr('id', 'iframe__'+iid).
            attr('name', 'iframe__'+iid).
            load(function()
            {
                raw = $(this).contents().find('body').text();
                if(raw)
                {
                    settings['success']($.parseJSON(raw));
                    $(settings['upl_butt']).append(input);
                    send_form.remove();
                    iframe.remove();
                }
            }).hide();

        var input = $(settings['upload_file']);
        input.one('change',function()
        {
            ext = $(this).val().split('.');
            ext = ext[ext.length-1].toLowerCase();
            if (settings['allowed_files']=='' || $.inArray(ext,settings['allowed_files']) != -1)
            {
                settings['start']();
                send_form.append(input);
                send_form.submit();
            }
            else{ $(settings['error_text']).html('Разрешены только '+settings['allowed_files'].join(', '))}
        });

        $(settings['upl_butt']).append(iframe);
        $(settings['upl_butt']).append(send_form);
    };
})(jQuery);

