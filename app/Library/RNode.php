<?php

namespace App\Library;

class RNode
{
	public $lowerx;
	public $lowery;
	public $upperx;
	public $uppery;
	public $nw; //north west
	public $sw;	//south west
	public $ne; //north east
	public $se; //south east
	function __construct($xmin, $xmax, $ymin, $ymax) {
		$this->lowerx = $xmin;
		$this->upperx = $xmax;
		$this->lowery = $ymin;
		$this->uppery = $ymax;
		$this->nw = null;
		$this->sw = null;
		$this->ne = null;
		$this->se = null;
	}
}

?>