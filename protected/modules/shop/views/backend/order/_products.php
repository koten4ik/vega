

<table border="0" class="positions">
    <thead>
        <td id="butt" >Наименование</td>
        <td id="name" >Модель</td>
        <td id="price" >Цена</td>
        <td id="count" >Кол-во</td>
        <td id="sum" >Итого</td>
    </thead>
    <tbody>
        <? foreach($positions as $key=>$position) {   ?>
            <tr class="<? echo ($key&1 ? 'even':'odd') ?>">
                <td class="name">
                    <a href="<? echo $this->createUrl('item/update', array('id'=>$position->id)); ?>">
                        <? echo $position->name; ?>
                    </a>
                    <br>
                    <? echo $position->selectedOptions(); ?>
                </td>
                <td class="model">
                    <? echo $position->model; ?>
                </td>
                <td class="price">
                    <? echo $position->getPrice().ShopModule::getCurrency(); ?>
                </td>
                <td class="count">
                    <? echo $position->quantity; ?>
                </td>
                <td class="sum">
                    <? if($position->category->alias == 'reserve') echo 'Бронирование';
                       else echo ($position->getPrice() * $position->quantity).ShopModule::getCurrency(); ?>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>