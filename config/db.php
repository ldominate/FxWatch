<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=fxwatch',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
	'enableSchemaCache' => true,
	'schemaCacheDuration'=> 3600,
	'enableQueryCache' => false,
	'queryCacheDuration' => 3600
];
