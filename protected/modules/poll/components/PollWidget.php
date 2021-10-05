<?php

Yii::import('CWidget');

class PollWidget extends CWidget
{
    public $poll;
    public $poll_id;
    public $show_rez = false;
    public $preview = false;
    public $show_arch = false;
    public $partial = false;
    public $template = '';

	public  function run()
	{
        if($this->poll_id) $this->poll = PollItem::model()->findByPk($this->poll_id);
        if(!$this->poll->id){ Yii::log('PollWidget - id = null'); return; }
        if($this->poll->published == 0 && Yii::app()->params['cfgName'] == 'frontend') return;
        $elems = PollElement::model()->findAll('owner='.$this->poll->id.' order by position asc, id asc');
        if(!count($elems)) return;

        if(!$this->partial){
            echo '<div class="poll" id="poll_widget_'.$this->poll->id.'">';
            echo '<div class="poll-title">'.$this->poll->title.'</div>';
            echo '<div class="data">';
        }

        if( !$this->show_rez && !PollItem::voted($this->poll->id) && !$this->poll->finished)
        {
            $this->render('_vote_list'.$this->template, array('elems'=>$elems));
        }
        else
        {
            $this->render('_vote_rezult'.$this->template, array('elems'=>$elems));
        }

        if($this->show_arch) echo '<a href="/poll" style="margin: 10px 15px;" class="ib">Архив опросов</a>';

        if(!$this->partial)
            echo '</div></div>';
	}

    public function getFadeMiddleColor( $i ,$n, $aRGBStart, $aRGBFinish )
    {
        $finishPercent = $i/$n;
        $startPercent = 1 - $finishPercent;
        $R = floor( ($aRGBStart[0]) * $startPercent + ($aRGBFinish[0]) * $finishPercent );
        $G = floor( ($aRGBStart[1]) * $startPercent + ($aRGBFinish[1]) * $finishPercent );
        $B = floor( ($aRGBStart[2]) * $startPercent + ($aRGBFinish[2]) * $finishPercent );
        return '#'.$this->dechex_f($R).$this->dechex_f($G).$this->dechex_f($B);
    }

    public function dechex_f($val){
        $hex = dechex($val);
        return strlen($hex) > 1 ? $hex : '0'.$hex;
    }
}