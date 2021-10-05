<?php
/**
 * Main Helper
 */
class Y extends CComponent
{
    static function app(){  return Yii::app();  }
    static function contr(){  return Yii::app()->controller;  }
    static function cs(){  return Yii::app()->clientScript;  }
    static function user_id(){  return Yii::app()->user->id;  }
    static function hostInfo(){  return Yii::app()->request->hostInfo;  }

    static function path($alias){
        return Yii::getPathOfAlias($alias);
    }
    static function publish($assets_path, $forceCopy=false){
        return Yii::app()->assetManager->publish($assets_path, false, -1, $forceCopy);
    }
    static function cookie($name){
        return Yii::app()->request->cookies[$name]->value;
    }
    static function inArrayCookie($name, $elem, $delim = '~'){
        return in_array($elem,explode($delim,self::cookie($name) ) );
    }
    static function params($name){
        return Y::app()->params[$name];
    }


    public static function getIdByAttr($model,$str){
        return CHtml::getIdByName(CHtml::resolveName($model,$str));
    }

    static function translitIt($source, $clean = true){
        $replaceList = array(
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G", "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I", "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T", "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH", "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
            "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b", "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j", "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
            "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r", "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h", "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"",
            "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", " "=>"-", 'ё'=>'jo', 'Ё'=>'JO',  );
        $cleanList = array( '`&([a-z]+)(acute|grave|circ|cedil|tilde|uml|lig|ring|caron|slash);`i' => '\1','`&(amp;)?[^;]+;`i' => '-','`[^a-z0-9]`i' => '-','`[-]+`' => '-',);
        $source = str_replace(array_keys($replaceList), array_values($replaceList), $source);
        $source = htmlentities($source, ENT_COMPAT, 'UTF-8');
        if($clean) $source = preg_replace(array_keys($cleanList), array_values($cleanList), $source);
        $source = strtolower(trim($source, '-'));
        return $source;
    }

    public static function lang(){
        return Y::cookie('site_lang') ? Y::cookie('site_lang') : 'ru';
    }
    public static function langSfx(){
        if(self::lang() == 'en') return '_l2';
        if(self::lang() == 'de') return '_l3';
        return '';
    }
    public static function t($str, $tag_wrap=true, $params=array()){
        if($tag_wrap && Y::params('cfgName') != 'backend' )
            return CHtml::tag('span', array('class'=>'lang_span','data'=>$str), Yii::t('common',$str,$params));
        else return Yii::t('common',$str,$params);
    }

    public static function sqlExecute($sql){
        $command = Y::app()->db->createCommand($sql);
        $rezult = $command->execute();
        $command->reset();
        return $rezult;
    }
    public static function sqlQueryAll($sql){
        $command=Y::app()->db->createCommand($sql);
        return $command->queryAll();
    }
    public static function sqlInsert( $table_name,  $values){
        $sql = 'insert into '.$table_name.' set ';
        foreach($values as $_field_name => $_field_value)
            $sql .= $_field_name . '='.Y::app()->db->quoteValue($_field_value). ' , ';
        $sql = substr($sql, 0, -2);
        self::sqlExecute($sql);
    }
    public static function sqlUpdate( $table_name,  $values, $id=null)
    {
        if($id)
            if( self::sqlExecute('select * from '.$table_name.' where id='.$id) == 0 )
                $id = null;

        if($id) $sql = 'update '.$table_name.' set ';
        else $sql = 'insert into '.$table_name.' set ';

        foreach($values as $_field_name => $_field_value)
            $sql .= $_field_name . '='.Y::app()->db->quoteValue($_field_value). ' , ';
        $sql = substr($sql, 0, -2);

        if($id) $sql .= ' where id='.$id;

        self::sqlExecute($sql);
    }

