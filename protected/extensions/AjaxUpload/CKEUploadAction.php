<?php

Yii::import("ext.AjaxUpload.qqFileUploader");

class CKEUploadAction extends CAction
{
    public function run()
    {
        $allowedExtensions = array('jpg','jpeg','png','gif','doc','pdf');
        $sizeLimit = 10 * 1024 * 1024;

        //$_GET['dir'] = 'content/upload/temp/';
        $_GET['fnum'] = 'upload';

        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($_GET['dir']);
        //VarDumper::dump($result);
        $url = '/'.$result['dir'].$result['filename'];
        if($result['error']) echo '<script>alert("'.$result['error'].'")</script>';
        else echo '<script type="text/javascript">
            window.parent.CKEDITOR.tools.callFunction("'.$_REQUEST['CKEditorFuncNum'].'", "'.$url.'");</script>';

    }
}
