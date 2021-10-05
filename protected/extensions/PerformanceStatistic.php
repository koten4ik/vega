<?php
class PerformanceStatistic extends CWidget
{
    public function run()
    {
        $dbStat = Yii::app()->db->getStats();
        $dbcnt = $dbStat[0];
        $dbtime = round( $dbStat[1], 3 );
        $memory = round(Yii::getLogger()->memoryUsage / 1024 / 1024, 3);
        $time = round(Yii::getLogger()->executionTime, 3);
        echo "<div class='stat' id='stat'>
            <div style='float:left;padding-right:5px'> время: $time </div>
            <div style='float:left;padding-right:5px'> дб-время: $dbtime </div>
            <div style='float:left;padding-right:5px'> запросов: $dbcnt </div>
            <div style='float:left;padding-right:5px'> память: $memory </div>

        </div>";
    }
}