<?php
/**
 * Created by JetBrains PhpStorm.
 * User: DodgeR
 * Date: 04.03.12
 * Time: 12:24
 * To change this template use File | Settings | File Templates.
 */

class VarDumper extends CVarDumper
{
    public static function dump($var, $return = false,$tmp=0)
    {
        if($return) return self::dumpAsString($var,10,true);
        else          echo self::dumpAsString($var,10,true);
    }
}