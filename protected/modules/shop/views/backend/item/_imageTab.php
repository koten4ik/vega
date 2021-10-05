
<div id="image_tab" style="width: 60%;">



<? $this->widget('ext.AjaxMultiUpload.EAjaxUpload',
    array(
        'id' => 'EAjaxUpload',
        'config' => array(
            'multiple' => true,
            'action' => $this->createUrl('upload', array('item_id' => $model->id, )),
            'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>Drop files here to upload</span></div><div class="qq-upload-button" style="padding: 0">добавить</div><ul class="qq-upload-list"></ul></div>',
            'debug' => false,
            'allowedExtensions' => array('jpg', 'jpeg', 'png', 'gif'),
            'sizeLimit' => 2 * 1024 * 1024, // maximum file size in bytes
            'onComplete' => "js:function(id, fileName, responseJSON){ $.fn.yiiGridView.update('igallery-image-grid" . $model->id . "') }",
        )
    )); ?>


<?
$this->widget('GridView', array(
    'id' => 'igallery-image-grid' . $model->id,
    'dataProvider' => CatalogItemImage::model()->search($model->id),
    'hideHeader' => false,
    'selectableRows' => false,
    'saveState' => false,
    'summaryText' => '&nbsp',
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'image',
            'type' => 'raw',
            'value' => 'CHtml::image($data->fileUrl("image",1), "", array("style"=>""))',
            'id' => 'image_tr',
            'htmlOptions' => array('style' => 'width:120px; text-align:center'),
        ),

        array(
            'name' => 'position',
            'value' => function($data)
            {
                echo CHtml::textField('position', $data->position, array(
                    'style' => 'width:40px;', 'id'=>'position_'.$data->id, 'onchange' => '
                        $.post("setPosition?item=' . $data->id . '&position="+$(this).val(), function(data){
                            if(data==1){
                                $("#position_' . $data->id . '").css("backgroundColor","#e6efc2");
                            }
                            else{ $("#position_' . $data->id . '").css("backgroundColor","#ea9999"); }
                        });
                    '));
            },
            'htmlOptions' => array('style' => 'width:40px;'),
        ),
        array(
            'name' => 'published',
            'id' => 'published_tr',
            'htmlOptions' => array('style' => 'width:20px; text-align:center'),
            'filter' => array('1' => 'Да', '0' => 'Нет'),
            'callbackUrl'=>array('setPubl'),
            'class' => 'FlagColumn',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'htmlOptions' => array('style' => 'width:20px;'),
            'buttons' => array(
                'delete' => array(
                    'url' => 'Yii::app()->createUrl("/shop/item/removeImg", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
));?>
</div>