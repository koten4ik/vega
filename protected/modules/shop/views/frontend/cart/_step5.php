<div class="step_block">

    <? $positions = $this->cart->getPositions(); ?>
    <table border="0" class="item_list">
        <thead>
            <td id="name_td" >Наименование</td>
            <td id="model_td" >Модель</td>
            <td id="price_td" >Цена</td>
            <td id="count_td" >Кол-во</td>
            <td id="sum_td" >Итого</td>
        </thead>
        <tbody>
            <? $i = 0; foreach($positions as $position) {   ?>
            <tr class="<? echo $i++ & 1 ? 'odd' : 'even' ?>">
                    <td class="name_td">
                        <a href="<? echo $position->url; ?>">
                            <? echo $position->name; ?>
                        </a>
                    </td>
                    <td class="model_td">
                        <? echo $position->model; ?>
                    </td>
                    <td class="price_td">
                        <? echo $position->price.ShopModule::getCurrency(); ?>
                    </td>
                    <td class="count_td">
                        <? echo $position->getQuantity(); ?>
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
    <span class="row " style="vertical-align: top;">
        <?php echo $form->labelEx($model,'comment'); ?>
        <?php echo $form->textArea($model,'comment', array('style'=>'width:300px; height:100px;')); ?>
        <?php echo $form->error($model,'comment'); ?>
    </span>

    <div class="row" align="right" style="display: inline-block; margin-left: 200px;">
        <b style="text-decoration: underline">Итого: <? echo $this->cart->cost.ShopModule::getCurrency() ?></b>

    </div>

</div>

<br>
<div align="right" style="">
     <a href="" class="butt green_grad butt_left" onclick="
        $('#order-tabs').tabs( 'select' , 3 );
        return false;">назад</a>
     <a href="" class="butt green_grad butt_right" onclick="
        $('#catalog-order-form').submit();
        return false;">подтвердить заказ</a>
</div>
