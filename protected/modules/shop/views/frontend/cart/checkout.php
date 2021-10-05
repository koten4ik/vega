
<div id="page_title"><span>Оформление заказа</span></div>

<div id="page_content">
    <div class="form">

    <?php $form=$this->beginWidget('ActiveForm', array(
        'id'=>'catalog-order-form',
        //'enableAjaxValidation'=>true,
        'enableClientValidation'=>true,
        'clientOptions' => array(
                    'validateOnSubmit' => true,
                    'validateOnChange' => true,)

    )); ?>


        <?
        $this->widget('JuiTabs', array(
            'id'=>'order-tabs',
            'tabs'=>array(
                'Личные данные'=>
                    $this->renderPartial('_step1',array('form'=>$form, 'model'=>$model), true),
                'Адрес доставки'=>
                    $this->renderPartial('_step2',array('form'=>$form, 'model'=>$model), true),
                'Способ доставки'=>
                    $this->renderPartial('_step3',array('form'=>$form, 'model'=>$model, 'ships'=>$ships), true),
                'Способ оплаты'=>
                    $this->renderPartial('_step4',array('form'=>$form, 'model'=>$model, 'pays'=>$pays), true),
                'Подтверждение заказа'=>
                    $this->renderPartial('_step5',array('form'=>$form, 'model'=>$model), true),
            ),
            'options'=>array( 'disable'=>true  ),
        ));
        ?>


        <?php echo $form->errorSummary($model);  ?>

    <?php $this->endWidget(); ?>

    </div><!-- form -->

</div>

<script type="text/javascript">
    $('input, select').change(function(){$.cookie($(this).attr('name'), $(this).val())})
</script>