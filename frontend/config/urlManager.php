<?php
return [
    'class' => 'yii\web\UrlManager',
    'baseUrl' => '',
    'showScriptName' => false,   // Disable index.php
    'enablePrettyUrl' => true,   // Disable r= routes
    'enableStrictParsing' => false,
    'rules' => [
        'site/<typeSlug>/<titleSlug>' => 'site/page',
    ],
];