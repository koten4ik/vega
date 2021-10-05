<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Вега-Балка',
	'sourceLanguage'=>'ru_ru',
    'language'=>'ru',
    'charset'=>'utf-8',

    'defaultController' => 'site',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.components.sysComponents.*',
        'application.components.sysWidgets.*',
        'application.components.appWidgets.*',

        'application.modules.menu.models.*',
        'application.modules.menu.components.*',
        'application.modules.menu.MenuModule',

        'application.modules.base.models.*',
        'application.modules.base.components.*',

        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.user.UserModule',

        'application.modules.content.models.*',
        'application.modules.content.components.*',

        'application.modules.comments.models.*',
        'application.modules.comments.components.*',

        'application.modules.poll.models.*',
        'application.modules.poll.components.*',

        'application.modules.shop.ShopModule',
        'application.modules.shop.models.*',
        'application.modules.shop.components.*',
        'application.modules.shop.extensions.shoppingCart.*',

        'application.modules.banner.models.*',
        'application.modules.banner.components.*',

        'application.modules.location.models.*',
        'application.modules.location.components.*',

        // ext.regions
        'application.extensions.regions.models.*',
        'application.extensions.regions.RegionsWidget',

        //'application.extensions.ESetReturnUrlFilter',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'11111',
            'generatorPaths' => array('application.generators'),
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

        'base',
        'files',
        'user',
        'menu',

        'feedback',
        'content',
        'shop',
        'igallery',
        'banner',
        'comments',
        'poll',
        'location',
        'video',
	),



	// application components
	'components'=>array(

        'messages'=>array(
            'class'=>'CDbMessageSource',
            'translatedMessageTable'=>'tbl_base_message',
            'sourceMessageTable'=>'tbl_base_source_message'
        ),

        'thumb'=>array( 'class'=>'ext.phpthumb.EasyPhpThumb'),

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            //'loginUrl' => array('/user/login'),
            'class' => 'WebUser',
		),

        'authManager' => array(
            'class' => 'PhpAuthManager',
            'defaultRoles' => array(-1),
        ),
		// uncomment the following to enable URLs in path-format

        'clientScript' => array(
            /*'class'=>'ext.ExtendedClientScript.ExtendedClientScript',
            'combineCss'=>!YII_DEBUG,
            'compressCss'=>!YII_DEBUG,
            'combineJs'=>!YII_DEBUG,
            'compressJs'=>!YII_DEBUG,
            'fileUrl' => '/minify',*/
            'scriptMap' => array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.min.js' => false,
                'jquery-ui.css'=>false,
            ),
        ),

        'db' => require(dirname(__FILE__) . '/db.php'),


        'cache' => array(
            'class'=>'system.caching.CDbCache'
        ),

        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    //'class'=>'CFileLogRoute',
                    'class' => 'CProfileLogRoute',
                    //'levels'=>'trace',
                    'levels'=>'profile',
                    //'categories'=>'system.*',
                    'enabled'=>false
                ),
            ),
        ),

	),




	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
    'params' => require(dirname(__FILE__) . '/params.php'),

    'controllerMap'=>array(
        // ext.regions init
        'regions'=>array(
           'class'=>'ext.regions.RegionsController',
        ),
    ),


);