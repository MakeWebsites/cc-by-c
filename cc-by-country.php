<?php
/*
Plugin Name: cc-by-country
Plugin URI: 
Description: Observed by-country changes in temperatures and precipitations 
Version: 1.0.0
Author: ClimaRisk
Author URI: www.climarisk.com
License: GPLv2
*/
// Loading the translation files
add_action( 'plugins_loaded', 'cc_by_country_load_textdomain' );
function cc_by_country_load_textdomain() {
  load_plugin_textdomain( 'cc-by-country', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
  
//Creating the shortcode and showing the graphs
function cc_bc_gc ($atts) {
    
    function get_f_content( $file_path ) {
        ob_start();
        include $file_path;
        $contents = ob_get_clean();
    return $contents;
    }

wp_enqueue_script('google-loader','https://www.gstatic.com/charts/loader.js'); 
wp_enqueue_script('googlec',plugin_dir_url( __FILE__ ).'includes/js/googlec.js');   
 
$atts = shortcode_atts( // Defaults include trends and links to ClimaRisk post 
        ['ctitle' => 'true', // Including a title - Default true
	 'cclink' => 'false', // Including a link to Climaisk post - Default false
         'ctemp' => 'true', // Including the Temperature chart - Default true
         'cprec' => 'true', // Including the Precipitation chart - Default true
                        ], $atts, 'cc-by-country' );
		
	//Shortcode options
	$ctitle = ($atts['ctitle'] === false) ? 'false' : $atts['ctitle'];
	$cclink = ($atts['cclink'] === false) ? 'false' : $atts['cclink'];
        $ctemp = ($atts['ctemp'] === false) ? 'false' : $atts['ctemp'];
        $cprec = ($atts['cprec'] === false) ? 'false' : $atts['cprec'];
        
                  
if (filter_input(INPUT_POST, 'c2f')) $c2 = $_POST['c2f'];
else  {
include_once "includes/c2.php";
    $c2d = new c2(); 
    $c2 = $c2d->getc2();
    }
//echo 'c2 vale '.$c2;
// Estimating c3
    include_once 'includes/convC3.php';
    $c3d = new convC3($c2);
    $c3 = $c3d->getC3($c2);
                
$mtitle = array();
$mtitle['t'] = __('Temperature', 'cc-by-country');
$mtitle['p'] = __('Precipitation', 'cc-by-country');
$mtitle['y'] = __('Year', 'cc-by-country');
wp_localize_script('googlec', 'googlec', array('g_url' => plugin_dir_url( __FILE__ ).'includes/getdata.php', 
    't' => $mtitle, 'c3' => $c3));
include_once "includes/cctitle.php";
$scgc = '<a name="ccg"></a>';
$scgc .=  new cctitle($c2, $c3);
$scgc .= '<div id="bgc"><h4>';
$scgc .= __('Drawing the charts', 'cc-by-country').'.....</h4>
</div><div id="gctas"></div>
<div id="gcpr"></div>
<form id="cvf" class="ccf" method="POST" action="'.get_permalink().'#ccg" style="visibility: hidden">
<!--<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name = "mvar" id="tas" value="tas">
  <label class="radio-inline mr-1 active" for="tas">Temperature </label>
  <input class="form-check-input" type="radio" name="mvar" id="pr" value="pr">
  <label class="radio-inline" for="pr">Precipitation</label>
</div>-->
<select id="c2f" name="c2f"><option selected value="'.$c2.'S">'.__('Select another country....', 'cc-by-country').'</option>';
$scgc .= get_f_content('includes/country_select.html');
$scgc .= '<input type="hidden" name="action" value="gct">
</form>';
        
return $scgc;	
	
}  
add_shortcode('cc_by_country', 'cc_bc_gc');