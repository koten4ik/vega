<?php
/*
    <div class="row" style="">
        <?php echo $form->labelEx($model, 'time', array('style' => 'width:100px')); ?>
        <?php $this->widget('FieldTime', array('field' => 'time', 'model' => $model, 'style' => ''))?>
        <?php echo $form->error($model, 'time'); ?>
    </div>
*/

Yii::import('zii.widgets.CPortlet');

class FieldTime extends CWidget
{
    public $field;
    public $model;
    public $style;
    public $class;
    public $format = "d-m-Y H:i:s";
    public $no_time = false;
    public $value;
    public $text_prefix;
    public $disabled = 0;
    public $is_error = 0;

	public  function run()
	{
        $field = $this->field;
        $model_name = $this->model ? get_class($this->model).'_' : '';
        $value = $this->model ? $this->model->$field : $this->value;
        $t_date = Y::date_print($value,$this->format);

        //$text = $this->text_prefix ? $this->text_prefix.': '.$t_date : $t_date;
        $text =  $t_date;

        $is_error = isset($this->model->errors[$field]) ? 1 : 0;
        ?>

        <? if($this->model) echo CHtml::activeHiddenField($this->model,$field);
            else echo CHtml::hiddenField($field, $value)?>
        <?= CHtml::textField( $model_name.$field.'_text', $text,
                array('onchange'=>'datepicker_change'.$field.'()', 'placeholder'=>$this->text_prefix, 'style'=>$this->style,
                    'class'=>$this->class.($is_error ? ' error':''), 'disabled'=>$this->disabled)  )?>

        <?= '<a class="ui-icon ui-close-butt" style="margin-left:-20px;" onclick="
                $(\'#' . $model_name.$field.'_text' . '\').val(\'\');
                $(\'#' . $model_name.$field . '\').val(\'\').trigger(\'change\');
            "></a>';?>

        <script type="text/javascript">
            $('#<?=$model_name.$field.'_text'?>').datepicker(
                {'dateFormat':'dd-mm-yy', onSelect: function(dateText, inst){
                    dateObj = new Date();
                    <?if($this->no_time==false){?>
                    $(this).val(
                        $(this).val()
                        +' '+JSTimeXX(dateObj.getHours())
                        +':'+JSTimeXX(dateObj.getMinutes())
                    )
                    <?}?>
                    datepicker_change<?=$field?>();
                }})
            function datepicker_change<?=$field?>(){
                dateObj1 = new Date();
                var val = $( "#<?=$model_name.$field.'_text'?>" ).val();
                new_date = Math.round(
                   Date.parse(
                       val.replace(/(\d+)-(\d+)-(\d+)/, '$3/$2/$1')
                       +' GMT+'+(dateObj1.getTimezoneOffset()/60*-1)
                   )/1000
                );
                if(new_date > 0){
                    $( "#<?=$model_name.$field?>" ).val(new_date);
                    $( "#<?=$model_name.$field?>" ).trigger('change');
                }
            }
        </script>
    <?
	}
}