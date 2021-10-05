<?php

/*
OpenGraph::add('og:title', 'title');
OpenGraph::add('og:description', 'descr');
OpenGraph::add('og:image', '/patch/');
OpenGraph::add('og:url', Yii::app()->getBaseUrl(true).'url');
OpenGraph::add('og:type', 'article');
OpenGraph::add('og:site_name', 'name');
*/

class OpenGraph
{
    public static $elems;

    public static function draw()
    {
        if(count(self::$elems))
        foreach(self::$elems as $property=>$content)
            echo '<meta property="'.$property.'" content="'. htmlspecialchars($content).'" />'."\n";
    }

    public static function add($property,$content)
    {
        self::$elems[$property] = self::$elems[$property] = str_replace('"','&quot;',$content);
    }

}