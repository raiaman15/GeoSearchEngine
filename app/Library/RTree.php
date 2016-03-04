<?php

namespace App\Library;

class RTree {
	protected $root;
	public $cLevel;

	public function __construct() {
		$this->root = null;
		$this->cLevel = 5;
	}	

	public function isEmpty() {
		return $this->root === null;
	}

	public function insert($a) {
		$minx = $a[0];
		$maxx = $a[1];
		$miny = $a[2];
		$maxy = $a[3];
		$node = new RNode($minx, $maxx, $miny, $maxy);
		$this->root = $node;
		$tree = $this->createSubtree($this->root, $this->cLevel);
		return $tree;
	}

	public function createSubtree(&$tree, $lev) {
		$midx = ($tree->lowerx + $tree->upperx) / 2;
		$midy = ($tree->lowery + $tree->uppery) / 2;
		if($lev == 0)
			return $tree;
		else {
			$tree->nw = new RNode($tree->lowerx, $midx, $midy, $tree->uppery);
			$tree->ne = new RNode($midx, $tree->upperx, $midy, $tree->uppery);
			$tree->sw = new RNode($tree->lowerx, $midx, $tree->lowery, $midy);
			$tree->se = new RNode($midx, $tree->upperx, $tree->lowery, $midy);
			$this->createSubtree($tree->nw, $lev - 1);
			$this->createSubtree($tree->ne, $lev - 1);
			$this->createSubtree($tree->sw, $lev - 1);
			$this->createSubtree($tree->se, $lev - 1);
		}
	}

	public function currentNode() {
		return $this->root;
	}
}

?>