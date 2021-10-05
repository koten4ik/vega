<?
/** @var $this Controller */
/** @var $form ActiveForm */

?>

<div class="form pad">

<?php $form=$this->beginWidget('ActiveForm', array(
	'id'=>'catalog-order-form',
	'enableAjaxValidation'=>false,
)); ?>

<div class="" style="">

    <? $this->widget('JuiTabs', array(
        'id'=>'order-tabs',
        'tabs'=>array(
            'Детали заказа'=>
                $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'cssFile'=>false,
                    'attributes'=>array(
                        'id',   'customer',   'ip',
                        'pay_email',  'pay_phone1',  'total_c',
                        array(
                            'name'=>'status',
                            'type'=>'raw',
                            'value'=>$form->dropDownList($model, 'status', CatalogOrder::statusList())),
                        'cdate',
                        'comment'
                    ),
                ),true),

            'Детали оплаты'=>
                $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'cssFile'=>false,
                    'attributes'=>array(
                        'pay_firstname',   'pay_lastname',   'pay_address_1',
                        'pay_city_data.city_name_ru',  'pay_postcode', 'pay_region_data.region_name_ru', 'pay_method'

                    ),
                ),true),

            'Адрес доставки'=>
                $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'cssFile'=>false,
                    'attributes'=>array(
                        'ship_firstname',   'ship_lastname',   'ship_address_1',
                        'ship_city_data.city_name_ru',  'ship_postcode', 'ship_region_data.region_name_ru', 'ship_method'

                    ),
                ),true),

            'Товары'=>
                $this->renderPartial('_products', array('positions'=>$positions),true)
        ),
        'options'=>array( 'disable'=>true  ),
    )); ?>

</div>

    <? echo CHtml::hiddenField('redirect'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>$(function(){  $('input:first').focus();  });</script>

