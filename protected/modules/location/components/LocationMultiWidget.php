<?php
/*
в фильтре
$this->widget('LocationMultiWidget', array('fields'=>array(
        'gc'=>$_GET['gc'], 'go'=>$_GET['go'], 'gr'=>$_GET['gr'], 'gp'=>$_GET['gp']
)));
в модели
$this->widget('LocationMultiWidget', array('id'=>'location_model','model_name'=>$this->modelName,
        'fields'=>array( 'country_id'=>$model->country_id, 'oblast_id'=>$model->oblast_id,
            'raion_id'=>$model->raion_id, 'city_id'=>$model->city_id
)));
*/

class LocationMultiWidget extends CWidget
{

    public static $selMsg = array();

    public $country_sel;
    public $obl_sel;
    public $rn_sel;
    public $city_sel;

    public $country_val;
    public $obl_val;
    public $rn_val;
    public $city_val;

    public $country_title;
    public $obl_title;
    public $rn_title;
    public $city_title;

    public $model_name;
    public $fields;

    public $label_style;
    public $input_style;

    public static function getMsg(){
        return array(
            0=>array(
                'country' => Y::t('-все страны-',0),
                'obl' => Y::t('-все области-',0),
                'rn' => Y::t('-все районы-',0),
                'city' => Y::t('-все нас. пункты-',0)
            ),
            1=>array(
                'country' => Y::t('-выберите страну-',0),
                'obl' => Y::t('-выберите область-',0),
                'rn' => Y::t('-выберите район-',0),
                'city' => Y::t('-выберите нас. пункт-',0)
            )
        );
    }
    public function run()
    {
        $func_sfx = '_' . $this->id;

        $cnt=0;
        $_fields = array('country','obl','rn','city');
        foreach($this->fields as $field=>$value)
        {
            if(!is_string($field)) continue;
            $f_name = $this->model_name ? $this->model_name.'['.$field.']' : $field;
            $this->{$_fields[$cnt].'_sel'} = $f_name;
            $this->{$_fields[$cnt].'_val'} = $value;
            $cnt++;
        }

        $this->country_title = Y::t('Страна');
        $this->obl_title = Y::t('Область');
        $this->rn_title = Y::t('Район');
        $this->city_title = Y::t('Нас. пункт');

        if ($this->country_sel)
            echo CHtml::hiddenField($this->country_sel,$this->country_val,array('id'=>'country_f'.$func_sfx));
        if ($this->obl_sel)
            echo CHtml::hiddenField($this->obl_sel,$this->obl_val, array('id'=>'obl_f'.$func_sfx));
        if ($this->rn_sel)
            echo CHtml::hiddenField($this->rn_sel,$this->rn_val, array('id'=>'rn_f'.$func_sfx));
        if ($this->city_sel)
            echo CHtml::hiddenField($this->city_sel,$this->city_val, array('id'=>'city_f'.$func_sfx));

        $empty_text = $this->model_name ? '' : Y::t('все регионы',0);
        $start_text = $empty_text;
        if($this->country_val>0) $start_text = LocationCountry::byPK($this->country_val)->title;
        if($this->obl_val>0) $start_text = LocationOblast::byPK($this->obl_val)->title;
        if($this->rn_val>0) $start_text = LocationRaion::byPK($this->rn_val)->title;
        if($this->city_val>0) $start_text = LocationCity::byPK($this->city_val)->title;

        self::$selMsg = self::getMsg();
        if($this->model_name){
            $type = 1;
        }
        else{
            $type = 0;
        }
        ?>
        <div id="<?=$this->id?>" class="ib">

            <??>
            <div class="ib" style="">
                <input class="simpleDialogButton" sdtarget_id="loc_block_<?=$func_sfx?>" id="loc_text_f<?=$func_sfx?>"
                       type="text" style="margin-bottom: 0px; <?=$this->input_style?>" autocomplete="off"
                    value="<?=$start_text?>">

                <div id="loc_block_<?=$func_sfx?>" class="simpleDialog">
                    <? if ($this->country_sel) { ?>
                        <div class="loc_widget_block country_sel">
                            <span class="loc_widget_title"><?=$this->country_title?></span>
                            <?=CHtml::dropDownList('country_sel'.$func_sfx, $this->country_val,
                            CMap::mergeArray(array('' => self::$selMsg[$type]['country']), LocationCountry::getList()),
                            array('onchange' => 'countryOnChange' . $func_sfx . '(this.value)')); ?>
                        </div>
                    <? } ?>
                    <? if ($this->obl_sel) { ?>
                        <div class="loc_widget_block obl_sel" style="display: none;">
                            <span class="loc_widget_title"><?=$this->obl_title?></span>
                            <?=CHtml::dropDownList('obl_sel'.$func_sfx, $this->obl_val,
                            $this->country_val ?
                            CMap::mergeArray(array('' => self::$selMsg[$type]['obl']), LocationOblast::getList($this->country_val)) : array(),
                            array('onchange' => 'oblastOnChange' . $func_sfx . '(this.value)')); ?>
                        </div>
                    <? } ?>
                    <? if ($this->rn_sel) { ?>
                        <div class="loc_widget_block rn_sel" style="display: none;">
                            <span class="loc_widget_title"><?=$this->rn_title?></span>
                            <?=CHtml::dropDownList('rn_sel'.$func_sfx, $this->rn_val,
                            $this->obl_val ?
                            CMap::mergeArray(array('' => self::$selMsg[$type]['rn']), LocationRaion::getList($this->obl_val)) : array(),
                            array('onchange' => 'raionOnChange' . $func_sfx . '(this.value)')); ?>
                        </div>
                    <? } ?>
                    <? if ($this->city_sel) { ?>
                        <div class="loc_widget_block city_sel" style="display: none;">
                            <span class="loc_widget_title"><?=$this->city_title?></span>
                            <?=CHtml::dropDownList('city_sel'.$func_sfx, $this->city_val,
                                $this->rn_val ?
                                CMap::mergeArray(array('' => self::$selMsg[$type]['city']), LocationCity::getList($this->rn_val)): array()
                            ); ?>
                        </div>
                    <? } ?>

                    <div style="margin-top: 5px;">
                        <!--a href="#" class="fr ib" style="margin-top: 7px;"
                           onclick="$('#loc_block_<?=$func_sfx?>').slideUp(); return false;">
                            <?=Y::t('x')?></a-->
                        <div class="button" style="padding: 0px 15px;"
                             onclick="apply<?=$func_sfx?>(); return false;">
                            <?=Y::t('Применить')?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script type="text/javascript">
        $(function () {
            if ('<?=$this->country_val?>' != '') {
                countryOnChange<?=$func_sfx?>(<?=$this->country_val?>);
            }
        });
        function countryOnChange<?=$func_sfx?>(val) {
            if(val>0)
                $('#obl_sel<?=$func_sfx?>').load(
                    '/location/item/oblast?type=<?=$type?>&sel_id=<?=$this->obl_val?>&id_country=' + val, null,
                    function () {
                        $('#<?=$this->id?> .obl_sel').slideDown(200);
                        $('#obl_sel<?=$func_sfx?>').trigger('change');
                        $('#rn_sel<?=$func_sfx?>').empty();
                        $('#city_sel<?=$func_sfx?>').empty();
                    }
                );
            else{
                $('#<?=$this->id?> .obl_sel').slideUp();
                $('#<?=$this->id?> .rn_sel').slideUp();
                $('#<?=$this->id?> .city_sel').slideUp();
                $('#obl_sel<?=$func_sfx?>').empty();
                $('#rn_sel<?=$func_sfx?>').empty();
                $('#city_sel<?=$func_sfx?>').empty();
            }
        }
        function oblastOnChange<?=$func_sfx?>(val) {
            if(val>0)
                $('#rn_sel<?=$func_sfx?>').load(
                    '/location/item/raion?type=<?=$type?>&sel_id=<?=$this->rn_val?>&id_oblast=' + val, null,
                    function () {
                        $('#<?=$this->id?> .rn_sel').slideDown(200);
                        $('#rn_sel<?=$func_sfx?>').trigger('change');
                        $('#city_sel<?=$func_sfx?>').empty();
                    }
                );
            else{
                $('#<?=$this->id?> .rn_sel').slideUp();
                $('#<?=$this->id?> .city_sel').slideUp();
                $('#rn_sel<?=$func_sfx?>').empty();
                $('#city_sel<?=$func_sfx?>').empty();
            }
        }
        function raionOnChange<?=$func_sfx?>(val) {
            if(val>0)
                $('#city_sel<?=$func_sfx?>').load(
                    '/location/item/city?type=<?=$type?>&sel_id=<?=$this->city_val?>&id_raion=' + val, null,
                    function () {
                        $('#<?=$this->id?> .city_sel').slideDown(200);
                        //$('#<?=$this->city_sel?>').trigger('change');
                    }
                );
            else{
                $('#<?=$this->id?> .city_sel').slideUp();
                $('#city_sel<?=$func_sfx?>').empty();
            }
        }
        function apply<?=$func_sfx?>(){
            var country_sel = $('#country_sel<?=$func_sfx?>');
            var obl_sel = $('#obl_sel<?=$func_sfx?>');
            var rn_sel = $('#rn_sel<?=$func_sfx?>');
            var city_sel = $('#city_sel<?=$func_sfx?>');
            $('#country_f<?=$func_sfx?>').val(country_sel.val());
            $('#obl_f<?=$func_sfx?>').val(obl_sel.val());
            $('#rn_f<?=$func_sfx?>').val(rn_sel.val());
            $('#city_f<?=$func_sfx?>').val(city_sel.val());

            var text = '';
            if(city_sel.val()>0 && text == '') text = $("#city_sel<?=$func_sfx?> option:selected").text();
            if(rn_sel.val()>0 && text == '') text = $("#rn_sel<?=$func_sfx?> option:selected").text();
            if(obl_sel.val()>0 && text == '') text = $("#obl_sel<?=$func_sfx?> option:selected").text();
            if(country_sel.val()>0 && text == '') text = $("#country_sel<?=$func_sfx?> option:selected").text();

            if( text != '') $('#loc_text_f<?=$func_sfx?>').val(text);
            else $('#loc_text_f<?=$func_sfx?>').val('');

            $('#loc_text_f<?=$func_sfx?>').trigger('change');

            $('#loc_block_<?=$func_sfx?>').slideUp();
        }
    </script>
        <style type="text/css">
            #loc_block_<?=$func_sfx?>
            {
                position: absolute;
                display: none;
            }
            #<?=$this->id?> select{ width: 240px; margin-bottom: 5px;}
            .loc_widget_title{
                font-weight: bold;
                font-size: 90%; width: 100px;
                /*display: block;*/
                display: none;
            }
        </style>
    <?
    }

}
