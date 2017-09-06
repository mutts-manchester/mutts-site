<?php
require 'common.php';

// Figure out what page we were going for based on the request URI
$explodedUri = explode('/', $_SERVER['REQUEST_URI']);
$page = $explodedUri[count($explodedUri) - 1];
$template = $page == '' ? 'index.html.twig' : $page . '.html.twig';

// Initialise template variables
$vars = [];

// Check to see if an alert message has been set by something (e.g. subscribe.php)
if (array_key_exists('message', $_SESSION)) $vars['message'] = $_SESSION['message'];
if (array_key_exists('messageClass', $_SESSION)) $vars['messageClass'] = $_SESSION['messageClass'];

session_unset();

// Either render the page or a 404 if a template could not be found
if (file_exists('templates/' . $template))
    echo $twig->render($template, $vars);
else
{
    header('HTTP/1.0 404 Not Found');
    echo $twig->render('error.html.twig', array('code' => 404));
}
?>