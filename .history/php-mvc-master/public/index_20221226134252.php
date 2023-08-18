<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);

$router->add('seminar/?', ['controller' => 'PartnerController', 'action' => 'seminar']);
$router->add('partner/?', ['controller' => 'PartnerController', 'action' => 'partner']);
$router->add('partner1/?', ['controller' => 'PartnerController', 'action' => 'partner1']);
$router->add('importfile/?', ['controller' => 'PartnerController', 'action' => 'importFile']);
$router->add('importfolder/?', ['controller' => 'PartnerController', 'action' => 'importFolder']);
$router->add('witchWindow/?', ['controller' => 'PartnerController', 'action' => 'witchWindow']);
$router->add('checkTwoside/?', ['controller' => 'PartnerController', 'action' => 'checkTwoside']);
$router->add('testClickPDF/?', ['controller' => 'PartnerController', 'action' => 'testClickPDF']);
$router->add('checkSaagLogin/?', ['controller' => 'PartnerController', 'action' => 'checkSaagLogin']);
$router->add('checkSospLogin/?', ['controller' => 'PartnerController', 'action' => 'checkSospLogin']);
$router->add('checkSoupLogin/?', ['controller' => 'PartnerController', 'action' => 'checkSoupLogin']);
$router->add('checkSoiLogin/?', ['controller' => 'PartnerController', 'action' => 'checkSoiLogin']);
$router->add('checkAdminLogin/?', ['controller' => 'PartnerController', 'action' => 'checkAdminLogin']);
$router->add('checkTotal/?', ['controller' => 'PartnerController', 'action' => 'checkTotal']);
///shokokai
// $router->add('checkShokokai/?', ['controller' => 'ShokokaiController', 'action' => 'index']);
$router->add('checkShokokai/?', ['controller' => 'Shokokai\ShokokaiController', 'action' => 'index']);


$router->add('{controller}/{action}');
$router->dispatch($_SERVER['QUERY_STRING']);
