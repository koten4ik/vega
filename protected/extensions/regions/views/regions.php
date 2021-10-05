<?
$func_sfx = '_'.$this->id;
$cntr_sel = get_class($model).'_'.$countryAttr;
$rn_sel = get_class($model).'_'.$regionAttr;
$city_sel = get_class($model).'_'.$cityAttr;

if($countryAttr) $cntr_value = $model->$countryAttr;
if($regionAttr) $rn_value = $model->$regionAttr;
if($cityAttr) $city_value = $model->$cityAttr;

?>

<? if($countryAttr)
{ ?>
    <div class="row">
        <?php echo $form->labelEx($model,$countryAttr); ?>
        <?php echo $form->dropDownList($model,$countryAttr, array(), array('onchange'=>'countryOnChange'.$func_sfx.'(this.value)')); ?>
        <?php echo $form->error($model,$countryAttr); ?>
    </div>
<? } ?>
<? if($regionAttr)
{ ?>
    <div class="row">
        <?php echo $form->labelEx($model,$regionAttr); ?>
        <?php echo $form->dropDownList($model,$regionAttr, array(), array('onchange'=>'regionOnChange'.$func_sfx.'(this.value)')); ?>
        <?php echo $form->error($model,$regionAttr); ?>
    </div>
<? } ?>
<? if($cityAttr)
{ ?>
    <div class="row">
        <?php echo $form->labelEx($model,$cityAttr); ?>
        <?php echo $form->dropDownList($model,$cityAttr, array() ); ?>
        <?php echo $form->error($model,$cityAttr); ?>
    </div>
<? } ?>

<?  $cs = Yii::app()->clientScript;
    $cs->registerScript( $this->id.'regions',"


        $('#$cntr_sel').html('<option value=-1 >$selMsg</option>')
        $('#$rn_sel'  ).html('<option value=-1 >$selMsg</option>')
        $('#$city_sel').html('<option value=-1 >$selMsg</option>')

        if('$cntr_sel' !=''){
            //$('#$cntr_sel').html('<option>Загрузка...</option>')
            $('#$cntr_sel').load('?r=regions/country&sel_id=$cntr_value'
                ,null,function(){
                     $('#$cntr_sel').trigger('change');
                }
            );
        }
        if('$countryVal' !=''){
            countryOnChange$func_sfx($countryVal);
        }

        function countryOnChange$func_sfx(val){
            //$('#$rn_sel').html('<option>Загрузка...</option>')
            $('#$rn_sel').load('?r=regions/region&sel_id=$rn_value&id_country='+val
                ,null,function(){
                     $('#$rn_sel').trigger('change');
                }
            );

        }
        function regionOnChange$func_sfx(val){
            //$('#$city_sel').html('<option>Загрузка...</option>')
            $('#$city_sel').load('?r=regions/city&sel_id=$city_value&id_region='+val
                ,null,function(){
                     //$('#$city_sel').trigger('change');
                }
            );
        }

    ", CClientScript::POS_END); ?>


