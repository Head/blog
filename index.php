<?php

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
define('DSN', 'mysql://user:password@127.0.0.1/database');

require dirname(__FILE__) . '/autoload.php';
session_start();

$request = new sampleRequest($_REQUEST, $_SESSION);
$response = new sampleResponse();
$factory = new sampleFactory();

$sample = new sampleFrontController($request, $response, $factory);
$view = $sample->execute(isset($_GET["page"]) ? $_GET['page'] : 'home');

echo $view->render($request, $response);