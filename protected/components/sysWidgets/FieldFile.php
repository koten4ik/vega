<?php
/*
    <div class="row">
        <? $this->widget('FieldFile',
            array('field'=>'avatar', 'tmb_num'=>1, 'form'=>$form,'model'=>$model))?>
    </div>
*/

Yii::import('zii.widgets.CPortlet');

class FieldFile extends CWidget
{
    public $field;
    public $model;
    public $form;
    public $tmb_num = 0;
    public $local_allow = 1;
    public $server_allow = 0;
    public $img_w = 250;
    public $img_h = 250;
    public $success_f;
    public $label = '';
    public $crop_w = 0;
    public $crop_h = 0;

    public function run()
    {
        $field = $this->field;
        $field_data = $this->model->files_config[$field];
        $field_tmp_id = get_class($this->model) . '_' . $field . '_tmp';

        Yii::app()->clientScript->registerScriptFile(
            Y::app()->baseUrl . '/assets_static/js/vegaUploader.js', CClientScript::POS_HEAD);

        $dir_a = '/content/upload/temp/';
        $dir_a = $dir_a[0] == '/' ? substr($dir_a, 1) : $dir_a;

        $url = Y::app()->baseUrl;
        $url .= Y::params('cfgName') == 'backend' ? '/' . BACKEND_NAME : '';
        $url .= $this->controller->module->id ? '/' . $this->controller->module->id : '';
        $url .= '/' . $this->controller->id . '/ajaxupload?';
        $url .= 'dir=' . $dir_a . '&fnum=' . $field_tmp_id . '&maxSize=' . $field_data['rule']['maxSize']
            . '&types=' . $field_data['rule']['types']. '&min_res=' . $this->crop_w.'х'.$this->crop_h;

        ?>
    <? // ====================== label ======================== ?>

    <? if ($this->label) echo CHtml::label($this->label, '', array('style' => 'display:inline-block'));
       else echo $this->form->labelEx($this->model, $field . '_tmp',
             array('style' => 'display:inline-block', 'for' => '')); ?>
    <?= $this->form->hiddenField($this->model, $field . '_tmp');  ?>
    <? if ($this->model->$field) echo "<script>$('#" . $field_tmp_id . "').val('filled');</script>" ?>

    <? // ====================== load button ================== ?>

    <div class="ib load_button">
        <span title="" onclick="ajaxFileUpload<?=$field_tmp_id?>()" id="auf_button<?=$field_tmp_id?>"
              style="position: relative; overflow: hidden;  direction: ltr; margin-bottom: 0px;
                            margin-left: 3px; cursor: pointer !important; display: inline-block;
                             text-decoration: underline; vertical-align: -3px;">
                    <?= $this->server_allow ? 'комп' : 'обзор' ?>
            <input type="file" name="<?=$field_tmp_id?>" id="auf_file<?=$field_tmp_id?>"
                   style="position: absolute; right: 0px; top: 5px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer !important; opacity: 0;">
                </span>

        <img id="auf_loading<?=$field_tmp_id?>" style="margin-left:5px; display:none;" src="<?=LOAD_ICO?>"/>
        <span id="auf_error<?=$field_tmp_id?>" style="color: red; margin: 0px 0px;"></span>

        &nbsp;|&nbsp;
        <a href="#" title="Очистить" onclick="
            if(!confirm('Очистить ?')) return false;
            $('#<?= '' . $field_tmp_id ?>').val('del_curr_image');
            $('#<?= '' . $field_tmp_id ?>').trigger('change');
            $('#<?=$field_tmp_id . '_block'?>').attr('src','<? echo Controller::noImg; ?>');
            $('#<?=$field_tmp_id . '_block_f'?>').html('<a><?=Y::t('Файл не выбран', 0)?></a>');
            return false;
            ">x</a>

    </div>

    <? // ====================== display data ================== ?>

    <div class="display_data">

        <? $tmp_f_name = explode('/', $this->model->{$field . '_tmp'});
            if ($field_data['type'] == 'image' && $this->tmb_num != -1) {
                $img_url = $this->model->fileUrl($field, $this->tmb_num);
                if (count($tmp_f_name) > 1 && !$this->model->$field) $img_url = $this->model->{$field . '_tmp'} ?>
            <img src="<?= Y::app()->baseUrl . $img_url ?>" id="<?=$field_tmp_id . '_block'?>"
                 style="max-width: <?=$this->img_w?>px; max-height: <?=$this->img_h?>px; border: 1px solid #bbb; margin-top: 5px;
                     cursor: pointer;" onclick="$('#auf_file<?=$field_tmp_id?>').trigger('click');ajaxFileUpload<?=$field_tmp_id?>()">
            <? } else { ?>
            <span id="<?=$field_tmp_id . '_block_f'?>" class="ib" style="margin: 4px 0px;">
                    <? if ($this->model->$field) { ?>
                <a href="<?= Y::app()->baseUrl . $this->model->fileUrl($field)?>"><?= $this->model->$field ?></a>
                <?
            } else
                if (count($tmp_f_name) > 1) {
                    ?>
                    <a href="<?= Y::app()->baseUrl . $this->model->{$field . '_tmp'} ?>">
                        <? echo $tmp_f_name[count($tmp_f_name) - 1]; ?>
                    </a>
                    <? } else { ?>
                    <a><?=Y::t('Файл не выбран')?></a>
                    <? } ?>
                </span>
            <? } ?>

        <div id="a_err<?=$field_tmp_id?>" style="color: red; margin: 0px 0px;"></div>
        <?php echo $this->form->error($this->model, $field . '_tmp', array('id' => 'err' . $field_tmp_id)); ?>

    </div>

    <? // ====================== cropper ================== ?>
    <? if ($this->crop_w > 0) { ?>
        <script src="/assets_static/extentions/cropper/cropper.js"></script>
        <link rel="stylesheet" href="/assets_static/extentions/cropper/cropper.css">
        <? $this->beginWidget('JuiDialog', array('id' => 'crop_dialog' . $field_tmp_id, 'title' => 'Cropper')); ?>
            <div id="crop_canvas<?=$field_tmp_id?>" style="margin-top: 20px;">
                <img src="" id="crop_image<?=$field_tmp_id?>" style="">
            </div>
            <div style="text-align: center">
                <button style="width: 300px; height:50px; margin: 20px; font-size: 130%;"
                        onclick="cropper_aplly()">Применить
                </button>
            </div>
        <?$this->endWidget('JuiDialog');?>
    <?}?>

    <? // ====================== js functions ================== ?>

    <script type="text/javascript">
        var cropper;
        function ajaxFileUpload<?=$field_tmp_id?>() {
            $().vegaUploader({
                url:'<?=$url?>',
                field_name:'<?=$field_tmp_id?>',
                error_text:'#auf_error<?=$field_tmp_id?>',
                upl_butt:'#auf_button<?=$field_tmp_id?>',
                upload_file:'#auf_file<?=$field_tmp_id?>',

                start:function (data) {
                    $("#a_err<?=$field_tmp_id?>").html('');
                    $("#auf_loading<?=$field_tmp_id?>").show();
                },
                success:function (data) {
                    if (typeof(data.error) != 'undefined') {
                        $("#a_err<?=$field_tmp_id?>").html(data.error);
                    }
                    else {
                        var url_n = '<?=Y::app()->baseUrl?>/<?=$dir_a?>' + data.filename;

                        $('#<?= '' . $field_tmp_id ?>').val(url_n);

                        $('#<?=$field_tmp_id . '_block'?>').attr('src', url_n);

                        $('#<?= $field_tmp_id . '_block_f' ?> a').text(data.filename);
                        $('#<?= $field_tmp_id . '_block_f' ?> a').attr('href', url_n);
                        $('#<?= '' . $field_tmp_id ?>').trigger('change');
                        $("#a_err<?=$field_tmp_id?>").html('');
                        $("#err<?=$field_tmp_id?>").html('');
                        eval(<?=$this->success_f?>);

                        <?if ($this->crop_w>0) { ?>

                            var img = new Image();
                            img.onload = function () {
                                $('#crop_image<?=$field_tmp_id?>').attr('src', url_n);
                                $('#crop_canvas<?=$field_tmp_id?>').attr('fname',data.filename)

                                var crop_w = <?=$this->crop_w?>;
                                var crop_h = <?=$this->crop_h?>;
                                var coeff_i = this.width / this.height;

                                var minCropBoxHeight = 0;
                                var minCropBoxWidth = 0;

                                if(this.width>this.height){
                                    minCropBoxWidth = crop_w/(this.width/crop_w);
                                    minCropBoxHeight = crop_h/(crop_w/minCropBoxWidth)
                                }
                                else{
                                    minCropBoxHeight = crop_h/(this.height/crop_h);
                                    minCropBoxWidth = crop_w/(crop_h/minCropBoxHeight);
                                }

                                $('#crop_canvas<?=$field_tmp_id?>').css('height', crop_h);
                                $('#crop_canvas<?=$field_tmp_id?>').css('width', crop_w);

                                if (cropper) cropper.destroy();
                                var image = document.getElementById('crop_image<?=$field_tmp_id?>');
                                cropper = new Cropper(image, {
                                    aspectRatio:(crop_w/crop_h),
                                    minCropBoxHeight:minCropBoxHeight,
                                    minCropBoxWidth:minCropBoxWidth,
                                    zoomOnWheel:false,
                                    //cropBoxResizable:false,
                                    ready:function () {}
                                });
                                $('#crop_dialog<?=$field_tmp_id?>').dialog('open');
                            }
                            img.src = url_n;
                        <? }?>
                    }
                    $("#auf_loading<?=$field_tmp_id?>").hide();
                }
            })
        }

        function cropper_aplly(){
            var getCropBoxData = cropper.getCropBoxData();
            var getCanvasData = cropper.getCanvasData();
            $.post(
                'cropper?fname='+$('#crop_canvas<?=$field_tmp_id?>').attr('fname'),
                    {crb_l:getCropBoxData.left,crb_t:getCropBoxData.top,
                     crb_w:getCropBoxData.width,crb_h:getCropBoxData.height,
                     img_l:getCanvasData.left,img_t:getCanvasData.top,
                     img_w:getCanvasData.width,img_h:getCanvasData.height,
                     img_wn:getCanvasData.naturalWidth,img_hn:getCanvasData.naturalHeight,
                     crop_w:<?=$this->crop_w?>,crop_h:<?=$this->crop_h?>
                    },
                function(data){
                    //alert(data)
                    $('#<?= '' . $field_tmp_id ?>').val(data);
                    $('#<?=$field_tmp_id . '_block'?>').attr('src', data);
                    $('#crop_dialog<?=$field_tmp_id?>').dialog('close');
                }
            )
            console.log(cropper.getCropBoxData())
            console.log(cropper.getCanvasData())
        }
    </script>

    <?
    }
}