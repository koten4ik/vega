<?php

Yii::import('zii.widgets.CMenu');

class MainMenuWidget extends CWidget
{

	public function run()
	{

        $this->widget('Menu',array(
            'id'=>$this->id,
            'lastItemCssClass'=>'last',
            'menu_id'=>$this->controller->menu_id,
            'smenu_id'=>$this->controller->smenu_id,
            'items'=>MenuModule::treeToArray(MenuModule::SITE_ID),
            //'type'=>Menu::TYPE_URL_PARTS
        ));

	}
}