<?php

class ActiveForm extends CActiveForm
{
    public static $lable_w = 195;
    public static $field_w = 400;
    public static $field_w_w = 740;
    public static $inl = 1;
    public static $no_help = 1;

    public function init()
    {
        parent::init();

    }

    /**
     * @param CModel $model the data model
     * @param string $attribute the attribute
     * @param array $options additional options
     * @return string the generated hidden input field for file name and ajaxUpload button.
     */
    public function ajaxUploadField($model, $attribute, $options = array())
    {
        $options['name'] = CHtml::resolveName($model,$attribute);
        $options['value'] = $model->$attribute;
        return $this->widget('ext.AjaxUpload.Field', $options,true);
    }

    /*
    <div class="row">
        <? echo $form->labelEx($model,'field', array('style'=>'width:100px')); ?>
        <? echo $form->textField($model,'field',array('style'=>'width:400px','maxlength'=>255)); ?>
        <? echo $form->error($model,'field'); ?>
    </div>
    */
    // $form->textFieldW($model,'field',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 ));
    public function textFieldW($model, $field, $options = array())
    {
        $langs = ($options['ml_lng'] && Y::params('multiLang')) ? array('','_l2') : array('');
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        //if($options['inl']) $options['wrap_class'] .= ' ib';
        //if($options['inl']) // заменено на <br> !
            $l_style .= 'display:inline-block; ';
        if($options['l_w'] && $options['inl']) $l_style .= 'width:'.$options['l_w'].'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.$options['f_w'].'px; ';
        $options['maxlength'] = 255;
        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
        foreach($langs as $key=>$lng){
            if($key>0) $rezult .= '<br>';
            $hlp_data = $options['no_help'] ? '' :
                Y::helperField( ( $options['help_unique']===0 ? '' : get_class($model).'_' ) .$field.'_hlp');
            $rezult .= $this->labelEx($model,$field.$lng, array('style'=>$l_style));
            if(!$options['inl']) $rezult .= $hlp_data.'<br>';
            $rezult .= $this->textField($model,$field.$lng,$options);
            if($options['inl']) $rezult .= $hlp_data;
            $rezult .= $this->error($model,$field.$lng);
        }
        $rezult .= '</div>';
        return $rezult;
    }

