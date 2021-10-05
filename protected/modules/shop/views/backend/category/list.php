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

<table width="100%" style="" border="0">
    <tr>
        <td id="CatalogCatList_cont" style="width: 270px;">
            <?
            $this->widget('DTreeCat', array(
                'id' => 'DTreeCatList',
                'canvasId'=>'DTreeCatBlock',
                'tableName' => $this->tableName,
                'createUrl' => $this->CreateUrl('create'),
                'updateUrl' => $this->CreateUrl('update'),
                'deleteUrl' => $this->CreateUrl('delete')
                ));
            ?>
        </td>
        <td>
            <div id="DTreeCatBlock" class="DTCatBlock" style="margin-left: 0;"></div>
        </td>
    </tr>
</table>





