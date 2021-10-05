<?php

class StarRating extends CStarRating
{
    public $maxRating = 5;
    protected function getClientOptions(){
        return CMap::mergeArray(parent::getClientOptions(),array('required'=>true));
    }
}

?>