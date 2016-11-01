<?php
/**
 * Created by PhpStorm.
 * User: dm
 * Date: 31/10/16
 * Time: 6:53 PM
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

require(__DIR__ . '/config/bootstrap.php');

$config = require(__DIR__ . '/config/api.php');

(new yii\web\Application($config))->run();