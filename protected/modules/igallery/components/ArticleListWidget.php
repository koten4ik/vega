<?php

Yii::import('zii.widgets.CPortlet');

class ArticleListWidget extends CPortlet
{
	public $title='Статьи';
    public $maxItems = 10;

	protected function renderContent()
	{
        $alias = 'articles';
        $cat = ContentCategory::model()->find('alias=:al', array(':al'=>$alias));

        $criteria=new CDbCriteria;
        $criteria->compare('published', 1);
        $criteria->compare('cat_id', $cat->id);
        $dataProvider=new CActiveDataProvider(
            'ContentItem',
            array( 'criteria'=>$criteria,
                   'sort'=>array('defaultOrder'=>'cdate DESC'),
            )
        );
        $articles = $dataProvider->getData();

        echo '<ul>';
		foreach($articles as $article)
		{
            echo CHtml::tag('li',array(),
                CHtml::link($article->title, array('/content/item/view', 'alias'=>$article->alias))
            );
            if(--$this->maxItems < 1) break;
		}
        echo '</ul>';
	}
}