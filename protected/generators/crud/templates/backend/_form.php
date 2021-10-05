<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<? echo "<?\n";?>
/** @var $this Controller */
/** @var $form ActiveForm */
/** @var $model <?php echo $this->modelClass ?> */
$this->registerScript("
    $('.elrte').elrte(" . Y::elrteOpts(array('height' => 200)) . ");
    $('.form input[type=text]:first').focus();
", CClientScript::POS_END);
<? echo "?>\n";?>

<div class="form pad">
<?php echo "<?php \$form=\$this->beginWidget('ActiveForm', array('id'=>'".$this->class2id($this->modelClass)."-form')); ?>\n"; ?>

<?php
foreach($this->tableSchema->columns as $column)
{
    if($column->autoIncrement)
        continue;
    echo "<?= \$form->textFieldW(\$model, '".$column->name."', array( 'l_w'=>100, 'f_w'=>300, 'inl'=>1 )); ?>\n";
}
?>
    <?php echo "<? echo CHtml::hiddenField('redirect');?>\n"; ?>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div><!-- form -->