<? echo "<?\n";?>
/** @var $this Controller */
/** @var $data <?php echo $this->modelClass ?> */
<? echo "?>\n";?>

<div class="_view">

    <b><? echo "<? echo CHtml::encode(\$data->getAttributeLabel('title')); ?>" ?>:</b>
    <? echo "<? echo CHtml::link(\$data->title, \$data->getUrl()); ?>" ?>
    <br />

</div>