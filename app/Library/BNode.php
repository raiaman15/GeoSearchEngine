<?php

namespace App\Library;

class BNode {
	public $leaf;
	public $n;
	public $c;
	public $key;
	public $doc;
	public function __construct() {
		$this->c = null;
		$this->n = 0;
		$this->leaf = true;
		$this->key = null;
		$this->doc = null;
	}

	public function dump() {
		var_dump($this->key);
		var_dump($this->doc);
		if($this->c !== null) {
			echo "Child {";
			foreach($this->c as $v)
				$v->dump();
			echo " }";
		}
	}
}

?>