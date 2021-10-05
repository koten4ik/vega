
<div class="row" style="">
    <?php echo $form->checkBox($model, 'published'.$lng); ?>
    <?php echo $form->labelEx($model, 'published', array('class' => 'after_cbox')); ?>
    <?php echo $form->error($model, 'published'.$lng); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'title' , array('style' => 'display:inline-block; width:85px')); ?>
    <?php echo $form->textField($model, 'title' . $lng, array('maxlength' => 150, 'style' => 'width:100%')); ?>
    <?php echo $form->error($model, 'title'.$lng); ?>
</div>


<div class="row">
    <? echo $form->labelEx($model, 'descr'); ?>
    <? echo $form->textArea($model, 'descr'.$lng, array('class' => 'elrte'.$lng, 'rows' => 3, 'cols' => 50))?>
    <? echo $form->error($model, 'descr'.$lng); ?>
</div>


<div class="row">
    <?php echo $form->labelEx($model, 'metaTitle'); ?>
    <?php echo $form->textArea($model, 'metaTitle'.$lng, array('rows' => 1, 'style' => 'width:99%')); ?>
    <?php echo $form->error($model, 'metaTitle'.$lng); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'metaKeys'); ?>
    <?php echo $form->textArea($model, 'metaKeys'.$lng, array('rows' => 1, 'style' => 'width:99%')); ?>
    <?php echo $form->error($model, 'metaKeys'.$lng); ?>
</div>

<div class="row">
    <?php echo $form->labelEx($model, 'metaDesc'); ?>
    <?php echo $form->textArea($model, 'metaDesc'.$lng, array('rows' => 1, 'style' => 'width:99%')); ?>
    <?php echo $form->error($model, 'metaDesc'.$lng); ?>
</div>
