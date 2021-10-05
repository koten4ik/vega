<?php


class CartWidget extends CWidget
{

	public  function run()
	{ ?>
        <div id="<?=$this->id?>">
        <a  href="<? echo $this->controller->createUrl('/shop/cart') ?>" style="cursor: pointer;">
            Корзина:
            товаров - <? echo '<span id="itemsCount">'.Yii::app()->shoppingCart->getItemsCount().'</span>,' ?>
            <br>
            на сумму - <? echo '<span id="cost">'.Yii::app()->shoppingCart->getCost().'</span>'.ShopModule::getCurrency() ?>

        </a>
        </div>
    <?
	}
}