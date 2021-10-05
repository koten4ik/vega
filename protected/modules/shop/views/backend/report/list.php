<?php
/** @var $this Controller */
/** @var $form ActiveForm */



$this->widget('AdminCP');
?>


<? $this->widget('JuiTabs', array(
    'id'=>'report-tabs',
    'tabs'=>array(
        'Бронирование'=>
            $this->renderPartial('_reserveTab', array('reserv'=>$reserv ),true),
        'Спрос'=>
            $this->renderPartial('_demandTab', array('demand'=>$demand ),true),
    ),
    'options'=>array( 'disable'=>true  ),
)); ?>


