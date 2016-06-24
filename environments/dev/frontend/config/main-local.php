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
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'model' => [
                'class' => 'common\overrides\gii\model\Generator',
            ],
            'frontend-model' => [
                'class' => 'common\overrides\gii\model\Generator',
                'messageCategory' => 'frontend',
                'ns' => 'frontend\models',
                'name' => 'Frontend Model Generator',
                'description' => 'This generator generates an ActiveRecord class for the specified database table in frontend folder.',
            ],
        ],
    ];

}

return $config;
