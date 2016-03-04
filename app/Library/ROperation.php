<?php

namespace App\Library;

class ROperation {
	public function search($node, $key, $lev) {
		$queryxmin = $key[0];
		$queryxmax = $key[1];
		$queryymin = $key[2];
		$queryymax = $key[3];
		$f1 = 0; $f2 = 0; $f3 = 0; $f4 = 0;

		$a = $node->lowerx;
		$b = $node->upperx;
		$c = $node->lowery;
		$d = $node->uppery;
		if($lev == 0) {
			$region = array($node->lowerx, $node->upperx, $node->lowery, $node->uppery);
			return $region;
		}

		else {
			// 9 possibilities

			if($queryxmin <= ($a+$b)/2) {
				$f1 = 1;
			}
			if($queryxmax >= ($a+$b)/2) {
				$f2 = 1;
			}
			if($queryymin <= ($c+$d)/2) {
				$f3 = 1;
			}
			if($queryymax >= ($c+$d)/2) {
				$f4 = 1;
			}
			if($f1==1 && $f2==0 && $f3==0 && $f4==1) {
				//northwest
				// echo "northwest<br>";
				return $region = $this->search($node->nw, $key, $lev - 1);
			}
			else if($f1==0 && $f2==1 && $f3==0 && $f4==1) {
				//northeast
				// echo "northeast<br>";
				return $region = $this->search($node->ne, $key, $lev - 1);
			}
			else if($f1==1 && $f2==0 && $f3==1 && $f4==0) {
				//southwest
				// echo "southwest<br>";
				return $region = $this->search($node->sw, $key, $lev - 1);
			}
			else if($f1==0 && $f2==1 && $f3==1 && $f4==0) {
				//southeast
				// echo "southeast<br>";
				return $region = $this->search($node->se, $key, $lev - 1);
			}
			else if($f1==1 && $f2==1 && $f3==0 && $f4==1) {
				//north
				// echo "north<br>";
				$area1 = (($a+$b)/2) - $queryxmin;
				$area2 = $queryxmax - (($a+$b)/2);
				if($area1 >= $area2)
					return $region = $this->search($node->nw, $key, $lev - 1);
				else
					return $region = $this->search($node->ne, $key, $lev - 1);
			}
			else if($f1==1 && $f2==1 && $f3==1 && $f4==0) {
				//south
				// echo "south<br>";
				$area1 = (($a+$b)/2) - $queryxmin;
				$area2 = $queryxmax - (($a+$b)/2);
				if($area1 >= $area2)
					return $region = $this->search($node->sw, $key, $lev - 1);
				else
					return $region = $this->search($node->se, $key, $lev - 1);
			}
			else if($f1==1 && $f2==0 && $f3==1 && $f4==1) {
				//west
				// echo "west<br>";
				$area1 = (($c+$d)/2) - $queryymin;
				$area2 = $queryymax - (($c+$d)/2);
				if($area1 >= $area2)
					return $region = $this->search($node->sw, $key, $lev - 1);
				else
					return $region = $this->search($node->nw, $key, $lev - 1);
			}
			else if($f1==0 && $f2==1 && $f3==1 && $f4==1) {
				//east
				// echo "east<br>";
				$area1 = (($c+$d)/2) - $queryymin;
				$area2 = $queryymax - (($c+$d)/2);
				if($area1 >= $area2)
					return $region = $this->search($node->se, $key, $lev - 1);
				else
					return $region = $this->search($node->ne, $key, $lev - 1);
			}
			else if($f1==1 && $f2==1 && $f3==1 && $f4==1) {
				//center
				// echo "center<br>";
				$area1 = (($a+$b)/2) - $queryxmin;
				$area2 = $queryxmax - (($a+$b)/2);
				$area3 = (($c+$d)/2) - $queryymin;
				$area4 = $queryymax - (($c+$d)/2);
				if($area1 >= $area2 && $area3 >= $area4)
					return $region = $this->search($node->sw, $key, $lev - 1);
				else if($area1 >= $area2)
					return $region = $this->search($node->nw, $key, $lev - 1);
				else if($area3 >= $area4)
					return $region = $this->search($node->se, $key, $lev - 1);
				else
					return $region = $this->search($node->ne, $key, $lev - 1);
			}
		}
	}
}

?>