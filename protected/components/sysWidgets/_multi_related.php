<?
$rel_name = 'relationName';
$add_url = 'addAction?owner_id='.$model->id;
$delete_url = 'deleteAction';
// екшены по управлению в низу стр

if (!$model->isNewRecord)
{
    echo CHtml::link('Добавить', '#', array('onclick' => '$("#'.$rel_name.'-dialog").dialog("open"); return false;'));

    $this->widget('GridView', array(
        'id' => $rel_name.'-grid',
        'dataProvider' => relationModel::model()->search($model->id),
        'columns' => array(

            array(
                'header' => 'Название',
                'value' => '$data->relationName->title',
                'htmlOptions' => array('style' => ''),
            ),
            array('class' => 'CButtonColumn',
                'buttons' => array( 'delele' => array( 'label' => 'удалить',    'url' => '$data->id',
                    'click' => 'function(){
                         if(confirm("подтверждение удаленеия"))
                             $.post("'.$delete_url.'?id="+$(this).attr("href"), function(data){
                                 $.fn.yiiGridView.update("'.$rel_name.'-grid");
                             });
                         return false; }'
                )), 'template' => '{delele}'
            ),
        ),
    ));
}

$this->beginWidget('JuiDialog',  array('id'=> $rel_name.'-dialog', 'title'=>'Выбор элемента' )  );

    $relModel = new $relModel();
    $relModel->unsetAttributes();
    // создать переменную во вледельце relModel_attrs для работы фильтра
    $relModel->attributes=$model->relModel_attrs;
    $this->widget('GridView', array(
        'id' => $rel_name.'-grid-dialog',
        'dataProvider' => $relModel::model()->search(),
        'filter'=>$relModel,
        'columns' => array(
            array(
                'name' => 'id',
                'value' => '$data->id',
                'htmlOptions' => array('style' => 'width:40px;'),
            ),
            array(
                'name' => 'title',
                'value' => '$data->title',
                'htmlOptions' => array('style' => 'width:180px;'),
            ),
            array(
                'class'=>'CButtonColumn',
                'buttons'=>array( 'add'=>array( 'label'=>'выбрать',  'url'=>'$data->id',
                    'click'=>'function(){  $.post( "'.$add_url.'&item_id="+$(this).attr("href"),
                            function(data) {
                                //$("#'.$rel_name.'-dialog").dialog("close");
                                $.fn.yiiGridView.update("'.$rel_name.'-grid");
                        }); return false; }',
                )), 'template'=>'{add}',
            ),
        ),
    ));

$this->endWidget('JuiDialog');

/*
    public function actionAddMCrel($owner_id,$item_id){
        $model = RelModel::model()->find('owner_id='.$owner_id.' and item_id='.$item_id);
        if($model) return;
        $model = new RelModel();
        $model->owner_id = $owner_id;
        $model->item_id = $item_id;
        $model->save();
    }
    public function actionDeleteMCrel($id){
        $model = RelModel::model()->findByPk($id);
        $model->delete();
    }
    // для работы фильтра
    public function beforeUpdate($model){
        $model->relModel_attrs = $_GET['relModel'];
    }
*/