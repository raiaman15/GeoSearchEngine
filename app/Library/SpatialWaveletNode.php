<?php

namespace App\Library;

class SpatialWaveletNode {
	public $parent;
	public $upperBound;
	public $left;
	public $right;
	public $bmap;
	public $locid;

	public function __construct($a, $b, $c) {
		$this->parent = null;
		$this->upperBound = $a;
		$this->bmap = $b;
		$this->locid = $c;
		$this->left = null;
		$this->right = null;
	}

	public function dump() {
		if ($this->left !== null) {
            echo "left";
            $this->left->dump();
            
        }
        echo "{upperBound=";
        var_dump($this->upperBound);
        echo "}  {bmap=";
        var_dump($this->bmap);
        echo "}";
        if ($this->right !== null) {
            echo "right";
            $this->right->dump();
        	
        }
	}

}

?>