<?php

Yii::import('zii.widgets.CPortlet');

class CatalogFilterWidget extends CPortlet
{
	public $title='Фильтр';

	protected function renderContent()
	{
        Yii::app()->clientScript->registerScript('search', "
            /*$('#filter').submit(function(){
                $.fn.yiiListView.update('catalog-item-list', { data: $(this).serialize() });
                return false;
            });*/

            $('.attr_button').click(function(){
                var attr_block = 'attr_block-'+$(this).attr('id').split('-')[1];
                $.cookie(attr_block, $('#'+attr_block).css('display') == 'none' ? 1 : 0)
            	$('#'+attr_block).slideToggle();
            	return false;
            });
        "); ?>

        <?
            $category = CatalogCategory::getCurrent();
            $allow = $category != null;

        ?>

        <div class="form" >
        <?php $form=$this->beginWidget('ActiveForm', array(
            'id'=>'filter',
        	'action'=>$category->url,
        	'method'=>'get',
        )); ?>

            <!--b style="padding-left: 5px">Цена</b><br>
            <div class="attr_block" style="display: block;">
            от <input name="filter_price_from" value="<? echo $_GET['filter_price_from'] ?>" size="4"/>
            до <input name="filter_price_to" value="<? echo $_GET['filter_price_to'] ?>" size="4"/>
            <? echo ShopModule::getCurrency(); ?>
            </div-->
            <?
            echo '<a href="#" id="attr_button-price" class="attr_button" >Цена</a><br>';
            echo '<div class="attr_block" id="attr_block-price" style="'.(Y::cookie('attr_block-price') ? 'display:block' : '').'">';
                echo 'от '.CHtml::textField('filter_price_from', $_GET['filter_price_from'], array('size'=>5));
                echo ' до '.CHtml::textField('filter_price_to', $_GET['filter_price_to'], array('size'=>5))
                        .' '.ShopModule::getCurrency();
            echo '</div>';
            ?>

            <? foreach(CatalogAttribute::getList($category) as $attr){
                if(!$attr->filter) continue;
                echo '<a href="#" id="attr_button-'.$attr->id.'" class="attr_button" >'.$attr->name.'</a><br>';
                echo '<div class="attr_block" id="attr_block-'.$attr->id.'" style="'.(Y::cookie('attr_block-'.$attr->id) ? 'display:block' : '').'">';
                if($attr->type == 1){
                    foreach( CatalogAttrVal::getList($attr->id) as $value)
                        echo CHtml::checkBox('filter-'.$attr->id.'-'.$value->id, ($_GET['filter-'.$attr->id.'-'.$value->id]), array('id'=>'filter_'.$attr->id.'_'.$value->id))
                            .' '.CHtml::label($value->value.' '.$attr->sufix, 'filter_'.$attr->id.'_'.$value->id)
                            .'<br>';
                }
                if($attr->type == 2){
                    echo CHtml::radioButton('filter-'.$attr->id, ($_GET['filter-'.$attr->id]==0), array('id'=>'filter_'.$attr->id.'_0', 'value'=>0))
                        .' '.CHtml::label('Неважно', 'filter_'.$attr->id.'_0').'<br>';
                    echo CHtml::radioButton('filter-'.$attr->id, ($_GET['filter-'.$attr->id]==1), array('id'=>'filter_'.$attr->id.'_1', 'value'=>1))
                        .' '.CHtml::label('Да', 'filter_'.$attr->id.'_1').'<br>';
                    echo CHtml::radioButton('filter-'.$attr->id, ($_GET['filter-'.$attr->id]==2), array('id'=>'filter_'.$attr->id.'_2', 'value'=>2))
                        .' '.CHtml::label('Нет', 'filter_'.$attr->id.'_2').'<br>';
                }
                if($attr->type == 3){
                    echo 'от '.CHtml::textField('filter-'.$attr->id.'_from', $_GET['filter-'.$attr->id.'_from'], array('size'=>5));
                    echo ' до '.CHtml::textField('filter-'.$attr->id.'_to', $_GET['filter-'.$attr->id.'_to'], array('size'=>5))
                            .' '.$attr->sufix;
                }
                echo '</div>';
            } ?>
            <br>

        	<div class="row buttons">
                <input class="butt blue_grad" type="submit" value="Применить" <? if(!$allow) echo 'disabled' ?> style="<? if(!$allow) echo 'cursor:default' ?>"/>
                <? if(!$allow) echo '<div style="font-size: 85%; color: gray">Выберите категорию</div>' ?>
        		<?php //echo CHtml::submitButton('Применить', array('disable'=>'disable')); ?>
        	</div>

            <? echo CHtml::hiddenField('key',$_GET['key']); ?>
            <? echo CHtml::hiddenField('adv_search', 1); ?>

        <?php $this->endWidget(); ?>
        </div><!-- search-form -->
	<? }
}