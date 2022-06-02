<?php
return array(
    'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
    'onEndRequest'=>create_function('$event', 'if(ob_get_level() == 1) return ob_end_flush();'),
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
		'ext.dropZoneUploader.UploadedFiles',
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
		'faq',
		'gallery',
		'news',
		'articles',
		'writings',
		'slideshow',
		'orders',
		'multimedia',
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
		'request'=>array(
			'enableCsrfValidation'=>true,
		),
		'jwt' => array(
			'class' => 'ext.jwt.JWT',
			'key' => base64_encode(md5('Rahbod-Avayeshahir-1396')),
		),
		'JGoogleAPI' => array(
			'class' => 'ext.google.JGoogleAPI',
			//Default authentication type to be used by the extension
			'defaultAuthenticationType'=>'webappAPI',

			//Account type Authentication data
//			'serviceAPI' => array(
//				'clientId' => 'YOUR_SERVICE_ACCOUNT_CLIENT_ID',
//				'clientEmail' => 'YOUR_SERVICE_ACCOUNT_CLIENT_EMAIL',
//				'keyFilePath' => 'THE_PATH_TO_YOUR_KEY_FILE',
//			),

			//You can define one of the authentication types or both (for a Service Account or Web Application Account)
			'webappAPI' => array(
				'clientId' => '847053315039-s41olq8kabaaee4dn5sk7hk4era5a6b4.apps.googleusercontent.com',
				'clientEmail' => 'yusef.mobasheri@gmail.com',
				'clientSecret' => 'nAsP8voWDtb2sm3ZC__ZlYit',
				'redirectUri' => '/site/googlereturn',
				'javascriptOrigins' => 'YOUR_WEB_APPLICATION_JAVASCRIPT_ORIGINS',
			),
			'simpleApiKey' => 'AIzaSyCAO1qkpCMAqznb0dhNKqgCgsqvVVWMqis',

			//Scopes needed to access the API data defined by authentication type
			'scopes' => array(
				'serviceAPI' => array(
					'drive' => array(
						'https://www.googleapis.com/auth/drive.file',
					),
				),
				'webappAPI' => array(
					'drive' => array(
						'https://www.googleapis.com/auth/drive',
						'https://www.googleapis.com/auth/drive.file',
//						'https://www.googleapis.com/auth/drive.readonly'
					),
				),
			),
			//Use objects when retriving data from api if true or an array if false
			'useObjects'=>true,
		),
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
                'sitemap'=>'site/sitemap',
                'sitemap.xml'=>'site/sitemapxml',
				'admins' => '/',
				'admins/login' => '/',
				'admins/dashboard' => '/',
				'moderators' => 'admins',
				'moderators/<any:(.*)>' => 'admins/<any>',
				'gii' => 'gii/default/index',
				'load' => 'writings/manage/ajaxLoad',
				'edit&translation' => 'orders/public/index',
				'edit&translation/<action:(delete|payment|bill)>/<id:\d+>' => 'orders/public/<action>',
				'edit&translation/verify' => 'orders/public/verify',
				'multimedia/<controller:\w+>/<id:\d+>/<title:(.*)>'=>'multimedia/<controller>/view',
				'multimedia/<controller:\w+>/<id:\d+>'=>'multimedia/<controller>/view',
				'multimedia/<controller:\w+>/tag/<id:\d+>/<title:(.*)>' => 'multimedia/<controller>/tag',
                '<action:(terms|forum|guidance|FAQ)>' => 'site/<action>',
				'gallery' => 'gallery/manage/index',
				'<module:(news|articles|writings)>/category/<id:\d+>/<title:(.*)>' => '<module>/category/view',
				'<module:(news|articles|writings)>/category/<id:\d+>' => '<module>/category/view',
				'<module:(news|articles|writings)>/tag/<id:\d+>/<title:(.*)>' => '<module>/manage/tag',
				'<module:(news|articles|writings)>/tag/<id:\d+>' => '<module>/manage/tag',
				'<module:(news|articles|writings)>/tag' => '<module>/manage/tag',
				'teachers/<id:\d+>/<title:(.*)>' => 'users/teachers/view',
				'<action:(login|logout|register|dashboard)>' => 'users/public/<action>',
                '<module:\w+>/<id:\d+>/<title:(.*)>'=>'<module>/manage/view',
				'<module:\w+>/manage/<id:\d+>'=>'<module>/manage/view',
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
				'<module:\w+>/'=>'<module>/manage/index',
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
//            'class'=>'ext.minScript.components.ExtMinScript',
            'coreScriptPosition' => CClientScript::POS_HEAD,
            'defaultScriptFilePosition' => CClientScript::POS_END,
        ),
		'coreMessages'=>array(
				'basePath'=>null,
		),
		'MellatPayment' => array(
			'class'=> 'ext.MellatPayment.MellatPayment',
			'terminalId' => '2034929',
			'userName' => 'avay988',
			'userPassword' => '90233241',
		),
		'SinaPayment' => array(
			'class'=> 'ext.SinaPayment.SinaPayment',
			'terminalId' => '21482455',
			'merchantId' => '21471505',
			'userName' => '21471505',
			'userPassword' => '21548598',
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
		'mailTheme'=>
				'<div style="display: block;width: 100%;"><h2 style="margin-bottom:0;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;display: block;width: 100%;background-color: #0b3762;line-height:60px;color:#fff;font-size: 24px;text-align: right;padding-right: 50px">آوای شهیر<span style="font-size: 14px;color:#f0f0f0"> - موسسه فرهنگی هنری آموزش زبان های خارجی</span></h2></div>
             <div style="display: inline-block;width: 100%;font-family:tahoma;line-height: 28px;">
                <div style="direction:rtl;display:block;overflow:hidden;border:1px solid #efefef;text-align: center;padding:15px;">{MessageBody}</div>
             </div>',
	),
);
