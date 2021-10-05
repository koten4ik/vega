<?php

/*
$this->beginWidget('VegaDialog', array('id'=>'_dialog','title'=>'Диалог'));
    ...
$this->endWidget('VegaDialog');
*/

class VegaDialog extends CWidget
{
    public $id;
    public $title = 'Диалог';
    public $autoOpen = false;
    public $modal = true;
    public $max_width = 680;
    public $height = 0;

    public function init()
    {
        ?>
        <div class="vega_dialog" id="<?=$this->id?>" style="display:<?=$this->autoOpen ? 'flex' : 'none'?>;">
            <div class="vega_dialog_wrap" style="max-width:<?=$this->max_width?>px;">
                <div class="vega_dialog_header">
                    <div class="vega_dialog_title"><?=$this->title?></div>
                    <div class="vega_dialog_close"></div><?/*для работы закрития - соблюдение вложенности тегов*/?>
                </div>
                <div class="vega_dialog_content"
                     style="<?= ($this->height>0 ? 'height:'.$this->height.'px':'')?>">
        <?
    }

    public function run()
    {
        echo '       </div>
                </div>
            </div>';
    }
}