
<? $this->pageTitle = Yii::app()->name.' - Ваш заказ оформлен!'; ?>

<div id="page_title"><span>Ваш заказ оформлен!</span></div>

<div id="page_content">
    <span style="font-size: 200%; color: #888">Ваш заказ успешно оформлен!</span>
    <br><br>
    Все вопросы направляйте
    <a href="<? echo $this->createUrl('/contact') ?>">владельцу магазина</a>.
    <br><br>
    Спасибо за покупку!
</div>