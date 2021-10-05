<?php



class CropperAction extends CAction
{
    public function run($fname)
    {
        //print_r($_POST);
        $path =  '/content/upload/temp/';
        $thumb = Yii::app()->thumb;
        $thumb->thumbsDirectory = $_SERVER['DOCUMENT_ROOT'] . $path;
        $thumb->load( $_SERVER['DOCUMENT_ROOT'] . $path . $fname);

        /*$dims = $thumb->image->getCurrentDimensions();
        $coeff_cr = $_POST['width'] / $_POST['height'];
        $coeff_i = $dims['width'] / $dims['height'];

        if($coeff_i>$coeff_cr)
            $thumb->resize($_POST['width']*10, $_POST['height']);
        else $thumb->resize($_POST['width'], $_POST['height']*10);*/

        $coeff = $_POST['img_wn']/$_POST['img_w'];

        $thumb->crop(
            ($_POST['crb_l']-$_POST['img_l'])*$coeff,
            ($_POST['crb_t']-$_POST['img_t'])*$coeff,
            $_POST['crb_w']*$coeff,
            $_POST['crb_h']*$coeff
        );

        $thumb->resize($_POST['crop_w'], $_POST['crop_h']);

        $thumb->save('cr_'.$fname);
        echo $path . 'cr_'.$fname;
    }
}
