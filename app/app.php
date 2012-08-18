<?php

$app = require_once __DIR__.'/bootstrap.php';

$app->error(function ($e) use ($app) {
    echo $e->getMessage();die;
});

$app->before(function() use ($app){
	$app['tree'] = new Gnosis\DirectoryToTree(__DIR__.'/../content/');
	$app->setData("files", $app['tree']->getFormattedTree());
});

$app->get('/{url}', function($url) use ($app) {
	$url = $url ?: 'home';

	// Breadcrumbs
	$paths = explode("/", $url);
	$newpaths = array();
	for($i=0; $i < count($paths); $i++){
		$prev = isset($newpaths[$i-1]) ? $newpaths[$i-1]['url'] : '';
		$newpaths[] = array(
			"url" => $prev.'/'.$paths[$i],
			"title" => str_replace("-", " ", $paths[$i])
		);
	}
	$current = array_pop($newpaths);
	$app->setData("breadcrumbs", $newpaths);
	$app->setData("finalBreadcrumb", $current);


	// Load up the content
	$pathMap = $app['tree']->getPathTree();

	if (!isset($pathMap[$url])){	
		throw new Exception("Invalid Page");
	}

	$currentFiles = array();
	$parenturl = explode("/", $url);
	do {
		if (!count($parenturl)){ continue; }
		$currentFiles[] = '/'.implode("/", $parenturl);
	} while (array_pop($parenturl));

	$app->setData("currentFiles", $currentFiles);

	$file = __DIR__.'/../content'.$pathMap[$url];
	if (is_dir($file)){
		$file = $file.'/index.md';
	}

	if (!file_exists($file)){
		$errfile = explode("content/", $file);
		$content = '<div class="alert alert-error">Content not found: '.$errfile[1].'</div>';
	}
	else
	{
		$content = file_get_contents($file);
	}
	
	$app->setData("content", $content);

	
	return $app->render('index.html');


})->assert('url', '.*');;

return $app;
