<?php


class ServiceController extends FrontEndController
{

    public function actionCkeUpload()
    {
        $error = null;
        $file = $_FILES['upload'];

        $dir = 'content/upload/inline_images/';
        if($_GET['max_size']) $max_size = $_GET['max_size'];
        else $max_size = 10;
        if($_GET['types']) $allowedExtensions = explode(',', $_GET['types']);
        else $allowedExtensions = array('jpg','jpeg','png');


        if (!is_writable($dir))
            $error = 'Ошибка записи в: ' . $dir;
        if ($error == null && !$file)
            $error = 'Нет загруженных файлов.';
        if ($error == null && $file['error'] > 0)
            $error = 'Ошибка загрузки: ' . $file['error'];
        if ($error == null && $file['size'] > $max_size * 1024 * 1024)
            $error = 'Превышен размер файла. Максимум: ' . $max_size . 'M';

        // проверка на разширение
        $pathinfo = pathinfo($file['name']);
        $filename = Y::translitIt($pathinfo['filename']);
        $ext = strtolower($pathinfo['extension']);
        if ($error == null && $allowedExtensions && !in_array(strtolower($ext), $allowedExtensions))
            $error = 'Разрешены только ' . $_GET['types'];

        // проверка на разрешение
        /*$min_res = explode('x', $_GET['min_res']);
        if ($error == null && $min_res[0] > 0 && $ext != 'svg') {
            $thumb = new \EasyPhpThumb();
            $thumb->load($file['tmp_name']);
            $dims = $thumb->image->getCurrentDimensions();
            if ($dims['width'] < $min_res[0] || $dims['height'] < $min_res[1])
                $error = 'Пожалуйста, загрузите картинку размера ' . $_GET['min_res'] . 'px или более.';
        }*/

        if ($error == null) {
            if (!move_uploaded_file($file['tmp_name'], $dir . $filename . '.' . $ext))
                $error = 'The upload was cancelled, or server error encountered';
        }

        if ($error) $result = array( 'uploaded' => false, 'error' => array('message'=>$error) );
        else $result = array( 'uploaded' => true, 'url' => '/' . $dir . $filename . '.' . $ext );

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }


}