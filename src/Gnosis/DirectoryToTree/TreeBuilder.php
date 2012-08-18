<?php

namespace Gnosis\DirectoryToTree;

class TreeBuilder {

	protected $final;
	
	public function __construct($paths){
		$this->final = array();
	    foreach ($paths as $p){
	    	$content = &$this->final;
	    	$parts = explode("/", $p);
	    	if (count($parts) == 1){
	    		$content[] = $parts[0];
	    		continue;
	    	}

	    	while ($next = array_shift($parts)){
	    		if (strtolower($next) == "index.md"){ continue; }
	    		if (!isset($content[$next])){
	    			$content[$next] = array();
	    		}
	    		$content = &$content[$next];
	    	}

	    }

	    // Horrible hack to get Home first
	    $index = array_search("home.md", $this->final);
	    if ($index !== false){
		    $home = $this->final[$index];
		    unset($this->final[$index]);
		    array_unshift($this->final, $home);
		}


		if (count($this->final) == 0){
			throw new \Exception("No files exist in the content directory. Shutting down.");
		}

	    $this->final = $this->reformat($this->final);


	    return $this;

	}

	private function reformat($values, $parent=''){
		$level = 0;
		$data = array();
		$orig_parent = $parent;

		foreach ($values as $k => $v){
			$parent = $orig_parent;
			if (is_array($v) && count($v)){
				$data[$k]['title'] = $k;
				$data[$k]['filename'] = $parent.'/'. ($k ?: $v);
				$children = $v;

				if (count($children)){
					$parent = $parent.'/'.$k;
					$data[$k]['children'] = $this->reformat($children, $parent);
					$data[$k]['parent'] = $parent;
				}
			}
			else
			{
				$data[$k]['title'] = $k ?: $v;
				$data[$k]['filename'] = $parent.'/'. ($k ?: $v);
			}

			$data[$k] = (object) $data[$k];
		}

		return array_values($data);
	}

	public function getTree(){
		return $this->final;
	}

}