<?php

Yii::import('zii.widgets.CMenu');

class Menu extends CMenu
{
    const TYPE_SIMPLE = 0;
    const TYPE_CONTR_VAR = 1;
    const TYPE_URL_PARTS = 2;
    public $menu_id;
    public $smenu_id;
    //public $activateParents=true;
    public $type= self::TYPE_SIMPLE;

    public function init()
    {
        parent::init();

        if($this->type == self::TYPE_SIMPLE)
            foreach ($this->items as $key=>$elem)
            {
                if($this->items[$key]['items'])
                    foreach ($this->items[$key]['items'] as $key_sub=>$elem_sub)
                        $this->items[$key]['items'][$key_sub]['active'] =
                            Y::app()->request->requestUri ==  $this->items[$key]['items'][$key_sub]['url'][0];

                $this->items[$key]['active'] =
                    (strpos(Y::app()->request->url, $this->items[$key]['url'][0] ) !== false);
            }
    }

    protected function isItemActive($item, $route)
    {
        if($this->type == self::TYPE_SIMPLE )
            return parent::isItemActive($item, $route);


        if($this->type == self::TYPE_CONTR_VAR)
        {
            if( $this->menu_id != null || $this->smenu_id != null ){
                if( $item['menu_id'] == $this->menu_id || $item['smenu_id'] == $this->smenu_id ) return true;
                else return false;
            }
        }

        /*todo сделать 3 уровень */
        if($this->type == self::TYPE_URL_PARTS)
        {
            if( $this->menu_id != null || $this->smenu_id != null )
            {
                // для вывода в не свой раздел
                // - указывать menu_id и smenu_id в итеме меню и в контроллере
                if( $item['menu_id'] == $this->menu_id ||
                    $item['smenu_id'] == $this->smenu_id
                ) return true;
                else return false;
            }
            else
            {
                $url_ex = explode('/',Y::app()->request->url);
                $menu_ex = explode('/',$item['url'][0]);
                if($item['items'] && $menu_ex[1] == $url_ex[2] ) return true;
                if(!$item['items'] && $menu_ex[2] == $url_ex[3] ) return true;
            }
            return false;
        }
    }

    protected function renderMenuRecursive($items)
    {
        $count = 0;
        $n = count($items);
        foreach ($items as $item)
        {
            $count++;
            $options = isset($item['itemOptions']) ? $item['itemOptions'] : array();
            $class = array($item['item_class']);
            if ($item['active'] && $this->activeCssClass != ''){
                $item['linkOptions']['class']='a_active';
                $class[] = $this->activeCssClass;
            }
            if ($count === 1 && $this->firstItemCssClass !== null)
                $class[] = $this->firstItemCssClass;
            if ($count === $n && $this->lastItemCssClass !== null)
                $class[] = $this->lastItemCssClass;
            if ($this->itemCssClass !== null)
                $class[] = $this->itemCssClass;
            if ($class !== array()) {
                if (empty($options['class']))
                    $options['class'] = implode(' ', $class);
                else
                    $options['class'] .= ' ' . implode(' ', $class);
            }

            echo CHtml::openTag('li', $options);

            $menu = $this->renderMenuItem($item);
            if (isset($this->itemTemplate) || isset($item['template'])) {
                $template = isset($item['template']) ? $item['template'] : $this->itemTemplate;
                echo strtr($template, array('{menu}' => $menu));
            }
            else
                echo $menu;

            if ( isset($item['items']) && count($item['items']) ) {
                $sub_active = false;
                foreach($item['items'] as $elem) if($elem['active']) $sub_active = true;
                if($item['active'] || $sub_active){
                    echo "\n" . CHtml::openTag('ul', isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions) . "\n";
                    $this->renderMenuRecursive($item['items']);
                    echo CHtml::closeTag('ul') . "\n";
                }
            }

            echo CHtml::closeTag('li') . "\n";
        }
    }

}