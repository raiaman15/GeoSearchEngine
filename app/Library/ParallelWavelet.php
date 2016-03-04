<?php

namespace App\Library;

class ParallelWavelet {

	public function createTree($S, $n, $sigma) {
		$l = ceil(log($sigma, 2));
		$WT = array(array());
		// $VT = array(array());
		for($i = 0; $i < $l; $i++) {
			$m = pow(2, $i);
			for($j = 1; $j <= $m + 1; $j++) {
				$WT[$i][$j] = '';
				$VT[$i][$j] = '';
			}
			// var_dump($WT);
			$v = 0;
			$div = floor($sigma / (2 * $m));
			while($v < $n) {
				if($div!=0) {
					$u = floor($S[$v] / $div);
					if($u % 2 == 1)
						$val= '1';
					else
						$val= '0';
					$d = floor($u/2);
					if($d > $m+	1) {
						$WT[$i][$d + 1] = $val;
					}
					else {
						$WT[$i][$d + 1].= $val;
					}
					$VT[$i][floor($u/2) + 1] .= $S[$v]." ";
				}
				else {
					$WT[$i][$S[$v]] = '0';	
					$VT[$i][$S[$v]] = "$S[$v] ";
				}
				$v++;
			}
		}
		var_dump($VT);
		return $WT;
	}
}
?>