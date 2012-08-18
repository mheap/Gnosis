<?php

namespace Gnosis\DirectoryToTree;

class SplFileInfo extends \SplFileInfo {
	public function getRelativePathname(){
		$parts = explode("content/", $this->getPathname());
		return $parts[1];
	}
}