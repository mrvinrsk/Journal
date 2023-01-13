<?php
include_once "./php/Router.php";
$route = new Route();

$route->add("/", "index.php");
$route->add("/auth", "auth.php");
$route->add("/account", "account.php");
$route->add("/write", "write.php");
$route->add("/read", "read-list.php");
$route->add("/read/{id}", "read-entry.php");
$route->add("/debug", "debug.php");
$route->add("/install", "install.php");
$route->add("/setup", "setup.php");
$route->add("/logout", "logout.php");

$route->notFound("/errors/4xx/404.php");