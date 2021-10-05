<?php

Yii::import('CWidget');

class TagsWidget extends CWidget
{
    public $item;

    public function run()
    {
        $tags = ContentItemTag::getList($this->item->id);
        if (count($tags)) {
        ?>

        <div class="tags">
            <div class="tags_title"><?=Y::t('Ключевые слова')?>:</div>
            <?foreach ($tags as $elem) { ?>
            <a href="<?=$this->item->getTagUrl($elem->item->id)?>"><?=$elem->item->title?></a>
            <? }?>
        </div>

        <?
        }
    }
}