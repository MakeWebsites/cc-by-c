<?php

class cctitle {
    private $_cct;
    
    public function __construct($c2, $c3) {
	
    $flag = plugins_url( 'banderas/'.strtolower ($c2).'.png', __FILE__ );
	$cct = '<h3>'.__('Climate Data for ', 'cc-by-country').$c3.'<img class="imgs" style="padding-left:1%; margin-top:-1%" src="'.$flag.'"/></h3>';
	$this ->_cct = $cct;
	}
	
	public function __toString()
    {
        return $this->_cct;
    }
	
}
