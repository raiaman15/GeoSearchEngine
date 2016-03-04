<?php

namespace App\Library;

class RStarOperation {
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
				return $region = $this->search($node->nw, $key, $lev - 1);
			}
			else if($f1==0 && $f2==1 && $f3==0 && $f4==1) {
				//northeast
				return $region = $this->search($node->ne, $key, $lev - 1);
			}
			else if($f1==1 && $f2==0 && $f3==1 && $f4==0) {
				//southwest
				return $region = $this->search($node->sw, $key, $lev - 1);
			}
			else if($f1==0 && $f2==1 && $f3==1 && $f4==0) {
				//southeast
				return $region = $this->search($node->se, $key, $lev - 1);
			}
			else if($f1==1 && $f2==1 && $f3==0 && $f4==1) {
				//north
				$region1 = $this->search($node->nw, $key, $lev - 1);
				$region2 = $this->search($node->ne, $key, $lev - 1);
				$lx = min($region1[0], $region2[0]);
				$ux = max($region1[1], $region2[1]);
				$ly = min($region1[2], $region2[2]);
				$uy = max($region1[3], $region2[3]);
				$region = array($lx, $ux, $ly, $uy);
				return $region;
			}
			else if($f1==1 && $f2==1 && $f3==1 && $f4==0) {
				//south
				$region1 = $this->search($node->sw, $key, $lev - 1);
				$region2 = $this->search($node->se, $key, $lev - 1);
				$lx = min($region1[0], $region2[0]);
				$ux = max($region1[1], $region2[1]);
				$ly = min($region1[2], $region2[2]);
				$uy = max($region1[3], $region2[3]);
				$region = array($lx, $ux, $ly, $uy);
				return $region;
			}
			else if($f1==1 && $f2==0 && $f3==1 && $f4==1) {
				//west
				$region1 = $this->search($node->sw, $key, $lev - 1);
				$region2 = $this->search($node->nw, $key, $lev - 1);
				$lx = min($region1[0], $region2[0]);
				$ux = max($region1[1], $region2[1]);
				$ly = min($region1[2], $region2[2]);
				$uy = max($region1[3], $region2[3]);
				$region = array($lx, $ux, $ly, $uy);
				return $region;
			}
			else if($f1==0 && $f2==1 && $f3==1 && $f4==1) {
				//east
				$region1 = $this->search($node->se, $key, $lev - 1);
				$region2 = $this->search($node->ne, $key, $lev - 1);
				$lx = min($region1[0], $region2[0]);
				$ux = max($region1[1], $region2[1]);
				$ly = min($region1[2], $region2[2]);
				$uy = max($region1[3], $region2[3]);
				$region = array($lx, $ux, $ly, $uy);
				return $region;
			}
			else if($f1==1 && $f2==1 && $f3==1 && $f4==1) {
				//center
				$region1 = $this->search($node->sw, $key, $lev - 1);
				$region2 = $this->search($node->nw, $key, $lev - 1);
				$region3 = $this->search($node->se, $key, $lev - 1);
				$region4 = $this->search($node->ne, $key, $lev - 1);
				$lx = min($region1[0], $region2[0], $region3[0], $region4[0]);
				$ux = max($region1[1], $region2[1], $region3[1], $region4[1]);
				$ly = min($region1[2], $region2[2], $region3[2], $region4[2]);
				$uy = max($region1[3], $region2[3], $region3[3], $region4[3]);
				$region = array($lx, $ux, $ly, $uy);
				return $region;
			}
		}
	}
}

?>