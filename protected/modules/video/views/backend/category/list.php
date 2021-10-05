<?php
$list = new CList();

$list->add(array('label' => 'Новая', 'url' => array(''),
        'linkOptions' => array('onclick' => 'DTcreateCat(); return false;'))
);
$list->add(array('label' => 'Сохранить', 'url' => array(''),
        'linkOptions' => array('onclick' => 'DTsaveCat(); return false;'))
);
$list->add(array('label' => 'Удалить', 'url' => array(''),
        'linkOptions' => array('onclick' => 'DTdeleteCat(); return false;'))
);
$this->menu = $list->toArray();
$this->widget('AdminCP');
?>

<div class="fl">
    <?
    $this->widget('DTreeCat', array(
        'id' => 'DTreeCatList',
        'canvasId'=>'DTreeCatBlock',
        'tableName' => $this->tableName,
        'createUrl' => $this->CreateUrl('create'),
        'updateUrl' => $this->CreateUrl('update'),
        'deleteUrl' => $this->CreateUrl('delete'),
        'root'=>$this->catId
        ));
    ?>
</div>

<div id="DTreeCatBlock" class="DTCatBlock"></div>
<div class="fc"></div>




