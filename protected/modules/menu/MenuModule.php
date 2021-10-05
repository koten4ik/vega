<?php

class MenuModule extends WebModule
{
    public $defaultController = 'item';
    const ADMIN_ID = 24;
    const SITE_ID = 25;

	public function init()
	{
        parent::init();

        // admin menu
        $this->params['mod_menu'] = array(
            array('label'=>'menu', 'url'=>array('/menu/item/list')),
        );

		// import the module-level models and components
		$this->setImport(array(
			'menu.models.*',
			'menu.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

    public static function treeToArray($root)
    {
        $root=MenuItem::model()->findByPk($root);
        if(!$root) return;
        $descendants=$root->children()->findAll();
        $array = array();

        foreach($descendants as $item)
        {
            if(!$item->published) continue;
            $descendants_sub = $item->children()->cache(0)->findAll();
            $sub_array = array();

            foreach($descendants_sub as $sub_item)
                if($sub_item->published)
                    $sub_array[] = array(
                        'label'=>$sub_item->title,
                        'url'=>array($sub_item->url),
                        'item_class'=>$sub_item->css_class,
                        'smenu_id'=>$sub_item->smenu_id,
                    );

            $array[] = array(
                'label'=>$item->title,
                'url'=>array($item->url),
                'items'=>$sub_array,
                'item_class'=>$item->css_class,
                'menu_id'=>$item->menu_id,
            );
        }

        return $array;
    }

    public static function getRawList($root)
    {
        $root = MenuItem::model()->findByPk($root);
        if($root)
            return MenuItem::model()->findAll('published=1 and lft >= '.$root['lft'].' and rgt <= '.$root['rgt']);
        return;
    }
}
