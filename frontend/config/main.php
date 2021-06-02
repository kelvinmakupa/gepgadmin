<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-frontend',
	'name'=>'UDOM API',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' =>'Africa/Nairobi',
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
//        'gii' => [
//            'class' => 'yii\gii\Module',
//            'allowedIPs' => ['*'], // adjust this to your needs
//        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',      
			'class' => 'common\components\Request',
			'web'=> '/frontend/web'
        ],
		
		 'view' => [
         'theme' => [
             'pathMap' => [
                '@app/views' => '@app/theme/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
             ],
         ],
    ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => 'gepg_admin', 'httpOnly' => true],
			'authTimeout' => 600,
        ],

		'session' => [
            'timeout' => 600,
            'class' => '\frontend\components\DbSession',
            'sessionTable' => 'session',     
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'baseUrl' => $baseUrl,
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
        // 'urlManager' => [
        // 'class' => 'yii\web\UrlManager',
        // // Disable index.php
        // 'showScriptName' => false,
        // // Disable r= routes
		// 'suffix'=>'.aspx',
        // 'enablePrettyUrl' => false,
        //     'rules' => array(
        //        	['class' => 'common\helpers\UrlRule'],
        //         'information'=>'site/dashboard',
        //         '/'=>'site/index',
        //         'auth'=>'site/login',
		// 		'<controller:\w+>/<id:\d+>' => '<controller>/<action>',
        //         '<controller:\w+>/<id:\d+>/<action:\w+>' => '<controller>/<action>',
        //         '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        // ),
        // ],
		'authManager'=>[
			'class'=>'yii\rbac\DbManager',
		],
        
    ],
    'params' => $params,
];
