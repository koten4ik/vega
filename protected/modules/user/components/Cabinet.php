<?php


class Cabinet extends CWidget
{


    public function run()
    {

        $noReadedAllCnt = Y::user_id() ? UserMsg::noReadedAllCnt() : 0;
        ?>
    <noindex>
        <div id="user_block_popup" class="fr ib">
            <div class="decore">
                <b><?=Y::t('Мои разделы').':'?></b>
                <br>
                <?if(User::isAdmin())
                    echo ' '.CHtml::link('Админ. панель', '/admin', array('target'=>'_blank')).'<br>';?>

                <a href="/user/page/edit"><?=Y::t('Личная страница')?></a>
                <a href="/user/message/list"><?=Y::t('Сообщения')
                    . ($noReadedAllCnt ? '(' . $noReadedAllCnt . ')' : '')?></a>

                <br>


                <a href="/user/logout"><?=Y::t('Выйти')?></a>
            </div>
        </div>
    </noindex>
    <?
    }
}