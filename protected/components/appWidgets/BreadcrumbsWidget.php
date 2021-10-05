<?php
/*
    $this->widget('BreadcrumbsWidget', array('crumbs'=>array(
        'name' => '/url',
        'name2' => '/url2',
    )));

    or in contorller fill data
    $this->breadcrumbs = array(
        'name' => '/url',
        'name2' => '/url2',
    );
*/

Yii::import('zii.widgets.CPortlet');

class BreadcrumbsWidget extends CWidget
{
    public $crumbs = null;

    public function run()
    {
        $crumbs = $this->crumbs ? $this->crumbs : $this->controller->breadcrumbs;
    ?>
        <div class="breadcrumbs">
            <? $cnt = 0;
            foreach($crumbs as $key=>$elem){ $cnt++;?>
                <?= $cnt > 1 ? CHtml::tag('span',array(),'/') : ''?>
                <?= $elem != '' ? CHtml::link($key,$elem) : $key?>
            <?}?>
        </div>
    <?
    }
}
