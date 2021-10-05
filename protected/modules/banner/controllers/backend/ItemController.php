<?php

class ItemController extends BackEndController
{
    public $modelName = 'Banner';
    public $title = 'Элементы:';

    public function actionGetStat($from='',$to='',$banner_id=0)
    {
        $cr = new CDbCriteria();
        if($banner_id) $cr->compare('banner_id',$banner_id);
        if($from) $cr->compare('create_time>', CDateTimeParser::parse($from,'dd-MM-yyyy') );
        if($to) $cr->compare('create_time<', CDateTimeParser::parse($to,'dd-MM-yyyy')+3600*23.9 );

        $views = BannerView::model()->count($cr);
        $clicks = BannerClick::model()->count($cr);
        $ctr = $views > 0  ? round( ($clicks/$views)*100, 2 ) : 0;

        echo '<div class="st_lb">Показов:</div>'.$views.'<br>';
        echo '<div class="st_lb">Переходов:</div>'.$clicks.'<br>';
        echo '<div class="st_lb">CTR:</div>'.$ctr.'%<br>';
    }

    public function actionGetStats($banner_id)
    {
        //VarDumper::dump($_POST);
        $data = iconv("utf-8", "windows-1251",'Время перехода;страница перехода'."\r\n");
        $cr = new CDbCriteria();
        $cr->compare('banner_id',$banner_id);
        if($_POST['Banner']['stat_from'])
            $cr->compare('create_time>',$_POST['Banner']['stat_from']);
        if($_POST['Banner']['stat_to'])
            $cr->compare('create_time<',$_POST['Banner']['stat_to']);
        foreach(BannerClick::model()->findAll($cr) as $elem)
            $data .= date('d.m.Y h:i',$elem->create_time).';'.$elem->referer."\r\n";

        Y::generateCSV($data,'votes');
    }
}
