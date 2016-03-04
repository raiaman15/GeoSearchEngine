<?php

namespace App\Library;

class BOperation {
	public function search($x, $k) {
		$i = 1;
		while($i <= $x->n && strcmp($k, $x->key[$i]) > 0) {
			// echo "$i = $k vs ".$x->key[$i]."<br>";
			$i = $i + 1;
		}
		if($i <= $x->n && strcmp($k, $x->key[$i]) == 0) {
			// echo "found";
				
			return $x->doc[$i];
		}
		if($x->leaf) {
			return NIL;
		}
		return $this->search($x->c[$i], $k);
	}
}
?>