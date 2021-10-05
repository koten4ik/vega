<? echo "<?\n";?>
/** @var $this Controller */
/** @var $model <?php echo $this->modelClass ?> */
<? echo "?>\n";?>

<h1 id="page_title"><? echo "<? echo Y::t('Elements') ?>" ?></h1>

<div id="page_content">
    <? echo "<?\n";?>
    $this->widget('ListViewFront', array(
    	'id'=>'<? echo $this->class2id($this->modelClass)?>-list',
    	'dataProvider'=>$model->search_front(),
        'itemView'=>'_view',
        )
    );
    <? echo "?>\n";?>
</div>