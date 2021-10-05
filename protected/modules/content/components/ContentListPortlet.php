<?php

Yii::import('zii.widgets.CPortlet');

class ContentListPortlet extends CPortlet
{
	public $title='Статьи';
    public $maxItems = 10;
    public $alias = 'articles';

	protected function renderContent()
	{
        $cat = ContentCategory::model()->find('alias=:al', array(':al'=>$this->alias));
        $criteria=new CDbCriteria;
        $criteria->compare('published', 1);
        $criteria->compare('cat_id', $cat->id);
        $criteria->limit = $this->maxItems;
        $criteria->order = 'cdate DESC';

        $items = ContentItem::model()->findAll($criteria);

        echo '<ul>';
		foreach($items as $elem)
		{
            echo CHtml::tag('li',array(),
                CHtml::link($elem->title, array('/content/item/view', 'alias'=>$elem->alias))
            );
		}
        echo '</ul>';
	}
}