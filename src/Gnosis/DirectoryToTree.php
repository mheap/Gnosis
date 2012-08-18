<?php

namespace Gnosis;

class DirectoryToTree {
	
	protected $directory;

	public function __construct($directory){
		$this->directory = $directory;
		return $this;
	}

	public function getPathTree($tree = null) {
		$tree = is_null($tree) ? $this->getTree() : $tree;

		foreach ($tree as $k => $v){
			$key = substr($this->format($v->filename, true), 1);	
			$tree[$key] = $v->filename;

			if (isset($v->children)){
				$tree = array_merge($tree, $this->getPathTree($v->children));
			}
			unset($tree[$k]);
		}

		return $tree;
	}

	public function getTree() {
		$iterator = new \RecursiveIteratorIterator(
		   new \RecursiveDirectoryIterator($this->directory)
		);
		$iterator->getInnerIterator()->setInfoClass('Gnosis\DirectoryToTree\SplFileInfo');
		$filenames = array();
	    foreach ($iterator as $fileinfo) {
			$filenames[] = $fileinfo->getRelativePathname();
	    }

	    $tb = new \Gnosis\DirectoryToTree\TreeBuilder($filenames);
	    return $tb->getTree();
	}

	public function getFormattedTree($tree=null){
		$tree = is_null($tree) ? $this->getTree() : $tree;
		
		foreach ($tree as &$v){
			$v->title = $this->format($v->title);
			$v->filename = $this->format($v->filename, true);
			if (isset($v->children)){
				$v->children = $this->getFormattedTree($v->children);
			}
		}

		return $tree;
	}

	protected function format($v, $url_friendly = false){
		// Replace any directory leading numbers
		$v = preg_replace("/[^\/]?\d+\-/", "", $v);

		// Replace any underscores with dashes or spaces
		$char = $url_friendly ? "-" : " ";
		$v = str_replace("-", $char, $v);

		// strtolower?
		if ($url_friendly){
			$v = strtolower($v);
		}

		// Strip off any ending .md|.markdown|.txt file endings
		$v = preg_replace("/\.(md|markdown|txt)$/", "", $v);
		return $v;
	}
}