<?php

require_once('vendor/autoload.php');

$loader = new \Twig\Loader\Filesystemloader('templates');
$twig = new \Twig\Environment($loader);