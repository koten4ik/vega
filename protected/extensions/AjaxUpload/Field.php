<?php
/*
 * добавить удаление
 * добавить токен
 * */

/* AjaxUploadField */
class Field extends CWidget
{
    public $dir = '/content/upload/temp/';
    public $name;
    public $value;
    public $type = array();
    public static $_cnt = 0;
    public static $cnt = 0;

    public function run()
    {

        //todo переехали в  FieldFile !

        /*self::$cnt = time() + self::$_cnt++;
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/vegaUploader.js', CClientScript::POS_HEAD);
        $dir_a = $this->dir[0] == '/' ? substr($this->dir,1) : $this->dir;
        $url = '/admin';
        $url .= $this->controller->module->id ? '/'.$this->controller->module->id : '';
        $url .= '/'.$this->controller->id.'/ajaxUpload?dir='.$dir_a.'&fnum='.self::$cnt;*/
        ?>
        <script type="text/javascript">
            /*function ajaxFileUpload<?=self::$cnt?>(){
                    $().vegaUploader({
                        url: '<?=$url?>',
                        field_name:'qqfile<?=self::$cnt?>',
                        error_text:'#auf_error<?=self::$cnt?>',
                        upl_butt:'#auf_button<?=self::$cnt?>',
                        upload_file:'#auf_file<?=self::$cnt?>',
                        allowed_files:'<?=implode(',',$this->type)?>'.split(','),
                        start:function(data){
                            $("#auf_error<?=self::$cnt?>").html('');
                            $("#auf_loading<?=self::$cnt?>").show();
                        },
                        success:function(data){
                            if(typeof(data.error) != 'undefined')
                            {
                                $("#auf_error<?=self::$cnt?>").html(data.error);
                            }
                            else
                            {
                                $("#auf_field<?=self::$cnt?>").val(data.filename);
                                $("#auf_complete<?=self::$cnt?>").attr('href', '<?=$this->dir?>'+data.filename);
                                $("#auf_complete<?=self::$cnt?>").text(data.filename);
                                $("#auf_complete<?=self::$cnt?>").show();
                                $("#auf_none<?=self::$cnt?>").hide();
                            }
                            $("#auf_loading<?=self::$cnt?>").hide();
                        }
                    })
                }*/
    	</script>
        <!--div style="margin: 3px 0px; vertical-align: middle; display: inline-block;">
            <span id="auf_none<?=self::$cnt?>" style="display: <?= $this->value ? 'none':'inline' ?>; vertical-align: top">
                <?=Y::t('не выбрано')?>
            </span>
            <a id="auf_complete<?=self::$cnt?>" href="<?=$this->dir.$this->value?>" target="_blank"
                style="vertical-align:0px; max-width:120px; overflow:hidden; white-space: nowrap; display: inline-block;">
                <?=$this->value?>
            </a>
            <input type="hidden" id="auf_field<?=self::$cnt?>" name="<?=$this->name?>" value="<?=$this->value?>">

            <span onclick="ajaxFileUpload<?=self::$cnt?>()" id="auf_button<?=self::$cnt?>"
                 style="position: relative; overflow: hidden;  direction: ltr; margin-left: 10px; cursor: pointer !important; display: inline-block; text-decoration: underline;">
                Обзор...
                <input type="file" name="qqfile<?=self::$cnt?>" id="auf_file<?=self::$cnt?>"
                       style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer !important; opacity: 0;">
            </span>

            <img id="auf_loading<?=self::$cnt?>" style="margin-left:5px; display:none;" src="<?=LOAD_ICO?>" />
            <div id="auf_error<?=self::$cnt?>" style="color: red; margin: 0px 0px;" ></div>
        </div-->
        <?
    }


}