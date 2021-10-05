<?
/** @var $order CatalogOrder */
/** @var $positions CatalogItem */

echo "Детали заказа:\r\n\r\n";
echo $order->getAttributeLabel('pay_firstname').' : '.$order->pay_firstname."\r\n";
echo $order->getAttributeLabel('pay_lastname').' : '.$order->pay_lastname."\r\n";
echo $order->getAttributeLabel('pay_email').' : '.$order->pay_email."\r\n";
echo $order->getAttributeLabel('pay_phone1').' : '.$order->pay_phone1."\r\n";
echo $order->getAttributeLabel('total').' : '.$order->total.' '.ShopModule::getCurrency()."\r\n\r\n";

echo $order->getAttributeLabel('pay_method').' : '.$order->pay_method."\r\n";
echo $order->getAttributeLabel('ship_method').' : '.$order->ship_method."\r\n\r\n";

echo "Товары:\r\n\r\n";
foreach($positions as $key=>$position){
    echo $position->name.'   '.$position->getQuantity().'шт.   '.$position->getPrice().ShopModule::getCurrency()."\r\n";
}

echo "\r\n\r\nПодробнее: ".Y::app()->request->hostInfo.'/admin.php/shop/order/update?id='.$order->id;

