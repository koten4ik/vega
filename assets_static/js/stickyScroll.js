(function ($) {
    $.fn.stickyScroll = function (options)
    {
        var o = $.extend({
            margin_top: 0,
            decor_class:''
        }, options || {});

        var blok = $(o['mark']);

        var blok_min_width = blok.css('min-width');
        var blok_z_index = blok.css('z-index');

        var borderY = blok.offset().top - o['margin_top'];
        $(window).bind('scroll', function ()
        {

            var currentY = $(document).scrollTop();
            if (currentY > borderY)
            {
                blok.addClass(o['decor_class']);
                blok.css('min-width',blok.width());
                blok.css('z-index',9000);

                blok.css({position:'fixed', top:o['margin_top'] + 'px'});
            }
            else if (currentY < borderY)
            {
                blok.removeClass(o['decor_class']);
                blok.css('min-width',blok_min_width);
                blok.css('z-index',blok_z_index);

                blok.css({position:'', top:''});
            }
        });
    };
})(jQuery);

