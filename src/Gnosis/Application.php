<?php

namespace Gnosis;

class Application extends \Silex\Application {
	public $twig_data = array();


	public function setData($key, $val){
		$this->twig_data[$key] = $val;
	}

	public function render($filename){
		return $this['twig']->render($filename, $this->twig_data);
	}
}