    public static function months($num){
        $arr = array('01' => 'января', '02' => 'февраля', '03' => 'марта',
            '04' => 'апреля', '05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа',
            '09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря');
        $arr_en = array('01' => 'January', '02' => 'February', '03' => 'March',
            '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
            '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
        return self::lang() == 'en' ? $arr_en[$num] : $arr[$num];
    }
    public static function months2($num){
        $arr = array('01' => 'январь', '02' => 'февраль', '03' => 'март',
            '04' => 'апрель', '05' => 'май', '06' => 'июнь', '07' => 'июль', '08' => 'август',
            '09' => 'сентябрь', '10' => 'октябрь', '11' => 'ноябрь', '12' => 'декабрь');
        $arr_en = array('01' => 'January', '02' => 'February', '03' => 'March',
            '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
            '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
        return self::lang() == 'en' ? $arr_en[$num] : $arr[$num];
    }

    public static function toW1251($str){
        return iconv("utf-8","windows-1251", $str);
    }
    public static function toUtf8($str){
        return iconv("windows-1251","utf-8", $str);
    }
    public static function nl2_br($str){
        return str_replace(array("\r\n", "\r", "\n"), '<br>',  $str);
    }
    public static function cvsPrepare($str){
        return self::toW1251( self::nl2_br($str) );
    }

    public static function date_print($val, $format, $absolute = 1, $gmt_corr = false)
    {
        if ($val)
        {
            $val = $val + ($gmt_corr ? self::userGMT() : 0);
            $start_of_tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1);
            $start_of_today = mktime(0, 0, 0);
            $last_h = time() - $val;

            if ($last_h < 3600 && $last_h >= 0 && $absolute == 0){
                if($last_h < 60) return $last_h . ' ' . self::t('секунд назад');
                return round($last_h / 60) . ' ' . self::t('минут назад');
            }

            if ($val > $start_of_today && $val < $start_of_tomorrow && $absolute == 0)
                return self::t('Сегодня') . ', ' . date('H:i', $val);

            return date($format, $val);
        }
    }
    public static function date_print2($val,$time=false)
    {
        if(!$val) return;

        $start_of_tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1);
        $start_of_today = mktime(0, 0, 0);

        if ($val > $start_of_today && $val < $start_of_tomorrow && 1 > 0)
            $rezult = self::t('Сегодня') . ( $time ? '' : ', ' . date('H:i', $val) );
        else
        {
            $rezult = date('d.m.Y', $val);
            $arr = explode('.', $rezult);
            $rezult =  $arr[0] . ' ' . Y::months($arr[1]);
            if($arr[2] != date('Y')) $rezult .= ' ' . $arr[2];
        }

        if($time) $rezult .= ', '.date('h:i', $val);
        $rezult = CHtml::tag('span',array('style'=>'white-space: nowrap;'),$rezult);
        return $rezult;
    }
    public static function dayOfWeek($time)
    {
        $days = array(
            'Monday' => 'Понедельник',
            'Tuesday' => 'Вторник',
            'Wednesday' => 'Среда',
            'Thursday' => 'Четверг',
            'Friday' => 'Пятница',
            'Saturday' => 'Суббота',
            'Sunday' => 'Воскресенье',
        );
        return $days[date('l',$time)];
    }

