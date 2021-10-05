
<? if(Y::app()->params['multiLang']){?>
<div class="row">
    <?php echo $form->labelEx($model, 'title' , array('style' => '')); ?>
    <?php echo $form->textField($model, 'title' . $lng, array('maxlength' => 150, 'style' => 'width:99%')); ?>
    <?php echo $form->error($model, 'title'.$lng); ?>
</div>
<?}?>


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
