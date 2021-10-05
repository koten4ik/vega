
<?php
$arc = (int)($this->id == 'archive');

$this->widget('GridView', array(
    'id' => 'article-item-grid',
    'dataProvider' => $model->search($arc),
    'filter' => $model,
    //'ajaxUrl'=>Y::app()->request->url,
    'saveState' => true,
    'columns' => array(
        array(
            'class' => 'CCheckBoxColumn',
            'checkBoxHtmlOptions' => array('value' => '$data->id',),
            'id' => 'check_tr',
            'htmlOptions' => array('class' => 'check_td'),
        ),
        array(
            'name' => 'id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->id, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id' => 'id_tr',
            'htmlOptions' => array('class' => 'id_td'),
        ),
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => 'CHtml::link($data->title, array("update","id"=>$data->id),
                array("onclick"=>"return ajax_load(this,".$data->id.")") )',
            'id' => 'title_tr',
            'htmlOptions' => array('class' => 'title_td'),
        ),
        array(
            'name' => 'published',
            //'value' => '$data->published',
            'id' => 'published_tr',
            'htmlOptions' => array('class' => 'published_td'),
            'filter' => array('1' => 'Да', '0' => 'Нет'),
            'class' => 'FlagColumn',
        ),
        array(
            'name' => 'cat_id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->category->title,
                array("/".BACKEND_NAME."/content/category/list?update=".$data->category->id) )',
            'htmlOptions' => array('style' => 'width:180px;'),
            'filter' => Html::categoryFilter($model,'cat_id'),
            'visible'=>!$model->multiCat
        ),
        array(
            'name' => 'cdate',
            'value' => 'Y::date_print($data->cdate,"d-m-Y")',
            'htmlOptions' => array('style' => 'width:90px; text-align:center;'),
            'filter' =>Html::dateFilter($model,'cdate','dd.mm.yy')
        ),
        array(
            'name' => 'author_id',
            'type' => 'raw',
            'value' => 'CHtml::link($data->author->username,
                            array("/user/manage/update","id"=>$data->author->id) )',
            'id' => 'author_tr',
            'htmlOptions' => array('class' => 'author_td'),
        ),
        array(
            'name' => 'hits',
            'value' => '$data->hits',
            'id' => 'hit_tr',
            'htmlOptions' => array('class' => 'hit_td'),
            'filter' => '',
        ),
        array(
            'class' => 'CButtonColumn',
            'afterDelete' => 'function(link,success,data){ if(success) showModMsg("Элемент удален"); }',
            'template' => '{delete}'
        ),
    ),
));

