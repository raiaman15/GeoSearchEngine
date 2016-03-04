<?php

namespace App\Library;

class BTree {
	protected $root;
	public $degree = 3;

	public function __construct() {
		$this->root = null;
		$this->degree = 3;
	}

	public function currentNode() {
		return $this->root;
	}

	public function create() {
		$node = new BNode();
		$node->leaf = true;
		$node->n = 0;
		// diskwrite [x]
		$this->root = $node;
	}

	public function splitChild($x, $i) {
		$t = $this->degree;
		$z = new BNode();
		$y = $x->c[$i];
		$z->leaf = $y->leaf;
		$z->n = $t - 1;
		for($j = 1; $j <= $t -1; $j++) {
			$z->key[$j] = $y->key[$j + $t];
			$z->doc[$j] = $y->doc[$j + $t];
		}
		for($j = 1; $j <= $t -1; $j++) {
			array_pop($y->doc);
			array_pop($y->key);
		}
		if($y->leaf == false) {
			for($j = 1; $j <= $t; $j ++) {
				$z->c[$j] = $y->c[$j + $t];
			}
			for($j = 1; $j <= $t; $j ++) {
				array_pop($y->c);
			}
		}
		$y->n = $t - 1;
		for($j = $x->n +1 ; $j >= $i+1; $j --) {
			$x->c[$j + 1] = $x->c[$j];
		}
		$x->c[$i + 1] = $z;
		for($j = $x->n ; $j >= $i; $j --) {
			$x->key[$j + 1] = $x->key[$j];
			$x->doc[$j + 1] = $x->doc[$j];
		}
		$x->key[$i] = $y->key[$t];
		array_pop($y->key);
		$x->doc[$i] = $y->doc[$t];
		array_pop($y->doc);
		$x->n = $x->n + 1;
		// $arr = array($x, $y, $z);
		return $x;
		// disk write y , z, x
	}
	public function isEmpty() {
		return $this->root === null;
	}

	public function insert($k) {
		$t = $this->degree;

		if($this->isEmpty()) {
			$this->create();
		}
		$r = $this->root;
		if($r->n == ($t*2 - 1)) {
			$s = new BNode();
			$this->root = $s;
			$s->leaf = false;
			$s->n = 0;
			$s->c[1] = $r;
			$s = $this->splitChild($s, 1);
			$this->insertNonFull($s, $k);
		}
		else $this->insertNonFull($r, $k);
	}

	public function insertNonFull($x, $k) {
		$i = $x->n;
		$t = $this->degree;
		if($x->leaf) {
			while($i >= 1 && strcmp($k[0] , $x->key[$i]) < 0) {
				$x->key[$i + 1] = $x->key[$i];
				$x->doc[$i + 1] = $x->doc[$i];
				$i = $i - 1;
			}
			$x->key[$i + 1] = $k[0];
			$x->doc[$i + 1] = $k[1];
			$x->n = $x->n + 1;
			// diskwrite x
		}
		else {
			while($i >= 1 && strcmp($k[0] , $x->key[$i]) < 0) {
				$i = $i - 1;
			}
			$i = $i + 1;
			// disk read x.c[i]
			if($x->c[$i]->n == ($t*2 - 1)) {
				$x = $this->splitChild($x, $i);
				if(strcmp($k[0] , $x->key[$i]) > 0) {
					$i = $i +1;
				}
			}

			$this->insertNonFull($x->c[$i], $k);
		}
	}

	public function traverse() {
		$this->root->dump();
	}
}
?>