<?php

class AdminCP extends CWidget
{
    public $mod_title;
    public $mod_act_title;
    public $item_name = 'item';
    public $buttons = array();
    public $non_cp_ajax = 1;

    public function run()
    {
        $unique = time();
        if (!Yii::app()->user->isGuest) {
        ?>

        <script>$(document).ready(function () {
            $().stickyScroll({ mark:'#mod_panel2<?=$unique?>', decor_class:'mod_panel2_decor' });  });
        </script>

        <div style="height: 40px; margin-bottom:10px; border: 0px solid">
            <div id="mod_panel2<?=$unique?>" class="mod_panel2" style="background: #EBEBEB; ">
                <div class="fl mod_title" id="mod_title"><?=$this->mod_title?></div>
                <img src="<?=LOAD_ICO?>" id="act_loading1" class="fl" style="margin-left: 5px; display: none;">
                <div class="fl mod_title" id="mod_act_title"><?=$this->mod_act_title?></div>

                <? if(Yii::app()->user->hasFlash('mod-msg'))
                    Yii::app()->clientScript->registerScript('',
                        'showModMsg("'.Yii::app()->user->getFlash('mod-msg').'");'
                    );   ?>

                <div id="m_acts" class="adm_act_menu" align="right" style="border: 0px solid; white-space: nowrap;">


                    <script type="text/javascript">non_cp_ajax=<?=$this->non_cp_ajax?></script>

                    <ul>
                        <? foreach($this->buttons as $button){?>
                            <?if($button=='create'){?>
                                <li>
                                    <? $params = isset($_GET['cat_id']) ? array('cat_id'=>$_GET['cat_id']) : array();?>
                                    <a href="<?=$this->controller->createUrl('create',$params)?>" onclick="
                                        if(non_cp_ajax) return true;
                                        ajax_load(this);
                                        return false;
                                    ">Создать</a>
                                </li>
                            <?}?>

                            <?if($button=='save_close'){?>
                                <li>
                                    <a href="#" onclick="
                                        if(non_cp_ajax){
                                            $('#redirect').val('list');
                                            $('#<?=$this->item_name?>-form').submit();
                                        }
                                        else{
                                            $('.elrte').elrte('updateSource');
                                            ajax_save(
                                                '<?=Y::app()->request->requestUri?>',
                                                $('#<?=$this->item_name?>-form').serialize(),
                                                function(){
                                                    if($('#ajax_content .error').length == 0)
                                                        ajax_close('<?=$this->item_name?>-grid');
                                                }
                                            );
                                        }
                                        return false;
                                    ">Сохр. и закр.</a>
                                </li>
                            <?}?>

                            <?if($button=='save'){?>
                                <li>
                                    <a href="#" onclick="
                                        if(non_cp_ajax){
                                            $('#redirect').val('update');
                                            $('#<?=$this->item_name?>-form').submit();
                                        }
                                        else{
                                            $('.elrte').elrte('updateSource');
                                            ajax_save(
                                                '<?=Y::app()->request->requestUri?>',
                                                $('#<?=$this->item_name?>-form').serialize()
                                            );
                                        }
                                        return false;
                                    ">Сохранить</a>
                                </li>
                            <?}?>

                            <?if($button=='close'){?>
                                <li>
                                    <a href="<?=$this->controller->createUrl('list',array('loadGSP' => 1))?>" onclick="
                                        if(non_cp_ajax) return true;
                                        ajax_close('<?=$this->item_name?>-grid');
                                        return false;
                                    ">Закрыть</a>
                                </li>
                            <?}?>

                            <?if($button=='delete'){?>
                                <li>
                                    <a href="<?=$this->controller->createUrl('deleteSelected')?>"
                                       id="deleteSelected">Удалить</a>
                                </li>
                            <?}?>

                            <?if( is_array($button) ){?>
                                <li>
                                    <a href="<?=$this->controller->createUrl($button['url'])?>" >
                                       <?=$button['title']?></a>
                                </li>
                            <?}?>

                        <?}?>
                    </ul>

                    <? // old menu
                    $this->controller->widget('zii.widgets.CMenu', array(
                        'items' => $this->controller->menu,
                    ));
                    ?>

                </div>
                <div class="fc"></div>
            </div>
        </div>

        <?
        }
    }
}