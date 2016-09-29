<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2template',
            'username' => 'yii2template',
            'password' => 'l6GBTyM8zs',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LfW7wcUAAAAAPjOhJjhBy_lzbn0wx9J3bQ61Ruh',
            'secret' => '6LfW7wcUAAAAADt-50rYd8xUmExArxY8hTA9jnEu',
        ],
    ],
];
