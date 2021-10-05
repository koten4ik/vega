<div id="attrib_tab">
    <div id="serv_msg"></div>
<?php

$model->commandBuilder->schema->refresh();
$model->refreshMetaData();

if($model->isNewRecord) echo 'Для вывода харатеристик в соответствии с указанной категорией сохраните товар.';
else
    foreach(CatalogAttribute::getList($model->category) as $attrib){
        $sufix = $attrib->sufix ? ' ('.$attrib->sufix.')' : '';
        if($attrib->type == CatalogAttribute::STRING){
            echo CHtml::label($attrib->name.$sufix,'');
            echo $form->textField($model, 'attr'.$attrib->id,
                array('style'=>'width:150px;','maxlength'=>150,
                    'onblur'=>"$.post('/admin.php/shop/attribute/addVal?attr_id=".$attrib->id."'+'&val='+this.value )"
                )
            );
            echo ' '.CHtml::dropDownList('','',
                CMap::mergeArray(array(''=>''),CHtml::listData(CatalogAttrVal::getList($attrib->id),'value','value')),
                array('onchange'=>'$("#CatalogItem_attr'.$attrib->id.'").val(this.value)', 'style'=>'')
            );
            echo $form->error($model,$attrib->id);
        }
        if($attrib->type == CatalogAttribute::BOOLEAN){
            echo CHtml::label($attrib->name,'');
            echo $form->dropDownList($model, 'attr'.$attrib->id, array(''=>'', '1'=>'Да', '2'=>'Нет'));
            echo $form->error($model,$attrib->id);
        }
        if($attrib->type == CatalogAttribute::NUMERIC){
            echo CHtml::label($attrib->name.$sufix,'');
            echo $form->textField($model, 'attr'.$attrib->id, array('style'=>'width:97px;'));
            echo $form->error($model,$attrib->id);
        }
        echo '<br>';
    }?>
</div>