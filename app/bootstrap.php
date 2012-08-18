<?php

require_once __DIR__.'/../vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

$app = new Gnosis\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'/../templates',
));

$app->register(new SilexExtension\MarkdownExtension(), array(
    'markdown.class_path' => __DIR__ . '/../vendor/knplabs-markdown',
));

return $app;
