
<? $this->widget('ext.AjaxMultiUpload.EAjaxUpload',
    array(
        'id' => 'EAjaxUpload',
        'config' => array(
            'multiple' => true,
            'action' => $this->createUrl('upload', array('item_id' => $model->id, 'fname_import'=>$model->fname_import)),
            'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>Drop files here to upload</span></div><div class="qq-upload-button" style="padding: 0">добавить</div><ul class="qq-upload-list"></ul></div>',
            'debug' => false,
            'allowedExtensions' => array('jpg', 'jpeg', 'png', 'gif'),
            'sizeLimit' => 2 * 1024 * 1024, // maximum file size in bytes
            'onComplete' => "js:function(id, fileName, responseJSON){ $.fn.yiiGridView.update('igallery-image-grid" . $model->id . "') }",
        )
    )); ?>
<div class="row" style="padding-top: 10px; display: inline-block;">
    <?php echo $form->checkBox($model, 'fname_import', array('onclick'=>"$('#igallery-item-form').submit()")); ?>
    <?php echo $form->labelEx($model, 'fname_import', array('class' => 'after_cbox')); ?>
    <?php echo $form->error($model, 'fname_import'); ?>
</div>

<?
$this->widget('GridView', array(
    'id' => 'igallery-image-grid' . $model->id,
    'dataProvider' => IgalleryItemImage::model()->search($model->id),
    'hideHeader' => false,
    'selectableRows' => false,
    'saveState' => false,
    'summaryText' => '&nbsp',
    //'filter'=>$model,
    'columns' => array(
        array(
            'name' => 'image',
            'type' => 'raw',
            'value' => 'CHtml::image($data->fileUrl("image",3), "", array("style"=>""))',
            'id' => 'image_tr',
            'htmlOptions' => array('style' => 'width:120px; text-align:center'),
        ),
        array(
            'name' => 'descr',
            'value' => function($data)
            {

                if (Y::app()->params['multiLang'])
                    echo '<span style="vertical-align: 18px; margin-right: 5px;">RU</span>';
                echo CHtml::textArea('descr_img', $data->descr, array(
                    'style' => 'width:200px; height:30px;', 'id'=>'descr_img_'.$data->id,
                    'onchange' => '
                        $.post("setDescr?item=' . $data->id . '", {descr:$(this).val()}, function(data){
                            if(data==1){
                                $("#descr_img_' . $data->id . '").css("backgroundColor","#e6efc2");
                            }
                            else{ $("#descr_img_' . $data->id . '").css("backgroundColor","#ea9999"); }
                        });
                    '
                ));

                if (Y::app()->params['multiLang']) {

                    echo '<span style="vertical-align: 18px; margin-right: 5px;">EN</span>';
                    echo CHtml::textArea('descr_img', $data->descr_l2, array(
                        'style' => 'width:200px; height:30px;', 'id'=>'descr_img_l2_'.$data->id, 'onchange' => '
                            $.post("setDescrL2?item=' . $data->id . '", {descr:$(this).val()}, function(data){
                                if(data==1){
                                    $("#descr_img_l2_' . $data->id . '").css("backgroundColor","#e6efc2");
                                }
                                else{ $("#descr_img_l2_' . $data->id . '").css("backgroundColor","#ea9999"); }
                            });
                        '));
                }
            },
            'htmlOptions' => array('style' => 'width:240px;'),
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
                    'url' => 'Yii::app()->createUrl("/igallery/item/removeImg", array("id"=>$data->id))',
                ),
            ),
        ),
    ),
));