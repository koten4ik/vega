<?php

Yii::import('zii.widgets.CPortlet');

class ContentListWidget extends CWidget
{
	public $title='Статьи';
    public $maxItems = 10;
    public $alias = 'articles';

    public function run()
	{
        $cat = ContentCategory::model()->find('alias=:al', array(':al'=>$this->alias));
        $criteria=new CDbCriteria;
        $criteria->compare('published', 1);
        $criteria->compare('cat_id', $cat->id);
        $criteria->limit = $this->maxItems;
        $criteria->order = 'cdate DESC';

        $items = ContentItem::model()->findAll($criteria);

        echo '<div id="'.$this->id.'" class="widget-content" >';
		foreach($items as $elem)
		{
            echo CHtml::tag('div',array(),
                CHtml::link($elem->title, array('/content/item/view', 'alias'=>$elem->alias))
            );
		}
        echo '</div>';
	}
}