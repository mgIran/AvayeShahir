<?php
return array(
    'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
    'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'آوای شهیر',
    'timeZone' => 'Asia/Tehran',
    'theme' => 'abound',
    'language' => 'fa',
	// preloading 'log' component
	'preload'=>array('log','userCounter'),

	// autoloading model and component classes
	'import'=>array(
        'application.vendor.*',
        'application.models.*',
		'application.components.*',
		'ext.EasyMultiLanguage.*',
		'ext.yiiSortableModel.models.*',
		'application.modules.users.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'admins',
        'users',
        'setting',
        'pages',
		'courses',
		'personnel',
		'map',
		'gallery',
		'comments'=>array(
			//you may override default config for all connecting models
			'defaultModelConfig' => array(
				//only registered users can post comments
				'registeredOnly' => true,
				'useCaptcha' => true,
				//allow comment tree
				'allowSubcommenting' => true,
				//display comments after moderation
				'premoderate' => true,
				//action for postig comment
				'postCommentAction' => '/comments/comment/postComment',
				//super user condition(display comment list in admin view and automoderate comments)
				'isSuperuser'=>'Yii::app()->user->checkAccess("moderate")',
				//order direction for comments
				'orderComments'=>'DESC',
				'showEmail' => false
			),
			//the models for commenting
			'commentableModels'=>array(
				//model with individual settings
				'Pages'=>array(
					'registeredOnly'=>true,
					'useCaptcha'=>false,
					'premoderate' => false,
					'orderComments'=>'DESC',
					//config for create link to view model page(page with comments)
					'module' => 'pages',
					'pageUrl'=>array(
						'route'=>'pages/manage/view',
						'data'=>array('id'=>'id'),
					),
					// change translation file path
					'translationCategory' => 'offlineChat',
					// for labels translation ,this name should be lower case string
					'moduleObjectName' => 'message'
				),
			),
			//config for user models, which is used in application
			'userConfig'=>array(
				'class'=>'Users',
				'nameProperty'=>'userDetails.name',
				'emailProperty'=>'email',
			),
		),
	),

	// application components
	'components'=>array(
        'userCounter' => array(
            'class' => 'application.components.UserCounter',
            'tableUsers' => 'ym_counter_users',
            'tableSave' => 'ym_counter_save',
            'autoInstallTables' => true,
            'onlineTime' => 5, // min
        ),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
            'class' => 'WebUser',
		),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
        ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'class'=>'EMUrlManager',
			'urlFormat'=>'path',
            'showScriptName'=>false,
            'appendParams'=>true,
			'rules'=>array(
                'terms' => 'site/terms',
                'contactAdmin' => 'site/contactAdmin',
				'guidance' => 'site/guidance',
				'gallery' => 'gallery/manage/index',
				'teachers/<id:\d+>/<title:(.*)>' => 'users/teachers/view',
				'<action:(login|logout|register|dashboard)>' => 'users/public/<action>',
                '<module:\w+>/<id:\d+>/<title:(.*)>'=>'<module>/manage/view',
				'<module:\w+>/<id:\d+>'=>'<module>/manage/view',
				'<module:\w+>/<controller:\w+>'=>'<module>/<controller>/index',
				'<module:\w+>/<controller:\w+>/<id:\d+>/<title:\w+>'=>'<module>/<controller>/view',
				'<controller:\w+>/<id:\d+>/<title:(.*)>'=>'<controller>/view',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>/view',
				'<module:\w+>/<controller:\w+>/<action:\w+>/*'=>'<module>/<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/view',
				'<module:\w+>/<title:(.*)>/<id:\d+>/*'=>'<module>/manage/view',
				'<module:\w+>/<title:(.*)>/<id:\d+>'=>'<module>/manage/view',
            ),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels'=>'error, warning, trace, info',
                    'categories'=>'application.*',
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => YII_DEBUG,
                    'levels'=>'error, warning, trace, info',
                    'categories'=>'application.*',
                    'showInFireBug' => true,
                ),
			),
		),
        'clientScript'=>array(
            //'class'=>'ext.minScript.components.ExtMinScript',
            'coreScriptPosition' => CClientScript::POS_HEAD,
            'defaultScriptFilePosition' => CClientScript::POS_END,
        ),
		'coreMessages'=>array(
				'basePath'=>null,
		),
    ),
    'controllerMap' => array(
        'min' => array(
            'class' =>'ext.minScript.controllers.ExtMinScriptController',
        )
    ),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'pardis@avayeshahir.com',
        'no-reply-email' => 'noreply@avayeshahir.com',
		'languages'=>array(
				'fa' => 'فارسی',
				'en' => 'English',
		),
		'default_language' => 'fa',
	),
);
