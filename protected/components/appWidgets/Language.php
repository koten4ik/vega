<?php


class Language extends CWidget
{


	public  function run()
	{
        $ln1 = str_replace('en/','',Y::app()->request->url);
        $ln2 = '/en'.$ln1;
        ?>
        <div class="langua">
            <a class="lang <? if (Y::lang() == 'ru' || Y::lang() == '') echo 'select' ?>" href="<?=$ln1?>"
               onclick="//return SetLang('ru', ['ru','en'])">По-русски</a>
            <span>|</span>
            <a class="lang <? if (Y::lang() == 'en') echo 'select' ?>" href="<?=$ln2?>"
               onclick="//return SetLang('en', ['ru','en'])" style="">In English</a>
        </div>
    <?
	}
}