<?php

Yii::import('zii.widgets.CPortlet');

class CatalogWidget extends CPortlet
{
	public $title='Категории';

	protected function renderContent()
	{
        $root=CatalogCategory::model()->findByPk(1);
        $descendants=$root->children()->findAll();
        $cur_cat = CatalogCategory::getCurrent();

        echo '<ul>';
		foreach($descendants as $key=>$category)
		{
            if(!$category->published) continue;

            $hl = ( $cur_cat->id == $category->id ) ? 'active' : '';
            $special = ($category->alias == 'reserve') || ($category->alias == 'demand');

            $descendants_sub = $category->children()->cache(10)->findAll();
            $count = count($descendants_sub);
            $onclick = '';
            if($count) $onclick = '
                 $(".sub_cat").removeClass("opened");
                 $("#sub_cat'.$key.'").addClass("opened");
                 $(".sub_cat:not(.opened)").slideUp();
                 $("#sub_cat'.$key.'").slideToggle();

                 return false;';

            echo CHtml::tag('li',array( 'class'=>($special ? 'special' : '').' cat', 'id'=>'cat'.$key),
                CHtml::link( $category->title, $category->url, array('class'=>$hl, 'onclick'=>$onclick) )
            );

            if($count){
                echo '<ul class="sub_cat" id="sub_cat'.$key.'">';
                foreach($descendants_sub as $sub)
                {
                    if( $cur_cat->id == $sub->id ){
                        $hl = 'active';
                        echo '<script type="text/javascript">
                            $("#sub_cat'.$key.'").css("display", "inline");
                            $("#cat'.$key.' a").addClass("active");
                        </script>';
                    }
                    else $hl = '';

                    echo CHtml::tag('li',array( 'class'=>$special ? 'special' : ''),
                        CHtml::link( $sub->title, $sub->url, array('class'=>$hl) )
                    );
                }
                echo '</ul>';
            }
		}
        echo '</ul>';


	}
}