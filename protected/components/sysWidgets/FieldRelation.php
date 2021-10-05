<?php
/*
    <div class="row">
        <?php echo $form->labelEx($model,'rel_id', array('style'=>'')); ?>
        <? $this->widget('FieldRelation', array('form'=>$form, 'model'=>$model, 'style'=>'',
            'field'=>'rel_id', 'relModel'=>'relModelName', 'title'=>$model->relation->title))?>
        <? echo $form->error($model,'rel_id'); ?>
    </div>


    // для работы фильтра в модели
    public $relModel_attrs;
    // для работы фильтра в контроллере
    public function beforeCreate($model){
        $model->relModel_attrs = $_GET['relModel'];
    }
    public function beforeUpdate($model){
        $model->relModel_attrs = $_GET['relModel'];
    }
*/

class FieldRelation extends CWidget
{
    public $id;
    public $field;
    public $model;
    public $form;
    public $title;
    public $relModel;
    public $onSelCode = '';
    public $style;
    public $class;
    public $relGridField = 'title';
    public $relSearchFunc = 'searchRelation';
    public static $w_cnt;


	public  function run()
	{
        $c = self::$w_cnt++;
        if(!$this->id) $this->id = 'rel_name'.$c;
        $field_id = get_class($this->model).'_'.$this->field;
        ?>

        <?php echo $this->form->hiddenField($this->model,$this->field); ?>

        <input type="text" value="<?= str_replace('"','\'', $this->title )?>" style="padding-right: 20px;<?=$this->style?>"
               class="<?=$this->class?> cat_sel_butt" id="<?=$this->id?>"
               onclick='$("#relation_dialog<?=$c?>").dialog("open"); return false;' />

        <span style="margin-left: -15px; text-decoration: underline;cursor: pointer"
            onclick="$('#<?=$this->id?>').val(''); $('#<?=$field_id?>').val('');" >x</span>

        <script type="text/javascript">
            if($('#<?=$field_id?>').hasClass('error')) $('#<?=$this->id?>').addClass('error')
            if(!$('#<?=$this->id?>').val()) $('#<?=$this->id?>').val('Выбрать');
        </script>
        <?
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id'=>'relation_dialog'.$c,
            'options'=>array(
                'title'=>'Выбор элемента',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>'auto'
            ),
        ));
            echo '<div id="relation-grid-wrap'.$c.'">';
            $relModel = new $this->relModel();
            $relModel->unsetAttributes();
            if(isset($this->model->{get_class($relModel).'_attrs'}))
                $relModel->attributes=$this->model->{get_class($relModel).'_attrs'};
            $this->widget('GridView', array(
                'id'=>'relation-grid'.$c,
                'dataProvider'=>$relModel->{$this->relSearchFunc}(),
                'filter'=>$relModel,
                'htmlOptions'=>array('style'=>'padding:0px 20px 20px 20px; min-width:500px;'),
                'columns'=>array(
                    array(
                        'name' => 'id',
                        'value' => '$data->id',
                        'htmlOptions'=>array('style'=>'width:50px;'),
                        'filter'=>''
                    ),
                    array(
                        'name' => str_replace('->','.',$this->relGridField),
                        'value' => '$data->'.$this->relGridField,
                        'htmlOptions'=>array('class'=>'hit_td'),
                        'filter'=>'<input name="rel_search_title" value="'. $_GET['rel_search_title'] .'">'
                    ),
                    array(
                        'class'=>'CButtonColumn',
                        'buttons'=>array(
                            'add'=>array(
                                'label'=>'выбрать',
                                'url'=>'$data->id.";".$data->'.$this->relGridField,
                                'click'=>'function(){
                                    data = $(this).attr("href").split(";");
                                    $("#'.$field_id.'").val(data[0]);
                                    $("#'.$this->id.'").val(data[1]);
                                    '.$this->onSelCode.'
                                    $("#relation_dialog'.$c.'").dialog("close")
                                    return false;
                                }',
                            ),
                        ),
                        'template'=>'{add}',
                    ),
                ),
            ));
            echo '</div>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
	}
}