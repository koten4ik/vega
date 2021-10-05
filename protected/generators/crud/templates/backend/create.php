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

$this->widget('AdminCP', array(
    'item_name'=>'<? echo $this->class2id($this->modelClass)?>',
    'mod_title'=>$this->title,
    'mod_act_title'=>'Новый элемент',
    'buttons'=>array('save','close','save_close')
));
<? echo "?>\n";?>

<?php echo "<?php echo \$this->renderPartial(\$this->viewDir.'_form', array('model'=>\$model)); ?>"; ?>
