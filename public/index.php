<?php
if (session_status() == PHP_SESSION_NONE) session_start();

require_once '../vendor/autoload.php';
require_once '../config/eloquent.php';
require_once '../config/blade.php';
require_once '../config/router.php';
require_once '../config/validator.php';


$router = router();
$request = request();

$response = $router->dispatch($request);
echo $response->getContent();