        // $form->passwordFieldW($model,'field',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'ml_lng'=>1 ));
    public function passwordFieldW($model, $field, $options = array())
    {
        $langs = ($options['ml_lng'] && Y::params('multiLang')) ? array('', '_l2') : array('');
        $l_style = '';
        if (!$options['l_w']) $options['l_w'] = self::$lable_w;
        if (!$options['f_w']) $options['f_w'] = self::$field_w;
        if (!isset($options['inl'])) $options['inl'] = self::$inl;
        if (!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        //if($options['inl']) $options['wrap_class'] .= ' ib';
        //if($options['inl']) // заменено на <br> !
        $l_style .= 'display:inline-block; ';
        if ($options['l_w'] && $options['inl']) $l_style .= 'width:' . $options['l_w'] . 'px; ';
        if ($options['f_w']) $options['style'] .= ';width:' . $options['f_w'] . 'px; ';
        $options['maxlength'] = 255;
        $rezult = '<div class="row ' . $options['wrap_class'] . '" style="' . $options['wrap_style'] . '">';
        foreach ($langs as $key => $lng) {
            if ($key > 0) $rezult .= '<br>';
            $hlp_data = $options['no_help'] ? '' :
                Y::helperField(($options['help_unique'] === 0 ? '' : get_class($model) . '_') . $field . '_hlp');
            if (!$options['no_label'])
            $rezult .= $this->labelEx($model, $field . $lng, array('style' => $l_style));
            if (!$options['inl']) $rezult .= $hlp_data . '<br>';
            $rezult .= $this->passwordField($model, $field . $lng, $options);
            if ($options['inl']) $rezult .= $hlp_data;
            $rezult .= $this->error($model, $field . $lng);
        }
        $rezult .= '</div>';
        return $rezult;
    }

    /*
    <div class="row">
        <? echo $form->labelEx($model, 'field', array('style'=>'margin-bottom:6px')); ?>
        <? echo $form->textArea($model, 'field'.$lng,  array('class' => 'elrte'))?>
        <? echo $form->error($model, 'field'.$lng); ?>
    </div>
    */
    // $form->textAreaW($model,'field',array( 'ml_lng'=>1, 'no_editor'=>0 ));
    // нужно подключение ckeditor.js, в админке есть везде
    public function textAreaW($model, $field, $options = array())
    {
        $langs = ($options['ml_lng'] && Y::params('multiLang')) ? array('','_l2') : array('');
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';
        if(!isset($options['id'])) $options['id'] = 'cke_'.$field;

        //if($options['inl']) // заменено на <br> !
            $l_style .= 'display:inline-block; ';
        if($options['l_w'] && $options['inl']) $l_style .= 'width:'.$options['l_w'].'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.$options['f_w'].'px; ';
        else $options['style'] .= ';width:98%; ';
        if($options['f_h']){
            $options['style'] .= ';height:'.$options['f_h'].'px; ';
            $options['wrap_style'] .= ';min-height:'.$options['f_h'].'px; ';
        }
        //if($options['no_editor']) $options['style'] .= 'margin-top:0px; ';
        //else $options['class'] .= $options['elrte_class'] ? $options['elrte_class'] : ' elrte';
        $rezult = '<div class="row textarea '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';

        $tabs = array();
        foreach ($langs as $key => $lng)
        {
            $options['id'] = 'cke_' . $field . $lng;
            $tabs[$this->labelEx($model, $field . $lng, array('style' => $l_style))] =
                $this->textArea($model, $field . $lng, $options);
            if(!$options['no_editor'])
                $this->controller->registerScript(
                    "CKEDITOR.replace( 'cke_" . $field . $lng . "', {"
                        . Y::ckeOpts(array('height' => $options['f_h'], 'short'=>$options['short'])) . "} );"
                    , CClientScript::POS_END);
        }

        if(!$options['no_tab'])
            $rezult .=  $this->widget('JuiTabs', array( 'id'=>'item-tabs-'.$field, 'class'=>'field_tabs', 'tabs'=>$tabs,
                        'options'=>array( 'disable'=>true  ) ), true);
        else{
            $hlp_data = $options['no_help'] ? '' :
                Y::helperField( ( $options['help_unique']===0 ? '' : get_class($model).'_' ).$field.'_hlp');
            $rezult .= $this->labelEx($model,$field, array('style'=>$l_style));
            if(!$options['inl']) $rezult .= $hlp_data.'<br>';
            $rezult .= '<div class="ib" style="width:'.$options['f_w'].'px;">'.$this->textArea($model,$field,$options).'</div>';
            if($options['inl']) $rezult .= $hlp_data;
        }

        foreach($langs as $key=>$lng)
            $rezult .= $this->error($model,$field.$lng);


        $rezult .= '</div>';
        return $rezult;
    }

    // $form->textAreaTabsW($model,array('field1','field2'),array());
    // нужно подключение ckeditor.js, в админке есть везде
    public function textAreaTabsW($model, $fields, $options = array())
    {
        if(!$options['f_h']) $options['f_h'] = 400;
        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
        //if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        //$rezult .= $options['no_help'] ? '' :  Y::helperField(get_class($model).'_'.$field_full.'_hlp');
        $tabs = array();  $errors = '';  $js = '';
        foreach($fields as $field)
        {
            $tabs[ $this->labelEx($model, $field) ] =
                $this->textArea($model, $field, array('id' => 'cke_'.$field));
            $errors .= $this->error($model,$field);
            $js .= "CKEDITOR.replace( 'cke_".$field."', {". Y::ckeOpts(array('height' => $options['f_h'])) ."} );";
        }

        $rezult .= $this->widget('JuiTabs', array('id' => 'item-tabs-' . implode('_',$fields),
            'class' => 'field_tabs', 'tabs' => $tabs, 'options' => array() ),true);
        $rezult .= $errors;
        $this->controller->registerScript($js, CClientScript::POS_END);

        $rezult .= '</div>';

        return $rezult;
    }

    public function textAreaWold($model, $field, $options = array())
        {
            $langs = ($options['ml_lng'] && Y::params('multiLang')) ? array('','_l2') : array('');
            $l_style = '';
            if(!$options['id']) $options['id'] = $field;
            if($options['inl']) $l_style .= 'display:inline-block; ';
            if($options['l_w']) $l_style .= 'width:'.$options['l_w'].'px; ';
            if($options['f_w']) $options['style'] .= ';width:'.$options['f_w'].'px; ';
            else $options['style'] .= ';width:100%; ';
            if($options['f_h']) $options['style'] .= ';height:'.$options['f_h'].'px; ';
            if($options['no_editor']) $options['style'] .= 'margin-top:0px; ';
            else $options['class'] .= $options['elrte_class'] ? $options['elrte_class'] : ' elrte';
            $rezult = '<div class="row textarea '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';

            $tabs = array();
            foreach($langs as $key=>$lng)
                $tabs[  $this->labelEx($model,$field.$lng, array('style'=>$l_style)) ] =
                    $this->textArea($model,$field.$lng,$options);

            if(!$options['no_tab'])
                $rezult .=  $this->widget('JuiTabs', array( 'id'=>'item-tabs-'.$field, 'class'=>'field_tabs', 'tabs'=>$tabs,
                            'options'=>array( 'disable'=>true  ) ), true);
            else $rezult .= $this->labelEx($model,$field, array('style'=>$l_style))
                            .$this->textArea($model,$field,$options);

            foreach($langs as $key=>$lng)
                $rezult .= $this->error($model,$field.$lng);

            $rezult .= '</div>';
            return $rezult;
        }
    /*
    <div class="row" style="" >
        <?php echo $form->checkBox($model,'field'); ?>
        <?php echo $form->labelEx($model,'field', array('class'=>'after_cbox')); ?>
        <?php echo $form->error($model,'field'); ?>
    </div>
    */
    // $form->checkBoxW($model,'field',array( 'ml_lng'=>1 ));
    public function checkBoxW($model, $field, $options = array())
    {
        $langs = ($options['ml_lng'] && Y::params('multiLang')) ? array('','_l2') : array('');
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
        foreach($langs as $key=>$lng){
            if($key>0) $rezult .= '<br>';
            $rezult .= $this->checkBox($model,$field.$lng, $options);
            $rezult .= $this->labelEx($model,$field.$lng, array('class'=>'after_cbox'));
            if(!$options['no_help'])
                $rezult .= Y::helperField(
                    ( $options['help_unique']===0 ? '' : get_class($model).'_' ) .$field.'_hlp',
                    $options['show_hlp']?1:0);
            $rezult .= $this->error($model,$field.$lng);
        }
        $rezult .= '</div>';

        return $rezult;
    }

    /*
    <div class="row">
        <? echo $form->labelEx($model,'field', array('style'=>'display:inline-block; width:100px')); ?>
        <? echo $form->dropDownList($model,'field', Model::getList()), array('style'=>'width:402px')); ?>
        <? echo $form->error($model,'field'); ?>
    </div>
    */
    // $form->selectFieldW($model,'field',$data,array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 ));
    public function selectFieldW($model, $field, $data, $options = array())
    {
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.$options['l_w'].'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.($options['f_w']+2).'px; ';

        $null_data = isset($options['null_data']) ? $options['null_data'] : 0;
        if (!$options['no_null']) $data = CMap::mergeArray(array($null_data => ''), $data);
        // если убать 0 то инту будут ругаться !!

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
            $rezult .= $this->labelEx($model,$field, array('style'=>$l_style));
            $rezult .= $this->dropDownList($model,$field,$data,$options);
            if(!$options['no_help']) $rezult .= Y::helperField(get_class($model).'_'.$field.'_hlp');
            $rezult .= $this->error($model,$field);
        $rezult .= '</div>';

        return $rezult;
    }

    /*
    <div class="row">
        <?php echo $form->labelEx($model, 'time', array('style' => 'width:110px')); ?>
        <?php $this->widget('FieldTime', array('field' => 'time', 'model' => $model ))?>
        <?php echo $form->error($model, 'time'); ?>
    </div>
    */
    // $form->timeFieldW($model,'field',array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1, 'format'=>'d-m-Y' ));
    public function timeFieldW($model, $field, $options = array())
    {
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.($options['l_w']-3).'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.$options['f_w'].'px; ';
        //$options['style'] .= 'text-align:center; ';
        if(!$options['format']) $options['format'] = 'd-m-Y';
        if(!$options['no_time']) $options['no_time'] = false;

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
            $rezult .= $this->labelEx($model,$field, array('style'=>$l_style));
            $rezult .= $this->widget('FieldTime', array('style' => $options['style'], 'disabled' => $options['disabled'],
                'field' => $field, 'model' => $model, 'format'=>$options['format'], 'no_time'=>$options['no_time'] ), true);
            if(!$options['no_help']) $rezult .= Y::helperField(get_class($model).'_'.$field.'_hlp');
            $rezult .= $this->error($model,$field);
        $rezult .= '</div>';

        return $rezult;
    }

    /*
    <div class="row">
        <? $this->widget('FieldFile',   array('field'=>'file', 'tmb_num'=>1, 'form'=>$form,'model'=>$model))?>
    </div>
    */
    // $form->fileFieldW($model,'field',array( 'tmb'=>1, 'img_w'=>250 ));
    public function fileFieldW($model, $field, $options = array())
    {
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';

        if(!isset($options['no_help'])) $options['no_help'] = 1;
        $rezult .= $options['no_help'] ? '' :
            Y::helperField( ( $options['help_unique']===0 ? '' : get_class($model).'_' ).$field.'_hlp');
        $f_opts =  array( 'form'=>$this, 'field' => $field, 'model' => $model, 'tmb_num'=>$options['tmb'] );
        if ($options['crop_w']) $f_opts['crop_w'] = $options['crop_w'];
        if ($options['crop_h']) $f_opts['crop_h'] = $options['crop_h'];
        if($options['img_w']) $f_opts['img_w'] = $options['img_w'];
        $rezult .= $this->widget('FieldFile',$f_opts, true);

        $rezult .= '</div>';

        return $rezult;
    }

    /*
    <div class="row">
        <?php echo $form->labelEx($model,'rel_id', array('style'=>'')); ?>
        <? $this->widget('FieldRelation', array('form'=>$form, 'model'=>$model, 'style'=>'',
            'field'=>'rel_id', 'relModel'=>'relModelName', 'title'=>$model->relation->title))?>
        <? echo $form->error($model,'rel_id'); ?>
    </div>
    */
    // $form->relationFieldW($model,'rel_id','relModel',$model->relation->title,
    //      array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 ));
    public function relationFieldW($model, $field, $relModel, $relTitle, $options = array())
    {
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w-14;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.$options['l_w'].'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.($options['f_w']+2).'px; ';

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
            $rezult .= $this->labelEx($model,$field, array('style'=>$l_style));
            $rezult .=  $this->widget('FieldRelation', array('form'=>$this, 'model'=>$model, 'style'=>$options['style'],
                'field'=>$field, 'relModel'=>$relModel, 'relGridField'=>$options['relGridField'], 'title'=>$relTitle), true);
            $rezult .= $this->error($model,$field);
        $rezult .= '</div>';

        return $rezult;
    }

        /*
    <div class="row" style="height: 25px">
        <?php echo $form->labelEx($model,'cat_id', array('style'=>'display:inline-block;')); ?>
        <? $this->widget('FieldCategory',array(
            'field'=>'cat_id','form'=>$form,'model'=>$model,'catModel'=>'ContentCategory'))?>
        <?php echo $form->error($model,'cat_id'); ?>
    </div>
    */
    // $form->categoryFieldW($model,'rel_id','relModel',
    //      array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 ));
    public function categoryFieldW($model, $field, $catModel, $options = array())
    {
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.($options['l_w']-3).'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.($options['f_w']+0).'px; ';

        $w_options = array(
            'form'=>$this, 'model'=>$model,
            'style'=>$options['style'],
            'field'=>$field, 'catModel'=>$catModel,
        );
        if($options['relation']) $w_options['relation'] = $options['relation'];
        if($options['title']) $w_options['title'] = $options['title'];
        if($options['root']) $w_options['root'] = $options['root'];
        if($options['indexing']) $w_options['indexing'] = $options['indexing'];

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
            $rezult .= $this->labelEx($model,$field, array('style'=>$l_style));
            $rezult .=  $this->widget('FieldCategory', $w_options, true);
            if(!$options['no_help']) $rezult .= Y::helperField(get_class($model).'_'.$field.'_hlp');
            $rezult .= $this->error($model,$field);
        $rezult .= '</div>';

        return $rezult;
    }

    // $form->categoryFieldW($model,'field','catModel',
    //      array( 'l_w'=>100, 'f_w'=>400, 'inl'=>1 ));
    public function categoryMultyFieldW($model, $field, $catModel, $options = array())
    {
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.($options['l_w']-3).'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.($options['f_w']+2).'px; ';

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';

        if(!$options['no_help']) $rezult .= Y::helperField(get_class($model).'_'.$field.'_hlp');

        $rezult .=  $this->widget('FieldCategoryM', array('form'=>$this, 'model'=>$model,
            'style'=>$options['style'], 'field'=>$field, 'catModel'=>$catModel, 'l_style'=>$l_style), true);

        $rezult .= '</div>';

        return $rezult;
    }

        // $form->categoryMultyField2W($model,'Category','CategoryRel', array( 'title'=>'Категории' ));
    public function categoryMultyField2W($model, $catModel, $catRelModel, $options = array())
    {
        if (!$options['title']) $options['title'] = 'Категории';
        $rezult = '<div class="row ib ' . $options['wrap_class'] . '" style="margin-right:8px; ' . $options['wrap_style'] . '">';
        $rezult .= $options['title'];
        $rezult .= '<div class="row" style="width: 268px; height:220px; overflow:scroll; padding:5px; border: 1px solid #aaa;  ">';

        if (!$model->isNewRecord)
            $an_cat = $catRelModel::model()->findAll('id_analit=' . $model->id);
        if (isset($an_cat))
            foreach ($an_cat as $elem) $an_cat_curr[$elem->{$catModel::f_name}] = 1;
        foreach ($catModel::model()->getListRaw() as $cat) {
            $rezult .= CHtml::checkBox($catModel . '[' . $cat->id . ']', isset($an_cat_curr[$cat->id]), array('id' => $catModel . '_' . $cat->id, 'value' => $cat->id)) .
                CHtml::label($cat->name_rus, $catModel . '_' . $cat->id, array('class' => 'after_cbox', 'style' => 'margin-right:0;')) . '<br>';
        }

        $rezult .= '</div>';
        $rezult .= '</div>';

        return $rezult;
    }

    // $form->categoryRadioFieldW($form, $model,'Category', array());
    public function categoryRadioFieldW($form, $model, $catModel, $options = array())
    {
        if (!$options['title']) $options['title'] = 'Категории';
        $rezult = '<div class="row ib ' . $options['wrap_class'] . '" style="margin-right:8px; ' . $options['wrap_style'] . '">';
        //$rezult .= $options['title'];
        $rezult .= $form->labelEx($model, 'cat_id', array('style' => ''));
        $rezult .= '<div class="row" style="width: 268px; height:220px; overflow:scroll; padding:5px; border: 1px solid #aaa;  ">';

        foreach ($catModel::model()->getListRaw() as $elem) {
            $rezult .= '<div class="">';
            $rezult .= $form->radioButton($model, 'cat_id', array('id' => 'cat_id_' . $elem->id, 'value' => $elem->id, 'uncheckValue' => null,)) .
                CHtml::label($elem->name_rus, 'cat_id_' . $elem->id, array('class' => 'after_cbox'));
            $rezult .= '</div>';
        }

        $rezult .= '</div>';
        $rezult .= $form->error($model, 'cat_id');
        $rezult .= '</div>';

        return $rezult;
    }

    // $form->locationMultiFieldW($model,$this->modelName,array( 'l_w'=>150, 'f_w'=>300, 'inl'=>1 ))
    public function locationMultiFieldW($model, $modelName, $options = array())
    {
        $l_style = 'vertical-align:-6px;';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if(!isset($options['no_help'])) $options['no_help'] = self::$no_help;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.($options['l_w']-3).'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.($options['f_w']+2).'px; ';

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';

        /*$required = '';
        foreach($model->rules() as $rule)
            if( $rule[0]=='country_id' && $rule[1]=='compare')
                $required = '&nbsp;<span class="required">*</span>';
        $rezult .=  CHtml::label(Y::t('Местоположение').$required,false,
                        array('style'=>$l_style,'class'=>$is_error ? 'error':''));
        */

        $is_error = isset($model->errors['country_id']) ? 1 : 0;

        $rezult .= $this->labelEx($model,'country_id', array('style'=>$l_style));

        $rezult .=  $this->widget('LocationMultiWidget', array(
            'label_style'=>'width:147px; display:inline-block', 'input_style'=>$options['style'],
            'id'=>'location_model','model_name'=>$modelName, 'is_error'=>$is_error,
            'fields'=>array( 'country_id'=>$model->country_id, 'oblast_id'=>$model->oblast_id,
                'raion_id'=>$model->raion_id, 'city_id'=>$model->city_id)
        ),true);

        if(!$options['no_help']) $rezult .= Y::helperField(get_class($model).'_'.'region'.'_hlp');
        $rezult .= $this->error($model,'country_id');

        $rezult .= '</div>';

        return $rezult;
    }

    public function privacyFlag($options=array())
    {
        $text = Y::t('согласие на обработку моих персональных данных');
        if($options['text']) $text = $options['text'];
        $rezult =
            '<div class="row privacy-flag inl" style="margin-bottom:10px; '. $options['wrap_style'] .'">
                <input type="checkbox" style="width:12px; margin:0;" id="privacy-'.$this->id.'"
                    name="privacy-'.$this->id.'"
                    '.( isset($_REQUEST['privacy-'.$this->id]) ? 'checked' : '' ).'
                    onchange="
                        if( $(this).is(\':checked\') )
                            $(\'#button-'.$this->id.'\').removeClass(\'disabled\');
                        else $(\'#button-'.$this->id.'\').addClass(\'disabled\');
                    ">
                <label class="after_cbox" for="privacy-'.$this->id.'"
                    style="font-weight:normal;font-size:75%; ">
                    '.$text.'
                </label>
            </div>';

        return $rezult;
    }

    public function submitButton($options=array())
    {
        if (!$options['text']) $options['text'] = 'Отправить';

        $rezult =
            '<button type="submit" class="button '.(( isset($_REQUEST['privacy-'.$this->id]) || $options['no_privacy'] ) ? '' : 'disabled' ).'"
                id="button-'.$this->id.'"
                onclick=" if( $(this).hasClass(\'disabled\') ) return false; '.$options['onclick'].'"
                style="'.$options['wrap_style'].'"
                >'.$options['text'].'</button>';

        return $rezult;
    }

    public function geoFieldW($model, $field, $options = array())
    {
        $l_style = '';
        if(!$options['l_w']) $options['l_w'] = self::$lable_w;
        if(!$options['f_w']) $options['f_w'] = self::$field_w;
        if(!isset($options['inl'])) $options['inl'] = self::$inl;
        if($options['inl']) $options['wrap_class'] .= ' ib';

        if($options['inl']) $l_style .= 'display:inline-block; ';
        if($options['l_w']) $l_style .= 'width:'.($options['l_w']-3).'px; ';
        if($options['f_w']) $options['style'] .= ';width:'.$options['f_w'].'px; ';
        //$options['style'] .= 'text-align:center; ';

        $rezult = '<div class="row '.$options['wrap_class'].'" style="'.$options['wrap_style'].'">';
            $rezult .= $this->labelEx($model,$field, array('style'=>$l_style));
            $rezult .= $this->widget('FieldGeo', array('style' => $options['style'], 'disabled' => $options['disabled'],
                'field' => $field, 'model' => $model ), true);
            if(!$options['no_help']) $rezult .= Y::helperField(get_class($model).'_'.$field.'_hlp');
            $rezult .= $this->error($model,$field);
        $rezult .= '</div>';

        return $rezult;
    }
}