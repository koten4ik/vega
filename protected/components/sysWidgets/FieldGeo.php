<?php
/*
    <div class="row" style="">
        <?php echo $form->labelEx($model, 'time', array('style' => 'width:100px')); ?>
        <?php $this->widget('FieldTime', array('field' => 'time', 'model' => $model, 'style' => ''))?>
        <?php echo $form->error($model, 'time'); ?>
    </div>
*/



class FieldGeo extends CWidget
{
    public $field;
    public $model;
    public $style;
    public $class;
    public $disabled = false;

	public  function run()
	{
        $field = $this->field;
        $model_name = $this->model ? get_class($this->model).'_' : '';
        $coord_lat = 0; $coord_lng = 0;
        if($this->model->$field){
            $arr = explode(',',$this->model->$field);
            $coord_lat = trim($arr[0]);
            $coord_lng = trim($arr[1]);
        }
        echo CHtml::activeHiddenField($this->model,$field);
       ?>
    <input name="<?=$model_name.$field.'_text'?>" id="<?=$model_name.$field.'_text'?>"
        style="<?=$this->style?> text-decoration: underline;" readonly="1"
        onchange="$('#<?=$model_name.$field?>' ).val($(this).val())"
        class="<?=$this->class?>" value="<?=$this->model->$field?>"
        type="text"  placeholder="<?=$this->model->$field ? '' : Y::t('Открыть карту',0)?>"
        onclick="initMap();vega_dialog_open('geo_dialog')">


        <?$this->beginWidget('VegaDialog', array('id'=>'geo_dialog','title'=>'Карта','width'=>1000));?>
            <div id="map" class="geo_canvas" style="min-width: 800px; min-height: 600px;"></div>
        <?$this->endWidget('VegaDialog');?>

    <script>
        function initMap() {
            var exist = <?= $coord_lat ? 1 : 0?>;
            var myLatlng = {lat:<?= $coord_lat?$coord_lat:52.768 ?>,
                lng:<?= $coord_lng?$coord_lng:43.703 ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: exist ? 10:4,
                center:myLatlng
            });
            var marker;
            if(exist)
                marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map,
                    title: 'marker',
                    draggable: true
                });
            map.addListener('click', function (event) {
                if (marker) {
                       marker.setPosition(event.latLng);
                } else {
                   marker = new google.maps.Marker({
                       position: event.latLng,
                       map: map,
                       title: 'marker',
                       draggable: true
                   });
                }
                var coords = marker.getPosition().lat().toFixed(6)
                    +', '+marker.getPosition().lng().toFixed(6);
                $( "#<?=$model_name.$field?>" ).val(coords);
                $( "#<?=$model_name.$field.'_text'?>" ).val(coords);
                $( "#<?=$model_name.$field?>" ).trigger('change');
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAVjeVU_m_FiU98IRMcd2lP4A4MUgDGhMs&callback=initMap1"
            async defer></script>
    <?
	}
}