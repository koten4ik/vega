<?php

Yii::import('zii.widgets.CPortlet');

class CartDialogWidget extends CPortlet
{


	protected function renderContent()
	{
        echo 'Товар <a href="#" id="prd_name"></a><br>добавлен в корзину.<br>
              <a href="'.$this->controller->createUrl('/shop/cart/').'">
                  Открыть корзину
              </a>';
	}
}