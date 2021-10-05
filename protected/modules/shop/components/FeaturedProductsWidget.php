<?php


class FeaturedProductsWidget extends CWidget
{

    public function run()
    {
        $featuredList = CatalogItem::getFeaturedList();
        if (count($featuredList)) {   ?>

        <div id="page_title"><span>Спецпредложения:</span></div>
        <div id="page_content" style="margin-bottom: 5px;">
            <? foreach ($featuredList as $item) {
            $this->render('_view_featured', array('data' => $item));
        }?>
        </div>

        <?
        }
    }
}