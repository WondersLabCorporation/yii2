<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'common\overrides\gii\model\Generator',
            ],
            'backend-model' => [
                'class' => 'common\overrides\gii\model\Generator',
                'messageCategory' => 'frontend',
                'ns' => 'backend\models',
                'name' => 'Backend Model Generator',
                'description' => 'This generator generates an ActiveRecord class for the specified database table in frontend folder.',
            ],
            'crud' => [
                'class' => 'yii\gii\generators\crud\Generator',
                'baseControllerClass' => 'backend\components\BaseController',
                'templates' => [ //setting for out templates
                    'default' => '@backend/components/gii/crud/default',
                ]
            ],
        ],
    ];
}

return $config;
