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

class LocationMultiWidget_ extends CWidget
{

    public static $selMsg = '';

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

        ?>
        <div id="<?=$this->id?>">

        <? if ($this->country_sel) { ?>
            <div class="loc_widget_block country_sel">
                <span class="loc_widget_title"><?=$this->country_title?></span>
                <?=CHtml::dropDownList($this->country_sel, $this->country_val,
                CMap::mergeArray(array('' => self::$selMsg), LocationCountry::getList()),
                array('onchange' => 'if(this.value>0) countryOnChange' . $func_sfx . '(this.value)')); ?>
            </div>
        <? } ?>
        <? if ($this->obl_sel) { ?>
            <div class="loc_widget_block obl_sel">
                <span class="loc_widget_title"><?=$this->obl_title?></span>
                <?=CHtml::dropDownList($this->obl_sel, $this->obl_val,
                $this->country_val ?
                CMap::mergeArray(array('' => self::$selMsg), LocationOblast::getList($this->country_val)) : array(),
                array('onchange' => 'if(this.value>0) oblastOnChange' . $func_sfx . '(this.value)')); ?>
            </div>
        <? } ?>
        <? if ($this->rn_sel) { ?>
            <div class="loc_widget_block rn_sel">
                <span class="loc_widget_title"><?=$this->rn_title?></span>
                <?=CHtml::dropDownList($this->rn_sel, $this->rn_val,
                $this->obl_val ?
                CMap::mergeArray(array('' => self::$selMsg), LocationRaion::getList($this->obl_val)) : array(),
                array('onchange' => 'if(this.value>0) raionOnChange' . $func_sfx . '(this.value)')); ?>
            </div>
        <? } ?>
        <? if ($this->city_sel) { ?>
            <div class="loc_widget_block city_sel">
                <span class="loc_widget_title"><?=$this->city_title?></span>
                <?=CHtml::dropDownList($this->city_sel, $this->city_val,
                    $this->rn_val ?
                    CMap::mergeArray(array('' => self::$selMsg), LocationCity::getList($this->rn_val)): array()
                ); ?>
            </div>
        <? } ?>

        </div>

    <script type="text/javascript">
        $(function () {
            if ('<?=$this->country_val?>' != '') {
                countryOnChange<?=$func_sfx?>(<?=$this->country_val?>);
            }
        });
        function countryOnChange<?=$func_sfx?>(val) {

            $('select[name="<?=$this->obl_sel?>"]').load('/location/item/oblast?sel_id=<?=$this->obl_val?>&id_country=' + val, null,
                function () {
                    $('select[name="<?=$this->obl_sel?>"]').trigger('change');
                    $('select[name="<?=$this->rn_sel?>"]').empty();
                    $('select[name="<?=$this->city_sel?>"]').empty();
                }
            );
        }
        function oblastOnChange<?=$func_sfx?>(val) {
            $('select[name="<?=$this->rn_sel?>"]').load('/location/item/raion?sel_id=<?=$this->rn_val?>&id_oblast=' + val, null,
                function () {
                    $('select[name="<?=$this->rn_sel?>"]').trigger('change');
                    $('select[name="<?=$this->city_sel?>"]').empty();
                }
            );
        }
        function raionOnChange<?=$func_sfx?>(val) {
            $('select[name="<?=$this->city_sel?>"]').load('/location/item/city?sel_id=<?=$this->city_val?>&id_raion=' + val, null,
                function () {
                    //$('#<?=$this->city_sel?>').trigger('change');
                }
            );
        }

    </script>
    <?
    }

}
