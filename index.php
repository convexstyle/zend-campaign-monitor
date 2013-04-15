<?php
/**
 * index.php
 * 
 * @author:    convexstyle
 * @version:   1.0
 * @copyright: 2013,convexstyle.com
 * @license:   convexstyle
 * @version:   Release: @1.0@
 * @since:     Class available Since Release 1.0
 */

// Set Path Separater
if(!defined('PATH_SEPARATOR')) {
    if(substr(strtoupper(PHP_OS), 0, 3) == 'WIN') {
        define('PATH_SEPARATOR', ';');
    } else {
        define('PATH_SEPARATOR', ':');
    }
}

// Set the Application Path
defined('APPLICATION_PATH') 
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/_application/'));
	
// Set the global Variables
define('LIB_BASE', APPLICATION_PATH . '/libs/');

// Set the include Path
$paths = array(
	LIB_BASE,
	get_include_path()
);
set_include_path(implode(PATH_SEPARATOR, $paths));

// AutomateLoader
require_once('Zend/Loader/Autoloader.php');
$autoLoader = Zend_Loader_Autoloader::getInstance();
$autoLoader->setFallbackAutoloader(true)->pushAutoloader(NULL, 'Smarty_');


$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
    'EmailAddress' => $email,
    'Name'         => $name,
    'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('API Key', 'List ID', Convexstyle_Service_CampaignMonitor_Subscribe::XML);
try {
    $subscribe = $campaignMonitor->addSubscriber($values);
    if($subscribe->result() == $values['EmailAddress']) {
    	echo 'success';	
    }
} catch(Exception $e) {
    // Deal with errors 
    Zend_Debug::dump($e->getBody());
}