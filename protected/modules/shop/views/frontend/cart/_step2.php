<div class="step_block">

    <div class="fl" style="width: 50%; padding-left: 7%">

        <div class="row">
            <?php echo $form->labelEx($model,'ship_firstname'); ?>
            <?php echo $form->textField($model,'ship_firstname'); ?>
            <?php echo $form->error($model,'ship_firstname'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'ship_lastname'); ?>
            <?php echo $form->textField($model,'ship_lastname'); ?>
            <?php echo $form->error($model,'ship_lastname'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'ship_phone1'); ?>
            <?php echo $form->textField($model,'ship_phone1'); ?>
            <?php echo $form->error($model,'ship_phone1'); ?>
        </div>
        <!--div class="row">
            <?php //echo $form->labelEx($model,'ship_phone2'); ?>
            <?php //echo $form->textField($model,'ship_phone2'); ?>
            <?php //echo $form->error($model,'ship_phone2'); ?>
        </div-->
        <div class="row">
            <?php echo $form->labelEx($model,'ship_email'); ?>
            <?php echo $form->textField($model,'ship_email'); ?>
            <?php echo $form->error($model,'ship_email'); ?>
        </div>

    </div>

    <div style="margin-left: 50%; " >
        <!--div class="row">
            <?php //echo $form->labelEx($model,'ship_company'); ?>
            <?php //echo $form->textField($model,'ship_company'); ?>
            <?php //echo $form->error($model,'ship_company'); ?>
        </div-->

        <? $this->widget('RegionsWidget', array(
            'form'=>$form,
            'model'=>$model,
            'countryVal'=>'2',
            'regionAttr'=>'ship_region',
            'cityAttr'=>'ship_city',
        ));  ?>

        <div class="row">
            <?php echo $form->labelEx($model,'ship_postcode'); ?>
            <?php echo $form->textField($model,'ship_postcode'); ?>
            <?php echo $form->error($model,'ship_postcode'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'ship_address_1'); ?>
            <?php echo $form->textField($model,'ship_address_1'); ?>
            <?php echo $form->error($model,'ship_address_1'); ?>
        </div>
        <!--div class="row">
            <?php //echo $form->labelEx($model,'ship_address_2'); ?>
            <?php //echo $form->textField($model,'ship_address_2'); ?>
            <?php //echo $form->error($model,'ship_address_2'); ?>
        </div-->
    </div>

</div>

<br>
<div align="right" style="margin-right: 77px;">
     <a href="" class="butt green_grad butt_left" onclick="
        $('#order-tabs').tabs( 'select' , 0 );
        return false;">назад</a>
     <a href="" class="butt green_grad butt_right" onclick="
        $('#order-tabs').tabs( 'select' , 2 );
        return false;">далее</a>
</div>

