<?php
/*
 * Wp Donation Shortcode
 * A shortcode created to display a donation or series of donations when used in the editor or other areas
 */

 
 //defines the functionality for the donation shortcode
 class wp_donation_shortcode{
 	
	//on initialize
	public function __construct(){
		add_action('init', array($this,'register_donation_shortcodes')); //shortcodes
	}

	//donation shortcode
	public function register_donation_shortcodes(){
		add_shortcode('wp_donation', array($this,'donation_shortcode_output'));
	}
	
	//shortcode display
	public function donation_shortcode_output($atts, $content = '', $tag){
			
		//get the global wp_simple_donations class
		global $wp_simple_donations;
			
		//build default arguments
		$arguments = shortcode_atts(array(
			'donation_id' => '',
			'number_of_donations' => -1)
		,$atts,$tag);
		//uses the main output function of the donation class
		$html = $wp_simple_donations->get_donations_output($arguments);
		return $html;
	}

 }
 $wp_donation_shortcode = new wp_donation_shortcode;

?>