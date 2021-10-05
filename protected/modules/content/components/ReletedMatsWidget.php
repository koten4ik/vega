<?php

Yii::import('CWidget');

class ReletedMatsWidget extends CWidget
{
    public $item_id;

    public function run()
    {
        $rel_mats = ContentItemRel::getList($this->item_id);
        if (count($rel_mats)) {
        ?>

        <div class="rel_mats">
            <div class="rel_mats_title"><?=Y::t('Материалы по теме')?>:</div>
            <?foreach ($rel_mats as $elem) { ?>
            <a href="<?=$elem->item->getUrl()?>"><?=$elem->item->title?></a><br>
            <? }?>
        </div>

        <?
        }
    }
}