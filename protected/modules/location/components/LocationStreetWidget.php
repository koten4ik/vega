<?php
/* $this->widget('LocationAutoWidget',
        array('form'=>$form, 'model'=>$model, 'field'=>'field', 'text'=>$model->field->title ));
*/

class LocationStreetWidget extends CWidget {

    public $model;
    public $field;
    public $text;
    public $form;
    public $f_w = 100;

    public function init()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
    }

    public function run()
    {
        $func_sfx = '_' . $this->id;
        $locationId= get_class($this->model).'_'.$this->field;
        $loc_block = $locationId.'_auto_block';
        ?>

        <div class="row">
            <?= $this->form->labelEx($this->model,$this->field, array('style'=>'')); ?>
            <?= $this->form->hiddenField($this->model,$this->field, array('style'=>'')); ?>
            <input id="<?=$locationId?>_i" type="text" value="<?=$this->text?>" AUTOCOMPLETE="off"
                   <?= $this->model->place_id>0 ? '':'disabled'?>  style="width: <?=$this->f_w?>px">
            <input type="hidden" id="street_place_id" value="<?= $this->model->place_id?>">
            <?=$this->form->error($this->model,$this->field);?>
        </div>
        <div id="<?=$loc_block?>" class="loc_auto_block"></div>

        <style type="text/css">
            .loc_auto_block{ border: 1px solid; background: #fff; max-height: 180px;  padding: 5px; }
            .loc_auto_block{ overflow-y:auto; position: absolute; display: none; }
            .loc_auto_elem{ margin-bottom: 5px; cursor: pointer;}
            .loc_auto_elem span{ font-size: 80%; color: #888;}
            .loc_auto_elem:hover{background: #eee}
        </style>
        <script type="text/javascript">
            $(function ()
            {
                var location_f = $('#<?=$locationId?>');
                var location_i = $('#<?=$locationId?>_i');
                var loc_block = $('#<?=$loc_block?>');

                //console.log(location_i.offset().top )
                loc_block.width(location_i.width()-8);
                loc_block.offset({
                    top: location_i.offset().top + location_i.height()+4,
                    left: location_i.offset().left });

                location_i.blur( function() { setTimeout('$("#<?=$loc_block?>").hide()',300) } )

                function location_load<?=$func_sfx?>(){
                    location_f.val(location_i.val());
                    loc_block.load('/location/item/street?key='+location_i.val()+'&place_id='+$('#street_place_id').val(),
                        function(){ loc_block.show(); loc_block.scrollTop(0); }
                    );
                }
                location_i.keyup( location_load<?=$func_sfx?> );
                //location_i.click( location_load );

                loc_block.on( "click", '.loc_auto_elem', function(){
                    location_f.val($(this).attr('key'));
                    location_i.val($(this).attr('dtitle'));
                    loc_block.hide();
                })

            });
        </script>
        <?
    }

}
