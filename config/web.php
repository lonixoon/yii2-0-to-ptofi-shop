<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'HCUjGachiSYcW5_d9BE_u1mD_pNM_UAx',
            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => '',
//                'username' => '',
//                'password' => '',
//                'port' => '587',
//                'encryption' => 'tls',
//            ],
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => true,
//        ],
        'mailer' => [
            'class' => 'boundstate\mailgun\Mailer',
            'key' => '',
            'domain' => 'sandbox5dad7209af824bef809f41db566c8746.mailgun.org',
            'useFileTransport' => false,
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            // конкертные правила должны стоять ВСЕГДА выше общих!
            'rules' => [
                // ЧПУ для пагинации в меню категорий
                'category/<id:\d+>/page/<page:\d+>' => 'category/view',
                // пишем правила для красивой ссылки в меню категорий
                'category/<id:\d+>' => 'category/view',
                // правило на карточку товара
                'product/<id:\d+>' => 'product/view',
                // правило на поиск
                'search' => 'category/search',
            ],
        ],
    ],
    'params' => $params,

    // мои параметры
    // выставляем русский язык для уведомлений
    'language' => 'ru-RU',
    // устанавливаем контроллер по умолчанию
    'defaultRoute' => 'category/index'
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
