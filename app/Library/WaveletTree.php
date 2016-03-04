<?php

namespace App\Library;

class WaveletTree {
	protected $root;

	public function __construct() {
		$this->root = null;
	}	

	public function isEmpty() {
		return $this->root === null;
	}

	public function insert($a, $b) {
		$node = new WaveletNode($a, $b);
		$this->root = $node;
		$this->root = $this->insertNode($this->root);
	}

	public function insertNode(&$subTree) {
		$lval = array(); $lbit = array();
		$rval = array(); $rbit = array();

		$lenroot = count($subTree->value);
		$z = 0;$y=0;
		for($i = 0; $i < $lenroot; $i ++) {
			if($subTree->bmap[$i] == 0) {
				$lval[$z] = $subTree->value[$i];
				// array_push($lval, $subTree->value[$i]);
				$z++;
			}
			else{
				$rval[$y] = $subTree->value[$i];
				$y++;
				// array_push($rval, $subTree->value[$i]);	
			}
		}
		if($z < $lenroot && $y < $lenroot) {
			$lbit = $this->calculatebmap($lval);
			$rbit = $this->calculatebmap($rval);

			$l = new WaveletNode($lval, $lbit);
			$r = new WaveletNode($rval, $rbit);
			$subTree = $this->assignleft($subTree, $l);
			$subTree = $this->assignright($subTree, $r);
			$l = $this->assignparent($subTree, $l);
			$r = $this->assignparent($subTree, $r);
			$l = $this->insertNode($l);
			$r = $this->insertNode($r);
		}
		else if($subTree->value != null) {
			$subTree->value = $subTree->value[0];
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
			if($val-$min <($max-$min + 1)/2)
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

	public function currentNode() {
		return $this->root;
	}

	public function storeInDb() {
		
	}
}
?>