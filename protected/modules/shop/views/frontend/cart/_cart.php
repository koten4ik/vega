<?
$positions = $this->cart->getPositions();
if(count($positions)) {
?>
<table border="0" class="cart">
    <thead class="">
        <td id="butt_td" ></td>
        <td id="photo_td" >Фото</td>
        <td id="name_td" >Наименование товара</td>
        <td id="price_td" >Цена</td>
        <td id="count_td" >Кол-во</td>
        <td id="sum_td" >Итого</td>
    </thead>
    <tbody>
        <? $i = 0; foreach($positions as $position) {   ?>
            <tr class="<? echo $i++ & 1 ? 'odd' : 'even' ?>">
                <td class="butt_td">
                    <a href="" class="ui-state-default ui-corner-all trash_butt" onclick="if(confirm('Подтверждение удаления')) delCartItem(<? echo $position->id; ?>); return false;">
                        <span class="ui-icon ui-icon-trash" />
                    </a>
                </td>
                <td class="photo_td">
                    <a href="<? echo $position->url; ?>">
                        <img src="<? echo $position->fileUrl('image',1); ?>" width="60px" height="45">
                    </a>
                </td>
                <td class="name_td">
                    <a href="<? echo $position->url; ?>">
                        <? echo $position->name; ?>
                    </a><br>
                    <? echo $position->model; ?>
                    <br>
                    <? echo $position->selectedOptions(); ?>
                </td>
                <td class="price_td">
                    <? echo $position->price.ShopModule::getCurrency(); ?>
                </td>
                <td class="count_td">
                    <input type="text" class="fl" value="<? echo $position->getQuantity(); ?>" id="quantity<? echo $position->id; ?>"  onkeypress="$('#refresh_butt<? echo $position->id; ?>').fadeIn()" />
                    <div id="refresh_butt<? echo $position->id; ?>" onclick="UpdCartItem(<? echo $position->id; ?>)" class="ui-state-default ui-corner-all  refresh_butt fl" ><span class="ui-icon ui-icon-refresh" /></div>
                </td>
                <td class="sum_td">
                    <? if($position->category->alias == 'reserve') echo 'Бронирование';
                       else echo $position->getSumPrice().ShopModule::getCurrency(); ?>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>
<br>

<a class="fl green_grad butt" href="" onclick="if(confirm('Подтверждение')) delCartItem('all'); return false;">Очистить корзину</a>

<div align="right">
    <b>Общая сумма:</b> <? echo $this->cart->cost.ShopModule::getCurrency() ?>
    <br><br>
    <a class="green_grad butt butt_left" href="<? echo $this->createUrl('/catalog/all_0') ?>">продолжить покупки</a>
    <a class="green_grad butt butt_right" href="<? echo $this->createUrl('/shop/cart/checkout') ?>">оформить заказ</a>

</div>

<? } else { ?>

    <span style="font-size: 200%; color: #888">Ваша корзина пуста!</span>
<? } ?>
<? //var_dump( Yii::app()->shoppingCart->getPositions());
foreach($positions as $position)
    if($position->id == 85) echo "asd";
?>