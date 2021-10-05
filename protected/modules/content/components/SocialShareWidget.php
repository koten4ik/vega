<?php

Yii::import('zii.widgets.CPortlet');

class SocialShareWidget extends CWidget
{

    public function run()
    {
        $url = Yii::app()->createAbsoluteUrl(Yii::app()->request->url);
        //$url = 'http://yandex.ru'
        ?>
    <div class="socialShare">

        <? $fb_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $url;?>
        <a class="fb" onclick="wnd_popup('<?=$fb_url?>',800,350); return false;" href="#">
            <img src="/assets_static/images/front/fb_ico.jpg" alt="">share
        </a>

        <? $tw_url = 'http://twitter.com/share?url=' . $url;?>
        <a class="tw" onclick="wnd_popup('<?=$tw_url?>',800,450); return false;" href="#">
            <img src="/assets_static/images/front/tw_ico.jpg" alt="">tweet
        </a>

        <? $vk_url = 'http://vkontakte.ru/share.php?url=' . $url;?>
        <a class="vk" onclick="wnd_popup('<?=$vk_url?>',800,550); return false;" href="#">
            <img src="/assets_static/images/front/vk_ico.png" alt="">поделиться
        </a>

        <a class="fb" href="#" style="cursor: default; padding-top: 2px; height: 28px; vertical-align: 3px;">
            <div style="margin-top: 0px;">
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/en_EN/sdk.js#xfbml=1&version=v2.0";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
            <div class="fb-like" data-href="<?=$url?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
            </div>
        </a>

    </div>


    <script type="text/javascript">
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
            atr = atr + ' left=' + String((screen.width - w) / 2) + ', top=' + String((screen.height - h) / 2);
            new_window = window.open(url, '_blank', atr);
            new_window.focus();
        }
        /*Share = {
            vkontakte:function (purl, ptitle, pimg, text) {
                url = 'http://vkontakte.ru/share.php?';
                url += 'url=' + encodeURIComponent(purl);
                url += '&title=' + encodeURIComponent(ptitle);
                url += '&description=' + encodeURIComponent(text);
                url += '&image=' + encodeURIComponent(pimg);
                url += '&noparse=true';
                Share.popup(url);
            },
            odnoklassniki:function (purl, text) {
                url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1';
                url += '&st.comments=' + encodeURIComponent(text);
                url += '&st._surl=' + encodeURIComponent(purl);
                Share.popup(url);
            },
            facebook:function (purl, ptitle, pimg, text) {
                url = 'http://www.facebook.com/sharer.php?s=100';
                url += '&p[title]=' + encodeURIComponent(ptitle);
                url += '&p[summary]=' + encodeURIComponent(text);
                url += '&p[url]=' + encodeURIComponent(purl);
                url += '&p[images][0]=' + encodeURIComponent(pimg);
                Share.popup(url);
            },
            twitter:function (purl, ptitle) {
                url = 'http://twitter.com/share?';
                url += 'text=' + encodeURIComponent(ptitle);
                url += '&url=' + encodeURIComponent(purl);
                url += '&counturl=' + encodeURIComponent(purl);
                Share.popup(url);
            },
            mailru:function (purl, ptitle, pimg, text) {
                url = 'http://connect.mail.ru/share?';
                url += 'url=' + encodeURIComponent(purl);
                url += '&title=' + encodeURIComponent(ptitle);
                url += '&description=' + encodeURIComponent(text);
                url += '&imageurl=' + encodeURIComponent(pimg);
                Share.popup(url)
            },

            popup:function (url) {
                window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
            }
        };*/
    </script>
    <?
    }
}
