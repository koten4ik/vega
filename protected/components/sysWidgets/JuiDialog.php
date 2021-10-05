<?php

/*
$this->beginWidget('JuiDialog', array('id'=>'_dialog','title'=>'Диалог'));
    ...
$this->endWidget('JuiDialog');
*/
Yii::import('zii.widgets.jui.CJuiDialog');

class JuiDialog extends CJuiDialog
{
    public $title;
    public $width = 'auto';
    public $height = 'auto';
    public $autoOpen;
    public function init()
    {
        if(!isset($this->options['title'])) $this->options['title'] = $this->title;
        if(($this->autoOpen)==true) $this->options['autoOpen'] = true;
        else $this->options['autoOpen'] = false;
        if(!isset($this->options['draggable'])) $this->options['draggable'] = false;
        if(!isset($this->options['resizable'])) $this->options['resizable'] = false;
        if(!isset($this->options['width'])) $this->options['width'] = $this->width;
        if(!isset($this->options['height'])) $this->options['height'] = $this->height;
        if(!isset($this->options['modal'])) $this->options['modal'] = true;
        if(!isset($this->options['dialogClass'])) $this->htmlOptions['class'] = 'dialogClass';
        parent::init();
    }
}