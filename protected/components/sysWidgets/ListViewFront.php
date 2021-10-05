<?php

Yii::import('zii.widgets.CListView');

class ListViewFront extends CListView
{
    public $cssFile = false;
    public $pagerCssClass = 'myPager';
    //public $template = "{pagesize}{summary}\n{sorter}\n{items}\n{pager}";
    public $template = "{summary}\n{sorter}\n{items}\n{pager}";
    public $ajaxUpdate = false;

    public $pager = array('nextPageLabel' => '>', 'prevPageLabel' => '<', 'header' => '');


    public function renderSorter()
    {
        if ($this->dataProvider->getItemCount() <= 0 || !$this->enableSorting || empty($this->sortableAttributes))
            return;
        echo CHtml::openTag('div', array('class' => $this->sorterCssClass)) . "\n";
        echo $this->sorterHeader === null ? Yii::t('zii', 'Sort by: ') : $this->sorterHeader;
        echo "<ul>\n";
        $sort = $this->dataProvider->getSort();
        foreach ($this->sortableAttributes as $name => $label)
        {
            echo "<li>";
            if (is_integer($name))
                echo $sort->link($label);
            else
                echo $sort->link($name, $label);
            echo "</li>\n";
        }
        echo "</ul>";
        echo $this->sorterFooter;
        echo CHtml::closeTag('div');
    }

    public function renderPageSize()
    {
        if ($this->dataProvider->getItemCount() <= 0) return;

        echo '<div class="pageSize">';
        echo 'На странице';
        echo CHtml::dropDownList('pageSize',
            Y::cookie('listPageSize') > 0 ? Y::cookie('listPageSize') : Config::$data['base']->pageSizeFront,
            array(
                6 => 6,
                9 => 9,
                12 => 12,
                24 => 24,

                //Config::$data['base']->pageSizeFront*2=>Config::$data['base']->pageSizeFront*2,
            ),
            array(
                'style' => 'margin-left:5px; height:18px',
                'onchange' => '
                    $.cookie("listPageSize", $(this).val())
                    //$.fn.yiiListView.update("' . $this->id . '")
                    window.location.reload();
                    '
            )
        );
        echo '</div>';
    }

    public function renderItems()
    {
        echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
        $data=$this->dataProvider->getData();
        if(($n=count($data))>0)
        {
            $owner=$this->getOwner();
            $render=$owner instanceof CController ? 'renderPartial' : 'render';
            $j=0;
            foreach($data as $i=>$item)
            {
                $data=$this->viewData;
                $data['index']=$i;
                $data['data']=$item;
                $data['widget']=$this;
                $data['length']=$n;
                $owner->$render($this->itemView,$data);
                if($j++ < $n-1)
                    echo $this->separator;
            }
        }
        else
            $this->renderEmptyText();
        echo CHtml::closeTag($this->itemsTagName);
    }
}

?>