<?php
/*
 * Wp donation Widget
 * Defines the widget to be used to showcase single or multiple donations
 */


//main widget used for displaying donations
class wp_donation_widget extends WP_widget{
	
	//initialise widget values
	public function __construct(){
		//set base values for the widget (override parent)
		parent::__construct(
			'wp_donation_widget',
			'WP Donation Widget',
			array('description' => 'A widget that displays your donations')
		);
		add_action('widgets_init',array($this,'register_wp_donation_widgets'));
	}
	
	//handles public display of the widget
	//$args - arguments set by the widget area, $instance - saved values
	public function widget( $args, $instance ) {
		
		//get wp_simple_donation class (as it builds out output)
		global $wp_simple_donations;
		
		//pass any arguments if we have any from the widget
		$arguments = array();
		//if we specify a donation
		
		//if we specify a single donation
		if($instance['donation_id'] != 'default'){
			$arguments['donation_id'] = $instance['donation_id'];
		}
		//if we specify a number of donations
		if($instance['number_of_donations'] != 'default'){
			$arguments['number_of_donations'] = $instance['number_of_donations'];
		}
		
		//get the output
		$html = '';
		
		$html .= $args['before_widget'];
		$html .= $args['before_title'];
		$html .= 'Donations';
		$html .= $args['after_title'];
		//uses the main output function of the donation class
		$html .= $wp_simple_donations->get_donations_output($arguments);
		$html .= $args['after_widget'];
		
		echo $html;
	}
	
	//handles the back-end admin of the widget
	//$instance - saved values for the form
	public function form($instance){
		//collect variables 
		$donation_id = (isset($instance['donation_id']) ? $instance['donation_id'] : 'default');
		$number_of_donations = (isset($instance['number_of_donations']) ? $instance['number_of_donations'] : 5);
		
		?>
		<p>Select your options below</p>
		<p>
			<label for="<?php echo $this->get_field_name('donation_id'); ?>">Donation to display</label>
			<select class="widefat" name="<?php echo $this->get_field_name('donation_id'); ?>" id="<?php echo $this->get_field_id('donation_id'); ?>" value="<?php echo $donation_id; ?>">
				<option value="default">All Donations</option>
				<?php
				$args = array(
					'posts_per_page'	=> -1,
					'post_type'			=> 'wp_donations'
				);
				$donations = get_posts($args);
				if($donations){
					foreach($donations as $donation){
						if($donation->ID == $donation_id){
							echo '<option selected value="' . $donation->ID . '">' . get_the_title($donation->ID) . '</option>';
						}else{
							echo '<option value="' . $donation->ID . '">' . get_the_title($donation->ID) . '</option>';
						}
					}
				}
				?>
			</select>
		</p>
		<p>
			<small>If you want to display multiple donations select how many below</small><br/>
			<label for="<?php echo $this->get_field_id('number_of_donations'); ?>">Number of Donations</label>
			<select class="widefat" name="<?php echo $this->get_field_name('number_of_donations'); ?>" id="<?php echo $this->get_field_id('number_of_donations'); ?>" value="<?php echo $number_of_donations; ?>">
				<option value="default">All</option>
			</select>
		</p>
		<?php
	}
	
	//handles updating the widget 
	//$new_instance - new values, $old_instance - old saved values
	public function update($new_instance, $old_instance){

		$instance = array();
		
		$instance['donation_id'] = $new_instance['donation_id'];
		$instance['number_of_donations'] = $new_instance['number_of_donations'];
		
		return $instance;
	}
	
	//registers our widget for use
	public function register_wp_donation_widgets(){
		register_widget('wp_donation_widget');
	}
}
$wp_donation_widget = new wp_donation_widget;

?>