    public static function userGMT(){
        if(!self::cookie('time_zone_offset')){
            echo "<script>var now = new Date();
                    $.cookie('time_zone_offset', now.getTimezoneOffset(), {'path':'/', expires: 1});</script>";
        }
        return self::cookie('time_zone_offset')/60*3600;
    }
    public static function isToday($time){
        $start_of_tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1);
        $start_of_today = mktime(0, 0, 0);
        return $time >= $start_of_today && $time < $start_of_tomorrow;
    }
    public static function isYesterday($time){
        $start_of_yesterday = mktime(0, 0, 0, date('m'), date('d') - 1);
        $start_of_today = mktime(0, 0, 0);
        return $time >= $start_of_yesterday && $time < $start_of_today;
    }

    public static function elrteOpts($opts)
    {
        $opts_adv = $opts['width'] ? "width: ".$opts['width']."," : '';
        $opts_adv .= $opts['height'] ? "height: ".$opts['height']."," : '';
        $allowSource = isset($opts['allowSource']) ? $opts['allowSource'] : 1;
        $fmOpen = $opts['fmOpen'] != 'disabled' ? 'fmOpen: editorElfinder' : '';
        $bar = "['save', 'copypaste', 'undoredo', 'style', 'alignment', 'colors',
                'indent', 'lists', 'format', 'links', 'elements', 'media']";
        if($opts['bar']) $bar = $opts['bar'];

        return "{ $opts_adv cssClass: 'el-rte', lang: 'ru',  toolbars: {tb:$bar}, denyTags:[],
                cssfiles: ['/assets_static/extentions/elRTE/css/elrte-inner.css'],
                toolbar: 'tb', allowSource: $allowSource, $fmOpen }";
    }
    public static function ckeOpts($opts=array())
    {
        if($opts['short'] && !User::isSlava()) $butt_list = "removeButtons : 'Source,Save,Templates,NewPage,Preview,Print,Cut,Copy,Paste,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Subscript,Superscript,RemoveFormat,NumberedList,BulletedList,Indent,Outdent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Image,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Styles,Format,Font,FontSize,Maximize,About,ShowBlocks'";
        else $butt_list = "removeButtons : 'Templates,Save,NewPage,Preview,Print,Cut,Copy,Paste,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,RemoveFormat,CreateDiv,Language,BidiRtl,BidiLtr,Flash,PageBreak,Iframe,Smiley,About,Styles'";

        return
            ($opts['height'] ? 'height:'.$opts['height'].',' : '' ).
            ($opts['width'] ? 'width:'.$opts['width'].',' : '' ).
            "filebrowserImageUploadUrl : 'ckeupload?dir=content/upload/c_images/',".
 			$butt_list;
    }

    public static function browser(){
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if(strpos($agent,'Firefox')>-1) return 'firefox';
        if(strpos($agent,'Chrome')>-1) return 'chrome';
        if(strpos($agent,'Opera')>-1) return 'opera';
        if(strpos($agent,'Safari')>-1) return 'safari';
        if(strpos($agent,'Trident')>-1) return 'msie';
        return 'unknown_browser';
    }

    public static function csvPrepare($str,$end_row=false){
        $str = str_replace(array("\r\n", "\r", "\n", ";"), '', $str);
        $str = iconv("utf-8", "windows-1251", $str );
        return $str. ($end_row ? "\r\n" : ';');
    }
    public static function generateCSV($data, $filename){
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-Disposition: inline; filename=\"" . $filename . ".csv\"");
        echo $data;
    }

    public static function getPostContent($url,$vals=array()){
        $opts = array('http' =>array( 'method'  => 'POST', 'content' => http_build_query($vals),
                'header'  => 'Content-type: application/x-www-form-urlencoded'  ));
        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context);
    }

    public static function helperField($str, $visible=0)
    {
        $rezult = '';
        $rezult .= '<div class="helper_ico '.($visible?'visible':'').'" onclick="helper_dialog_open(\''.$str.'\')">?</div>';
        return $rezult;
    }

    private static $h_s_cnt = 0;
    public static function helperSection($str, $title = 'Описание раздела')
    {
        self::$h_s_cnt++;
        $rezult = '';
        $rezult .= '<div class="helper_section_block ib" >';
        $rezult .= '<span>'.Y::t($title).':</span>';
        $rezult .= '<span class="helper_section_open " onclick="helper_section_open(this)">'
            .Y::t('показать').'</span>';
        $rezult .= '<span class="helper_section_close hide" onclick="helper_section_close(this)">'
            .Y::t('скрыть').'</span>';
        $rezult .= '<div class="helper_section_descr hide" style="font-style:normal; padding:5px;">'.Y::t($str).'</div>';
        return $rezult.'</div>';
    }

    public static function advFieldStart(){
        $opened = 0;
        return '
        <div class="row">
            <label class="ibi lable_w">'.Y::t('Рекомендуемые поля:').'</label>
            <span class="adv_fields_open a_button '.($opened?'hide':'ib').'" style="margin-left:-4px; margin-bottom:8px;"
                onclick="adv_fields_open(this)">'.Y::t('показать').'</span>
            <span class="adv_fields_close a_button '.($opened?'':'hide').'" onclick="adv_fields_close(this)">'.Y::t('скрыть').'</span>

            '. self::helperField('adv_str') .'
            <div class="adv_fields_block '.($opened?'':'hide').'" style="margin-top: 10px;">
        ';
    }
    public static function advFieldEnd(){  return '</div></div>';   }

    public static function advFieldFilterStart(){
        $opened = $_GET['adv_fields_filter_flag'] == 1;
        return '
            <div class="adv_f_butt" style="text-align:right; margin:5px 13px 0 0;">
                <span class="a_button" style=""  onclick="
                    $(\'#adv_fields_filter_block\').slideToggle();
                    var open_flag = $(\'#adv_fields_filter_flag\');
                    //open_flag.val( open_flag.val()==1 ? 0 : 1 );
                    open_flag.val(1);
                ">'.Y::t('Дополнительно').'</span>
            </div>
            <div id="adv_fields_filter_block" style="display: '.($opened?'block':'none').'; margin-top: 10px;">
            <input id="adv_fields_filter_flag" name="adv_fields_filter_flag"
                type="hidden" value="'.($opened?'1':'0').'">
        ';
    }
    public static function advFieldFilterEnd(){  return '</div>';   }

    public static function shortText($text, $max_chars = 250)
    {
        $text = strip_tags($text);
        if(iconv_strlen($text)>$max_chars)
            $text =  mb_substr($text,0,$max_chars-4,'UTF-8').'...';
        return $text;
    }
}


