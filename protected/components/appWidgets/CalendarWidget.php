<?php

class CalendarWidget extends CWidget
{
    public $update = false;
    public $m_offset = 0;
    public $update_url = '/site/calendar';
    public $click_url = '/site/calendarclick';

    public function run()
    {
        $time = mktime(0, 0, 0, date('m') + $this->m_offset, 1, date('Y'));
        $month = date('n', $time);
        $year = date('Y', $time);

        if ($month < 1) $month = 1;

        $marders = $this->markedDays($month, $year);

        if($marders)
        foreach ($marders as $elem)
            $days_marked[date('j', $elem->date)] = 1;

        $dayofmonth = date('t', mktime(0, 0, 0, $month, 1, $year));
        $day_count = 1;
        $num = 0;
        for ($i = 0; $i < 7; $i++) { // 1. Первая неделя
            $dayofweek = date('w', mktime(0, 0, 0, $month, $day_count, $year));
            $dayofweek = $dayofweek - 1;
            if ($dayofweek == -1) $dayofweek = 6;
            if ($dayofweek == $i) {
                $week[$num][$i] = $day_count;
                $day_count++;
            }
            else $week[$num][$i] = "";
        }
        while (true) { // 2. Последующие недели месяца
            $num++;
            for ($i = 0; $i < 7; $i++) {
                $week[$num][$i] = $day_count;
                $day_count++;
                if ($day_count > $dayofmonth) break;
            }
            if ($day_count > $dayofmonth) break;
        }
        ?>

    <?if(!$this->update){?><div id="<?=$this->id?>" style=""><?}?>

        <div class="calendar_header" style="">
            <table width="100%" cellpadding="0" cellspacing="0"><tr>
                <td>
                    <?if($this->m_offset>0){?>
                    <img src="/assets_static/images/front/arr_l.jpg" onclick="calendar_prev()"
                         style="cursor: pointer; vertical-align: -3px; margin-right: 27px;">
                    <?}?>
                </td>
                <td>
                    <span class="ib" style="">Календарь</span>
                </td>
                <td align="right" style="width: 24px;">
                    <img src="/assets_static/images/front/arr_r.jpg" onclick="calendar_next()"
                         style="cursor: pointer; vertical-align: -3px;">
                </td>
            </tr></table>
        </div>
        <div style="padding: 15px;">
            <b style="font-size: 120%;"><?=Y::months2($month)?></b>
            <?if( $year != date('Y', time()) ) echo ', '.$year; ?>
        </div>
        <div style="margin: 0 9px; margin-top: -10px;">
            <table border=0 class="calendar_table" style="font-size: 130%; width: 100%;">
                <? for ($i = 0; $i < count($week); $i++) {
                echo "<tr>";
                for ($j = 0; $j < 7; $j++) {
                    $marked = $days_marked[$week[$i][$j]] ? 'mark' : '';
                    $today = '';
                    if( $year == date('Y', time()) && $month==date('n', time())
                        && $week[$i][$j]==date('d', time()) )
                        $today = 'cal_today';
                    $weekend = ($j == 5 || $j == 6) ? 'weekend' : '';
                    if (!empty($week[$i][$j])) {
                        ?>
                        <td class="<?=$marked . ' ' . $weekend . ' ' . $today?>"
                            align="center" valign="center">
                            <span onclick="<? if($marked) echo
                                'calendar_click(this,\''.$year.'-'.$month.'-'.$week[$i][$j].'\')' ?>">
                                <?=$week[$i][$j]>9?'':'0'?><?=$week[$i][$j]?>
                            </span>
                        </td>
                        <?
                    } else echo "<td>&nbsp;</td>";
                }
                echo "</tr>";
            }?>
            </table>
        </div>

    <?if(!$this->update){?></div><?}?>

    <style type="text/css">
        .calendar_header {
            background: #48545d; padding: 10px 5px 8px 15px;
            color: #ffffff; font-size: 120%; font-weight: bold;
        }
        .calendar_table span{color: #555555; display: inline-block; padding: 10px 2px 7px 7px;}
        .calendar_table .cal_today{ background: #ffffff; border-radius: 4px;}
        .calendar_table .mark span{ color: red; cursor: pointer;}
        .calendar_table .clicked{ font-weight: bold; font-size: 100%; background: #aaa;  border-radius: 4px; }
        .hr{border-top: 1px solid gray; border-bottom: 1px solid #ffffff;}
    </style>

    <script type="text/javascript">
        function calendar_next(){
            $.post('<?=$this->update_url?>?m_offset=<?=$this->m_offset+1?>',function(data){
                $('#cal_day_info').html('');
                $('#<?=$this->id?>').html(data);
            })
        }
        function calendar_prev(){
            $.post('<?=$this->update_url?>?m_offset=<?=$this->m_offset-1?>',function(data){
                $('#cal_day_info').html('');
                $('#<?=$this->id?>').html(data);
            })
        }
        function calendar_click(elem,date){
            $.post('<?=$this->click_url?>?date='+date,function(data){
                $('#cal_day_info').html(data);
                $('#cal_day_info').parent().css('height',724);
                $('.calendar_table td').each(function(){$(this).removeClass('clicked')})
                $(elem).parent().addClass('clicked');
            })
        }

        // кликаем на первый ивентовый день >= сегодня
        if( $('.calendar_table .cal_today').hasClass('mark') ) $('.cal_today').children().trigger('click');
        else{
            clicked = false;
            var cal_today = $('.calendar_table .cal_today').children().html();
            $('.calendar_table .mark').each( function( index, value ) {
                var elem = $(value).children();
                if( elem.html()>cal_today  && !clicked){ elem.trigger('click'); clicked = true;}
            })
        }

    </script>
    <?
    }

    public function markedDays($month,$year){
        return  Event::model()->findAll('published=1 and date>='.mktime(0, 0, 0, $month, 1, $year).
                    ' and date<'.mktime(0, 0, 0, $month+1, 1, $year)  );
    }
}


/*
public function actionCalendar($m_offset){
        $this->widget('CalendarWidget', array( 'id' => 'calendar', 'm_offset'=>$m_offset, 'update'=>true));
    }
public function actionCalendarclick($date){
    $time =  CDateTimeParser::parse($date, 'yyyy-M-d');
    $events = Event::model()->findAll(
        'published=1 and date>'.($time-3600*4).' and date<'.($time+3600*20).' order by start_time' );
    //echo count($events);
    ?>
        <div class="hr"></div>
        <b style="font-size: 120%; padding: 10px;" class="ib">
            <?if(date('j',$time)==date('j',time()) && date('m',$time)==date('m',time())) echo 'Сегодня, '?>
            <?if(date('j',$time)==date('j',time())+1 && date('m',$time)==date('m',time())) echo 'Завтра, '?>
            <?=date('j',$time).' '.Y::months(date('m',$time)).' '.date('Y',$time)?>
        </b>
        <div class="hr"></div>
        <?foreach($events as $key=>$elem){?>
            <div style="padding: 10px; font-size: 100%;" >
                <a href="<?=$elem->url?>" style="text-decoration: none;" target="_blank">
                    <b style="font-size: 120%"><?=$elem->title?></b><br>
                    <div style="padding: 5px 0; font-size: 90% !important;"><?=$elem->descr?></div>
                </a>
                <b><?=$elem->place?>
                    <?if($elem->start_time) echo ', '.$elem->start_time?></b>
            </div>
            <?if($key!=count($events)-1){?><div class="hr"></div><?}?>
        <?}?>
    <?
}
*/