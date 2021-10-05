<?php
/*
    $model = new Model(); $model->owner_id = $owner->id;

    $this->widget('CrudDialog', array(
        'create_url'=>'/'.BACKEND_NAME.'/moduleName/modelName/create?owner_id='.$owner->id,
        'model_alias'=>'company-track',
        'add_butt_text'=>'Добавить modelName',
        'grid_patch'=>'/modelName/_grid',
        'search_model'=>$model
    ));

в контроллере :
     public function  beforeCreate($model){
        $model->owner_id = $_GET['owner_id'];
    }
в  _grid :
    'saveState'=>false,
    'buttons'=>array(
        'delete' => array(
            'url'=>'"/'.BACKEND_NAME.'/moduleName/modelName/delete?id=".$data->id',
        ),
        'update' => array(
            'url'=>'"/".BACKEND_NAME."/moduleName/modelName/update?id=".$data->id',
            'options'=>array("onclick"=>"return ajax_open(this.href,'model_alias')"),
        )
    )
*/

class CrudDialog extends CWidget
{
    public $create_url;
    public $model_alias;
    public $add_butt_text;
    public $grid_patch;
    public $search_model;

	public  function run()
	{
        ?>
        <a href="<?=$this->create_url?>"
           onclick="return ajax_open(this.href,'<?=$this->model_alias?>')">
            <?=$this->add_butt_text?>
        </a>
        <br><br>

        <? $this->controller->renderPartial( $this->grid_patch, array( 'model'=>$this->search_model ),false,false); ?>

        <? $this->beginWidget('JuiDialog',
            array('id'=> $this->model_alias.'-dialog' )
        ); ?>

            <div id="<?=$this->model_alias?>-data"></div>

        <? $this->endWidget('JuiDialog'); ?>

        <style type="text/css">
            .<?=$this->model_alias.'-dialog'?>{background: #ebebeb}
            .<?=$this->model_alias.'-dialog'?> .ui-dialog-titlebar{display: none !important;}
        </style>
        <?
	}
}