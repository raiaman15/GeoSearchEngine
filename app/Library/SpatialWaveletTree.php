<?php

namespace App\Library;

class SpatialWaveletTree {
	protected $root;

	public function __construct() {
		$this->root = null;
	}	

	public function isEmpty() {
		return $this->root === null;
	}

	public function insert($a, $b, $c) {
		$node = new SpatialWaveletNode($a, $b, $c);
		$this->root = $node;
		$this->root = $this->insertNode($this->root);
	}

	public function insertNode(&$subTree) {
		$lval = array(); $lbit = array(); $llocid = array();
		$rval = array(); $rbit = array(); $rlocid = array();

		$lenroot = count($subTree->upperBound);
		$z = 0;$y=0;
		for($i = 0; $i < $lenroot; $i ++) {
			if($subTree->bmap[$i] == 0) {
				$lval[$z] = $subTree->upperBound[$i];
				$llocid[$z] = $subTree->locid[$i];
				$z++;
			}
			else{
				$rval[$y] = $subTree->upperBound[$i];
				$rlocid[$y] = $subTree->locid[$i];
				$y++;
			}
		}
		if($z < $lenroot && $y < $lenroot) {
			$lbit = $this->calculatebmap($lval);
			$rbit = $this->calculatebmap($rval);

			$l = new SpatialWaveletNode($lval, $lbit, $llocid);
			$r = new SpatialWaveletNode($rval, $rbit, $rlocid);
			$subTree = $this->assignleft($subTree, $l);
			$subTree = $this->assignright($subTree, $r);
			$l = $this->assignparent($subTree, $l);
			$r = $this->assignparent($subTree, $r);
			$l = $this->insertNode($l);
			$r = $this->insertNode($r);
		}
		else if($subTree->upperBound != null) {
			// var_dump($subTree->upperBound);
			$subTree->upperBound = $subTree->upperBound[0];
			$subTree->locid = $subTree->locid[0];
			$subTree->bmap = 0;
		}
		return $subTree;
	}

	public function calculatebmap($a) {
		$b = array();
		$min = min(array_unique($a));
		$max = max(array_unique($a));
		for($i = 0; $i< count($a); $i++) {
			$val = $a[$i];
			if($val <= ($max+$min)/2)
				$b[$i] = 0;
			else $b[$i] = 1;
		}
		return $b;
	}

	public function assignleft($node, $l) {
		$node->left = $l;
		return $node;
	}

	public function assignright($node, $r) {
		$node->right = $r;
		return $node;
	}

	public function assignparent($node, $sub) {
		$sub->parent = $node;
		return $sub;
	}

	public function traverse() {
		$this->root->dump();
	}

	public function currentNode() {
		return $this->root;
	}

	public function storeInDb() {
		
	}
}

?>