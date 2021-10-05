<div class="step_block">

    <div class="fl" style="width: 50%; padding-left: 7%">

        <div class="row">
            <?php echo $form->labelEx($model,'pay_firstname'); ?>
            <?php echo $form->textField($model,'pay_firstname'); ?>
            <?php echo $form->error($model,'pay_firstname'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'pay_lastname'); ?>
            <?php echo $form->textField($model,'pay_lastname'); ?>
            <?php echo $form->error($model,'pay_lastname'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'pay_phone1'); ?>
            <?php echo $form->textField($model,'pay_phone1'); ?>
            <?php echo $form->error($model,'pay_phone1'); ?>
        </div>
        <!--div class="row">
            <?php //echo $form->labelEx($model,'pay_phone2'); ?>
            <?php //echo $form->textField($model,'pay_phone2'); ?>
            <?php //echo $form->error($model,'pay_phone2'); ?>
        </div-->
        <div class="row">
            <?php echo $form->labelEx($model,'pay_email'); ?>
            <?php echo $form->textField($model,'pay_email'); ?>
            <?php echo $form->error($model,'pay_email'); ?>
        </div>

    </div>

    <div style="margin-left: 50%; " >
        <!--div class="row">
            <?php //echo $form->labelEx($model,'pay_company'); ?>
            <?php //echo $form->textField($model,'pay_company'); ?>
            <?php //echo $form->error($model,'pay_company'); ?>
        </div-->

        <? $this->widget('RegionsWidget', array(
            'form'=>$form,
            'model'=>$model,
            'countryVal'=>'2',
            'regionAttr'=>'pay_region',
            'cityAttr'=>'pay_city',
        ));
        ?>


        <div class="row">
            <?php echo $form->labelEx($model,'pay_postcode'); ?>
            <?php echo $form->textField($model,'pay_postcode'); ?>
            <?php echo $form->error($model,'pay_postcode'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'pay_address_1'); ?>
            <?php echo $form->textField($model,'pay_address_1'); ?>
            <?php echo $form->error($model,'pay_address_1'); ?>
        </div>
        <!--div class="row">
            <?php //echo $form->labelEx($model,'pay_address_2'); ?>
            <?php //echo $form->textField($model,'pay_address_2'); ?>
            <?php //echo $form->error($model,'pay_address_2'); ?>
        </div-->
    </div>

    <br>
    <input type="checkbox" id="copy_data" style="margin-left: 7%" checked/>
    <label for="copy_data" class="after_cbox">Адрес доставки совпадает с адресом плательщика. </label>

</div>

<br>
<div align="right" style="margin-right: 77px;">
     <a href="" class="butt green_grad" onclick="
        //$('#CatalogOrder_pay_email').trigger('change');
        if($('#copy_data').attr('checked')){
            $('#CatalogOrder_ship_firstname').val($('#CatalogOrder_pay_firstname').val());
            $('#CatalogOrder_ship_lastname').val($('#CatalogOrder_pay_lastname').val());
            $('#CatalogOrder_ship_phone1').val($('#CatalogOrder_pay_phone1').val());
            $('#CatalogOrder_ship_email').val($('#CatalogOrder_pay_email').val());

            $('#CatalogOrder_ship_region').html($('#CatalogOrder_pay_region').html());
            $('#CatalogOrder_ship_city').html($('#CatalogOrder_pay_city').html());
            $('#CatalogOrder_ship_region [value='+$('#CatalogOrder_pay_region').val()+']').attr('selected', 'selected');
            $('#CatalogOrder_ship_city [value='+$('#CatalogOrder_pay_city').val()+']').attr('selected', 'selected');

            $('#CatalogOrder_ship_postcode').val($('#CatalogOrder_pay_postcode').val());
            $('#CatalogOrder_ship_address_1').val($('#CatalogOrder_pay_address_1').val());
            $('#order-tabs').tabs( 'select' , 2 );
        }
        else  $('#order-tabs').tabs( 'select' , 1 );
console.log($('#CatalogOrder_pay_region').parent().attr('class'));
        return false;">далее</a>
</div>

    <script type="text/javascript">
        //$('#CatalogOrder_pay_email').change(function(){alert(1)});
        //console.log($('#CatalogOrder_pay_firstname'));
        //$('#catalog-order-form').yiiactiveform()
    </script>