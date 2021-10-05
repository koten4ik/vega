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
    'buttons'=>array('create','delete')
));
<? echo "?>\n";?>

<?php echo "<? echo \$this->renderPartial(\$this->viewDir.'_grid', array('model'=>\$model)); ?>"; ?>
