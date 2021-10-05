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

foreach ($arr as $title => $val)
{
    $i++;
    $percent = round(($val / $total) * 100);
    $percent_gr = round($percent * $scale);
    if ($percent_gr > 100) $percent_gr = 100;
    ?>

    <div class="poll-element rezult">
        <div class="poll-rezult-line" style="background-size: <?=$percent?>% 100%;">
            <div class="poll-elem-percent"><?=$percent?> %</div>
            <div class="poll-elem-title"><?=$title?></div>
        </div>
    </div>


<? } ?>

<div class="poll-stats">
    <?=Y::t('Голосов')?>: <?=round($total)?>
</div>
