<?php
//$this->widget('BannerPlaceWidget',array('place_id'=>1))

Yii::import('CWidget');

class BannerPlaceWidget extends CWidget
{
    public $place_id;
    public $cnt_len = 0;
    public $_view = '_banner';
    public $random = false;
    public $target = '_blank';
    public $wrap_style;
    public $show_all = false;

    private $banners;
    private $place;

    public function run(){
        $criteria = new CDbCriteria();
        $criteria->compare('published', 1);
        $criteria->compare('place_id', $this->place_id);
        $criteria->compare('from_time<', time());
        $criteria->compare('to_time>', (time()-3600*24));
        if($this->random) $criteria->order = 'rand()';
        else $criteria->order = 'position asc, rotation_percent desc';

        $this->banners = Banner::model()->findAll($criteria);
        $this->place = BannerPlace::model()->findByPK($this->place_id);

        if(!count($this->banners)) return;

        $this->controller->renderDynamic(array($this,'runD'));
    }

    public function runD()
    {

        $rezult = '<div style="'.$this->wrap_style.'" id="'.$this->id.'">';
        $none = 0; $viewed = 0;  $p_summ = 0;

        while($none++<10)
        {
            foreach($this->banners as $banner)
            {
                $show = rand(0,100-$p_summ) <= $banner->rotation_percent;
                if(!$this->place->stretches) $p_summ += $banner->rotation_percent;
                if($show){
                    $viewed++;
                    $banner->view();
                    $layout = $this->_view.($banner->type==Banner::TYPE_TIZER ? '_tiz' : '');
                    $rezult .= $this->render($layout,array('banner'=>$banner),true);
                    $none = 10;
                    if(!$this->place->stretches && !$this->show_all) break;
                    if($this->cnt_len && $viewed >= $this->cnt_len && !$this->show_all) break;
                }
            }
        }

        /*$arr = array();
        for($i=0;$i<1000;$i++)
        {
            $p_summ = 0;
            foreach($this->banners as $banner)
            {
                $show = rand(0,100-$p_summ) < $banner->rotation_percent;
                $p_summ += $banner->rotation_percent;
                if($show){
                    $arr[$banner->id]++;
                    if(!$this->place->stretches) break;
                }
            }
        }
        ksort($arr);
        VarDumper::dump($arr);*/

        return $rezult.'</div>';
    }
}