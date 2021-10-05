<?php

Yii::import('application.modules.content.controllers.frontend.*');

class MPageController extends PageController
{
    public $layout='/layouts/site_content';
    public $viewDir = 'application.modules.content.views.frontend.page.';
}
