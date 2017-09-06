<?php
require_once 'vendor/autoload.php';
require 'config.php';

session_start();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache' => $twigCaching == true ? 'compilation_cache' : false,
));

?>