<?php

namespace App\Library;

class WaveletNode {
	public $parent;
	public $value;
	public $left;
	public $right;
	public $bmap;

	public function __construct($a, $b) {
		$this->parent = null;
		$this->value = $a;
		$this->bmap = $b;
		$this->left = null;
		$this->right = null;
	}
}
?>