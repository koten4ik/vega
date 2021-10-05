<?php
/*
    <div class="row">
        <? $this->widget('FieldFileSingle', array('field'=>'fieldName', 'value'=>'value'))?>
    </div>
*/

/* todo удаление прошлого файла */
/* todo обзор по клику на картинке */

Yii::import('zii.widgets.CPortlet');

class FieldFileSingle extends CWidget
{
    public $value;
    public $type = 'image';
    public $path = '/content/upload/base/images/';
    public $field;
    public $img_w = 250;
    public $img_h = 250;
    public $success_f;
    public $label = '';
    public $local_allow = 1;
    public $server_allow = 0;
    public static $c = 0;
    public $max_size = 10;
    public $types = 'jpg,jpeg,png,gif,doc,docx,pdf,xls,xlsx,txt';

	public  function run()
	{
        self::$c++;
        $field_tmp_id = self::$c.'_tmp';
        ?>
        <? // ============= field ========= ?>
        <?php if($this->label) echo CHtml::label($this->label,'',array('style'=>'display:inline')); ?>
        <?php echo CHtml::hiddenField($this->field,$this->value,array('id'=>$field_tmp_id));?>

        <? // ============= from local ========= ?>

        <? if($this->local_allow){ ?>
            <?
            /*$assets = $_SERVER['DOCUMENT_ROOT'] . '\protected\extensions\AjaxUpload\assets';
            $baseUrl = Yii::app()->assetManager->publish($assets);
            Yii::app()->clientScript->registerScriptFile($baseUrl . '/vegaUploader.js', CClientScript::POS_HEAD);*/
            Yii::app()->clientScript->registerScriptFile(
                Y::app()->baseUrl . '/assets_static/js/vegaUploader.js', CClientScript::POS_HEAD);

            $dir_a = $this->path;
            $dir_a = $dir_a[0] == '/' ? substr($dir_a,1) : $dir_a;

            $url = Y::app()->baseUrl;
            $url .= Y::params('cfgName') == 'backend' ? '/'.BACKEND_NAME  : '';
            $url .= $this->controller->module->id ? '/'.$this->controller->module->id : '';
            $url .= '/'.$this->controller->id.'/ajaxupload?';
            $url .= 'dir='.$dir_a.'&fnum='.$field_tmp_id.'&maxSize='.$this->max_size
                    .'&types='.$this->types;
            ?>
            <script type="text/javascript">
                function ajaxFileUpload<?=$field_tmp_id?>(){
                        $().vegaUploader({
                            url: '<?=$url?>',
                            field_name:'<?=$field_tmp_id?>',
                            error_text:'#auf_error<?=$field_tmp_id?>',
                            upl_butt:'#auf_button<?=$field_tmp_id?>',
                            upload_file:'#auf_file<?=$field_tmp_id?>',

                            start:function(data){
                                $("#a_err<?=$field_tmp_id?>").html('');
                                $("#auf_loading<?=$field_tmp_id?>").show();
                            },
                            success:function(data){
                                if(typeof(data.error) != 'undefined')
                                {
                                    $("#a_err<?=$field_tmp_id?>").html(data.error);
                                }
                                else
                                {
                                    var url_n = '<?=Y::app()->baseUrl?>/<?=$dir_a?>'+data.filename;

                                    $('#<?= ''.$field_tmp_id ?>').val(url_n);

                                    $('#<?=$field_tmp_id.'_block'?>').attr('src', url_n);

                                    $('#<?= $field_tmp_id.'_block_f' ?> a').text(data.filename);
                                    $('#<?= $field_tmp_id.'_block_f' ?> a').attr('href', url_n);
                                    $('#<?= ''.$field_tmp_id ?>').trigger('change');
                                    $("#a_err<?=$field_tmp_id?>").html('');
                                    $("#err<?=$field_tmp_id?>").html('');
                                    eval(<?=$this->success_f?>);
                                }
                                $("#auf_loading<?=$field_tmp_id?>").hide();
                            }
                        })
                    }
            </script>

            <span title="" onclick="ajaxFileUpload<?=$field_tmp_id?>()" id="auf_button<?=$field_tmp_id?>"
                 style="position: relative; overflow: hidden;  direction: ltr; margin-bottom: 0px;
                        margin-left: 3px; cursor: pointer !important; display: inline-block;
                         text-decoration: underline; vertical-align: -5px;">
                <?= $this->server_allow ? 'комп' : 'обзор' ?>
                <input type="file" name="<?=$field_tmp_id?>" id="auf_file<?=$field_tmp_id?>"
                       style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer !important; opacity: 0;">
            </span>
            <!--a href="#" title="Выбрать фото" onclick="$('#<?= $field_tmp_id ?>').trigger('click'); return false">
                <?= $this->server_allow ? 'комп' : 'обзор' ?>
            </a-->
            <img id="auf_loading<?=$field_tmp_id?>" style="margin-left:5px; display:none;" src="<?=LOAD_ICO?>" />
            <span id="auf_error<?=$field_tmp_id?>" style="color: red; margin: 0px 0px;" ></span>

        <? } ?>



        <? // ============= cleared ========= ?>
        &nbsp;|&nbsp;
        <a href="#" title="Очистить" onclick="
            if(!confirm('Очистить ?')) return false;
            $('#<?= ''.$field_tmp_id ?>').val('');
            $('#<?= ''.$field_tmp_id ?>').trigger('change');
            $('#<?=$field_tmp_id.'_block'?>').attr('src','<? echo Controller::noImg; ?>');
            $('#<?=$field_tmp_id.'_block_f'?>').html('<a><?=Y::t('Файл не выбран',0)?></a>');
            return false;
        ">x</a>

        <? // ============= display data ========= ?>
        <br>
        <? $file_url = Y::app()->baseUrl.$this->value;
           $tmp_f_name = explode('/', $file_url);

        if($this->type == 'image') { ?>
            <img src="<?=$this->value ? $file_url : Controller::noImg ?>" id="<?=$field_tmp_id.'_block'?>"
                 style="max-width: <?=$this->img_w?>px; max-height: <?=$this->img_h?>px; border: 1px solid #bbb; margin-top: 5px">
        <? } else { ?>
            <span id="<?=$field_tmp_id.'_block_f'?>" class="ib" style="margin: 4px 0px;">
                <?if( $this->value ) {?>
                    <a href="<?= $file_url ?>" target="_blank" >
                        <? echo $tmp_f_name[count($tmp_f_name)-1]; ?>
                    </a>
                <? } else { ?>
                    <a><?=Y::t('Файл не выбран')?></a>
                <? } ?>
            </span>
        <? } ?>

        <div id="a_err<?=$field_tmp_id?>" style="color: red; margin: 0px 0px;" ></div>

    <?
	}
}