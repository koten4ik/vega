<?
$total = 0.0001;
$max = 0.0001;
foreach ($elems as $elem)
{
    $votes = PollVote::model()->findAll('element_id=' . $elem->id . ' and poll_id=' . $this->poll->id);
    $count = count($votes);
    $arr[$elem->title] = $count;
    $total += $count;
    $max = $count > $max ? $count : $max;
}

$scale = 100 / (($max / $total) * 100);
$aRGBStart = array(0xfe, 0xaf, 0xb1);
$aRGBFinish = array(0xa4, 0x09, 0x0e);
$i = 0;

echo '<table style="width:575px; margin-top: 4px;">';
if ($arr)
    foreach ($arr as $title => $val)
    {
        $i++;
        $percent = round(($val / $total) * 100);
        $percent_gr = round($percent * $scale);
        if ($percent_gr > 100) $percent_gr = 100;
        echo '<tr><td style="width: 30%; text-align: right" valign="top">';
        echo '<span style="width: ' . $percent_gr . '%; height: 22px; background: ' . $this->getFadeMiddleColor($i, count($elems), $aRGBStart, $aRGBFinish) . ';" class="ib"></span>';
        echo '</td>';
        echo '<td style="width: 70%; height: 28px; text-align: left; padding-left: 6px; color: #555; font-size: 14px;">';
        echo $title . ' (' . $percent . '%)';
        echo '</td></tr>';
    }
echo '</table>';