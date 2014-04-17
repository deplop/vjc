<?php

date_default_timezone_set('Asia/Saigon');
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';
$facebook = dirname(__FILE__).'/protected/extensions/facebook/facebook.php';
$global = dirname(__FILE__).'/protected/global.php';


require_once($yii);
require_once($facebook);
require_once ($global);

Yii::createConsoleApplication($config)->run();

?>