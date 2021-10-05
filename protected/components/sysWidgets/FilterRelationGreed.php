<?php
/*
    <div class="row" style="height: 25px">
        <?php echo $form->labelEx($model,'cat_id', array('style'=>'display:inline-block;')); ?>
        <? $this->widget('FieldCategory',array(
            'field'=>'cat_id','form'=>$form,'model'=>$model,'catModel'=>'ContentCategory'))?>
        <?php echo $form->error($model,'cat_id'); ?>
    </div>
*/

class FilterRelationGreed extends CWidget
{
    public $id;
    public $field;
    public $model;
    public $relModel;
    public $relGridField = 'title';
    public $onSelCode = '';
    public static $w_cnt;

	public  function run()
	{
        $c = self::$w_cnt++;
        $field_id = get_class($this->model).'_'.$this->field.'_id';
        $field_name = get_class($this->model).'_'.$this->field.'_name';
        $filter = get_class($this->model).'_'.$this->field;

        $this->beginWidget('JuiDialog', array('id'=>$filter.'_dialog','title'=>'Выбор рубрики'));
                    $relModel = new $this->relModel();
                    $relModel->unsetAttributes();
                    $this->widget('GridView', array(
                        'id'=>'relation-grid'.$c,
                        'dataProvider'=>$relModel->search(),
                        'htmlOptions'=>array('style'=>'padding:0px 20px 20px 20px; min-width:500px;'),
                        'columns'=>array(
                            array(
                                'name' => 'id',
                                'value' => '$data->id',
                                'htmlOptions'=>array('class'=>'hit_td'),
                                'filter'=>null
                            ),
                            array(
                                'name' => $this->relGridField,
                                'value' => '$data->'.$this->relGridField,
                                'htmlOptions'=>array('class'=>'hit_td'),
                                'filter'=>null
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
                                            $("#'.$field_name.'").val(data[1]);
                                            '.$this->onSelCode.'
                                            $("#'.$field_id.'").trigger("change");
                                            $("#'.$filter.'_dialog").dialog("close");
                                            return false;
                                        }',
                                    ),
                                ),
                                'template'=>'{add}',
                            ),
                        ),
                    ));
        $this->endWidget('JuiDialog');
	}
}