
<div class="fl" style="width: 50%; border: 0px solid">

    <div class="row">
        <?php echo $form->labelEx($model,'name', array('style'=>'display:inline-block; width:95px')); ?>
        <?php echo $form->textField($model,'name',array('maxlength'=>150, 'style'=>'width:65%')); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'alias', array('style'=>'display:inline-block; width:95px')); ?>
        <?php echo $form->textField($model,'alias',array('maxlength'=>150, 'style'=>'width:65%')); ?>
        <?php echo $form->error($model,'alias'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'model', array('style'=>'display:inline-block; width:95px')); ?>
        <?php echo $form->textField($model,'model',array('maxlength'=>150, 'style'=>'width:65%')); ?>
        <?php echo $form->error($model,'model'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'sku', array('style'=>'display:inline-block; width:95px')); ?>
        <?php echo $form->textField($model,'sku',array('maxlength'=>150, 'style'=>'width:65%')); ?>
        <?php echo $form->error($model,'sku'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'manuf_id', array('style'=>'display:inline-block; width:95px')); ?>
        <?php echo $form->dropDownList($model,'manuf_id',
            //CatalogManufacturer::getList(),
            CHtml::listData(CatalogManufacturer::getList(),'id','name'),
            array('maxlength'=>150, 'style'=>'width:66%')); ?>
        <?php echo $form->error($model,'manuf_id'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'position', array('style'=>'display:inline-block; width:95px')); ?>
        <?php echo $form->textField($model,'position',array('maxlength'=>150, 'style'=>'width:65%')); ?>
        <?php echo $form->error($model,'position'); ?>
    </div>

</div>

<div style="margin-left:50%; padding-left: 0px; border: 0px solid" >

    <?php echo $form->error($model,'cat_id'); ?>
    <div class="row" style="height: 25px">
        <?php echo $form->labelEx($model, 'cat_id', array('style' => 'display:inline-block; width:120px')); ?>
        <? $this->widget('FieldCategory', array('field' => 'cat_id', 'form' => $form, 'model' => $model,
                'catModel' => 'CatalogCategory', 'style'=>'width:62%;'))?>
        <?php echo $form->error($model, 'cat_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'count', array('style'=>'display:inline-block; width:120px')); ?>
        <?php echo $form->textField($model,'count',array('maxlength'=>150, 'style'=>'width:62%')); ?>
        <?php echo $form->error($model,'count'); ?>
    </div>

    <fieldset style="width: 85%">
        <legend>Цена на сайте</legend>
    <div class="row">
        <?php echo $form->labelEx($model,'price_main', array('style'=>'display:inline-block; width:120px')); ?>
        <?php echo $form->radioButton($model, 'price_type', array('value'=>CatalogItem::PRICE_MAIN, 'id'=>'price_type0', 'uncheckValue'=>null))?>
        <?php echo $form->textField($model,'price_main',array('maxlength'=>150, 'style'=>'width:100px', 'onclick'=>'$("#price_type0").attr("checked",1)')); ?>
        <?php echo $form->error($model,'price_main'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'price_special', array('style'=>'display:inline-block; width:120px')); ?>
        <?php echo $form->radioButton($model, 'price_type', array('value'=>CatalogItem::PRICE_SPECIAL, 'id'=>'price_type1', 'uncheckValue'=>null))?>
        <?php echo $form->textField($model,'price_special',array('maxlength'=>150, 'style'=>'width:100px', 'onclick'=>'$("#price_type1").attr("checked",1)')); ?>
        <?php echo $form->error($model,'price_special'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model,'price_stock', array('style'=>'display:inline-block; width:120px')); ?>
        <?php echo $form->radioButton($model, 'price_type', array('value'=>CatalogItem::PRICE_STOCK, 'id'=>'price_type2', 'uncheckValue'=>null))?>
        <?php echo $form->textField($model,'price_stock',array('maxlength'=>150, 'style'=>'width:100px', 'onclick'=>'$("#price_type2").attr("checked",1)')); ?>
        <?php echo $form->error($model,'price_stock'); ?>
    </div>
    </fieldset>

    <div class="row fl" style="padding-top: 0px; " >
        <?php //echo $form->checkBox($model,'published'); ?>
        <?php //echo $form->labelEx($model,'published', array('class'=>'after_cbox')); ?>
        <?php echo $form->labelEx($model,'published', array('style'=>'display:inline-block; width:100px')); ?>
        <?php echo $form->dropDownList($model, 'published', array('1'=>'Да', '0'=>'Нет'))?>
        <?php echo $form->error($model,'published'); ?>
    </div>

</div>

<div class="fc"></div>