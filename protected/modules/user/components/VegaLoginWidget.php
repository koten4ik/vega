<?php

class VegaLoginWidget extends CWidget
{
    public static $w_cnt;

    public function run(){

        $vk_url = 'https://oauth.vk.com/authorize?'.urldecode(http_build_query(UserModule::vkOAuthData()));
        $fb_url = 'https://www.facebook.com/dialog/oauth?'.urldecode(http_build_query(UserModule::fbOAuthData()));
        ?>
        <a href="#<?//=$vk_url?>" onclick="wnd_popup('<?=$vk_url?>',800,550); return false;" >
            <img src="/assets_static/images/front/vk_ico.png" class="social_ico">
        </a>
        <a href="#<?//=$vk_url?>" onclick="wnd_popup('<?=$fb_url?>',800,550); return false;" >
            <img src="/assets_static/images/front/fb_ico.png" class="social_ico">
        </a>
        <?
    }
}