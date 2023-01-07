<?php
include_once "./php/Router.php";
$route = new Route();

$route->add("/", "index.php");
$route->add("/debug", "debug.php");
$route->add("/install", "install.php");
$route->add("/setup", "setup.php");

$route->notFound("404.php");