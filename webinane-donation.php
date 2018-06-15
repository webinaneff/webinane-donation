<?php
/*
Plugin Name: Webinane Global Donation System
Plugin URI:  https://webinane.com
Description: This unique and awesome donation plugin with complete charity system developed by webinane.
Version:     1.0.0
Author:      Webinane
Author URI:  http://www.webinane.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

class wp_simple_donation{
	
	//properties
	private $wp_donation_trading_hour_days = array();
	
	//magic function (triggered on initialization)
	public function __construct(){
		add_action('init', array($this,'set_donation_trading_hour_days')); //sets the default trading hour days (used by the content type)
		add_action('init', array($this,'register_donation_content_type')); //register donation content type
		add_action('admin_menu', array($this,'books_register_ref_page')); //register page under content type
		add_action('admin_menu', array($this,'books_register_ref_page2'));
		add_action('admin_menu', array($this,'books_register_ref_page3'));
		add_action('admin_menu', array($this,'books_register_ref_page4'));
		add_action('admin_menu', array($this,'books_register_ref_page5'));
		add_action('admin_menu', array($this,'books_register_ref_page6'));
		add_action('admin_menu', array($this,'books_register_ref_page7'));
        add_action('add_meta_boxes', array($this,'add_donation_meta_boxes')); //add meta boxes
		add_action('save_post_wp_donations', array($this,'save_donation')); //save donation
		add_action('admin_enqueue_scripts', array($this,'enqueue_admin_scripts_and_styles')); //admin scripts and styles
		add_action('wp_enqueue_scripts', array($this,'enqueue_public_scripts_and_styles')); //public scripts and styles
		add_filter('the_content', array($this,'prepend_donation_meta_to_content')); //gets our meta data and dispayed it before the content
		
		register_activation_hook(__FILE__, array($this,'plugin_activate')); //activate hook
		register_deactivation_hook(__FILE__, array($this,'plugin_deactivate')); //deactivate hook
		
	}
	
	//set the default trading hour days (used in our admin backend)
	public function set_donation_trading_hour_days(){
		//set the default days to use for the trading hours
		$this->wp_donation_trading_hour_days = apply_filters('wp_donation_trading_hours_days',
			array('first' => 'First Amount',
				  'second' => 'Second Amount',
				  'third' => 'Third Amount',
				  'fourth' => 'Fourth Amount',
				  'fifth' => 'Fifth Amount',
				  'sixth' => 'Sixth Amount',
				  'seventh' => 'Seventh Amount',
			)
		);		
	}
	
	//register the donation content type
	public function register_donation_content_type(){
		 //Labels for post type
		 $labels = array(
            'name'               => '',
            'singular_name'      => 'Donation',
            'menu_name'          => 'Webinane Global Donation System',
            'name_admin_bar'     => 'Donation',
            'add_new'            => 'Add Campaign',
            'add_new_item'       => 'Add New Campaign',
            'new_item'           => 'New Campaign',
            'edit_item'          => 'Edit Campaign',
            'view_item'          => 'View Campaign',
            'all_items'          => 'All Campaign',
            'search_items'       => 'Search Campaign',
            'parent_item_colon'  => 'Parent Campaign:',
            'not_found'          => 'No Campaign found.',
            'not_found_in_trash' => 'No Campaign found in Trash.',
        );
        //arguments for post type
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true,
            'show_in_nav'       => true,
            'query_var'         => true,
            'hierarchical'      => false,
            'supports'          => array('title','thumbnail','editor'),
            'has_archive'       => true,
            'menu_position'     => 20,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'https://cdn4.iconfinder.com/data/icons/6x16-free-application-icons/16/3d_bar_chart.png',
            'rewrite'			=> array('slug' => 'donation', 'with_front' => 'true')
        );
		//register post type
		register_post_type('wp_donation', $args);
	}





	/**
	 * Adds a submenu page under a custom post type parent.
	 */
	public function books_register_ref_page() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Donations', 'textdomain' ),
			__( 'Donations', 'textdomain' ),
			'manage_options',
			'webinane-donation-history',
			array(&$this, 'books_ref_page')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page() {
		?>
        <div class="wrap">
            <h1><?php _e( 'Donations History for Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'text here', 'textdomain' ); ?></p>
            <?php include ("welcome.php");?>
        </div>
		<?php
	}

	public function books_register_ref_page2() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Donors', 'textdomain' ),
			__( 'Donors', 'textdomain' ),
			'manage_options',
			'webinane-donors',
			array(&$this, 'books_ref_page2')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page2() {
		?>
        <div class="wrap">
            <h1><?php _e( 'Donor Data of Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'text here', 'textdomain' ); ?></p>
			<?php include ("welcome.php");?>
        </div>
		<?php
	}

	public function books_register_ref_page5() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Reports', 'textdomain' ),
			__( 'Reports', 'textdomain' ),
			'manage_options',
			'webinane-reports',
			array(&$this, 'books_ref_page5')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page5() {
		?>
        <div class="wrap">
            <h1><?php _e( 'Complete All type of Reporting for Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'text here', 'textdomain' ); ?></p>
			<?php include ("welcome.php");?>
        </div>
		<?php
	}

	public function books_register_ref_page3() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Settings', 'textdomain' ),
			__( 'Settings', 'textdomain' ),
			'manage_options',
			'webinane-settings',
			array(&$this, 'books_ref_page3')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page3() {
		?>
        <div class="wrap">
            <h1><?php _e( 'Settings for Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'text here', 'textdomain' ); ?></p>
			<?php include ("welcome.php");?>
        </div>
		<?php
	}

	public function books_register_ref_page6() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Tools/Status', 'textdomain' ),
			__( 'Tools/Status', 'textdomain' ),
			'manage_options',
			'webinane-tools',
			array(&$this, 'books_ref_page6')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page6() {
		?>
        <div class="wrap">
            <h1><?php _e( 'System status and different Tools for Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'text here', 'textdomain' ); ?></p>
			<?php include ("welcome.php");?>
        </div>
		<?php
	}

	public function books_register_ref_page4() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Add-ons/Extensions', 'textdomain' ),
			__( 'Add-ons/Extensions', 'textdomain' ),
			'manage_options',
			'webinane-extensions',
			array(&$this, 'books_ref_page4')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page4() {
		?>
        <div class="wrap">
            <h1><?php _e( 'You can buy different Add-ons for Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'text here', 'textdomain' ); ?></p>
			<?php include ("welcome.php");?>
        </div>
		<?php
	}


	public function books_register_ref_page7() {
		add_submenu_page(
			'edit.php?post_type=wp_donation',
			__( 'Updates', 'textdomain' ),
			__( 'Updates', 'textdomain' ),
			'manage_options',
			'webinane-updates',
			array(&$this, 'books_ref_page7')
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function books_ref_page7() {
		?>
        <div class="wrap">
            <h1><?php _e( 'You can Update different Add-ons and Core for Webinane Donation System', 'textdomain' ); ?></h1>
            <p><?php _e( 'Webinane regularly receives new features, bug fixes, and enhancements. It is important to always stay up-to-date with latest version of Webinane Donation System core and its add-ons. Please create a backup of your site before updating. To update add-ons be sure your license keys are activated.', 'textdomain' ); ?></p>
			<?php include ("welcome.php");?>
        </div>
		<?php
	}

	//adding meta boxes for the donation content type*/
	public function add_donation_meta_boxes(){
		
		add_meta_box(
			'wp_donation_meta_box', //id
			'Campaign Information', //name
			array($this,'donation_meta_box_display'), //display function
			'wp_donation', //post type
			'normal', //donation
			'default' //priority
		);
	}
	
	//display function used for our custom donation meta box*/
	public function donation_meta_box_display($post){
		
		//set nonce field
		wp_nonce_field('wp_donation_nonce', 'wp_donation_nonce_field');
		
		//collect variables
		$wp_donation_phone = get_post_meta($post->ID,'wp_donation_phone',true);
		$wp_donation_email = get_post_meta($post->ID,'wp_donation_email',true);
		$wp_donation_address = get_post_meta($post->ID,'wp_donation_address',true);
		?>
		<p>Enter Details about Campaign </p>
		<div class="field-container">
			<?php 
			//before main form elementst hook
			do_action('wp_donation_admin_form_start');
			?>
			<div class="field">
				<label for="wp_donation_phone">Contact Phone</label>
				<small>main contact number</small>
				<input type="tel" name="wp_donation_phone" id="wp_donation_phone" value="<?php echo $wp_donation_phone;?>"/>
			</div>
			<div class="field">
				<label for="wp_donation_email">Contact Email</label>
				<small>Email contact</small>
				<input type="email" name="wp_donation_email" id="wp_donation_email" value="<?php echo $wp_donation_email;?>"/>
			</div>
			<div class="field">
				<label for="wp_donation_address">Address</label>
				<small>Physical address of your Campaign</small>
				<textarea name="wp_donation_address" id="wp_donation_address"><?php echo $wp_donation_address;?></textarea>
			</div>
			<?php
			//trading hours
			if(!empty($this->wp_donation_trading_hour_days)){
				echo '<div class="field">';
					echo '<label>Expected Donation Amount </label>';
					echo '<small> Expected Donation Amount for the campaign (e.g $10 - $20) </small>';
					//go through all of our registered trading hour days
					foreach($this->wp_donation_trading_hour_days as $day_key => $day_value){
						//collect trading hour meta data
						$wp_donation_trading_hour_value =  get_post_meta($post->ID,'wp_donation_trading_hours_' . $day_key, true);
						//dsiplay label and input
						echo '<label for="wp_donation_trading_hours_' . $day_key . '">' . $day_key . '</label>';
						echo '<input type="text" name="wp_donation_trading_hours_' . $day_key . '" id="wp_donation_trading_hours_' . $day_key . '" value="' . $wp_donation_trading_hour_value . '"/>';
					}
				echo '</div>';
			}		
			?>
		<?php 
		//after main form elementst hook
		do_action('wp_donation_admin_form_end');
		?>
		</div>
		<?php
		
	}
	
	//triggered on activation of the plugin (called only once)
	public function plugin_activate(){
		
		//call our custom content type function
	 	$this->register_donation_content_type();
		//flush permalinks
		flush_rewrite_rules();
	}
	
	//trigered on deactivation of the plugin (called only once)
	public function plugin_deactivate(){
		//flush permalinks
		flush_rewrite_rules();
	}
	
	//append our additional meta data for the donation before the main content (when viewing a single donation)
	public function prepend_donation_meta_to_content($content){
			
		global $post, $post_type;
		
		//display meta only on our donations (and if its a single donation)
		if($post_type == 'wp_donations' && is_singular('wp_donations')){
			
			//collect variables

			$wp_donation_id = $post->ID;
			$wp_donation_phone = get_post_meta($post->ID,'wp_donation_phone',true);
			$wp_donation_email = get_post_meta($post->ID,'wp_donation_email',true);
			$wp_donation_address = get_post_meta($post->ID,'wp_donation_address',true);
			
			//display
			$html = '';
	
			$html .= '<section class="meta-data">';
			
			//hook for outputting additional meta data (at the start of the form)
			do_action('wp_donation_meta_data_output_start',$wp_donation_id);
			
			$html .= '<p>';
			//phone
			if(!empty($wp_donation_phone)){
				$html .= '<b>donation Phone</b>' . $wp_donation_phone . '</br>';
			}
			//email
			if(!empty($wp_donation_email)){
				$html .= '<b>donation Email</b>' . $wp_donation_email . '</br>';
			}
			//address
			if(!empty($wp_donation_address)){
				$html .= '<b>donation Address</b>' . $wp_donation_address . '</br>';
			}
			$html .= '</p>';

			//donation
			if(!empty($this->wp_donation_trading_hour_days)){
				$html .= '<p>';
				$html .= '<b>donation Trading Hours </b></br>';
				foreach($this->wp_donation_trading_hour_days as $day_key => $day_value){
					$trading_hours = get_post_meta($post->ID, 'wp_donation_trading_hours_' . $day_key , true);
					$html .= '<b>' . $day_key . '</b>' . $trading_hours . '</br>';
				}
				$html .= '</p>';
			}

			//hook for outputting additional meta data (at the end of the form)
			do_action('wp_donation_meta_data_output_end',$wp_donation_id);
			
			$html .= '</section>';
			$html .= $content;
			
			return $html;	
				
			
		}else{
			return $content;
		}

	}

	//main function for displaying donations (used for our shortcodes and widgets)
	public function get_donations_output($arguments = ""){
			
		//default args
		$default_args = array(
			'donation_id'	=> '',
			'number_of_donations'	=> -1
		);
		
		//update default args if we passed in new args
		if(!empty($arguments) && is_array($arguments)){
			//go through each supplied argument
			foreach($arguments as $arg_key => $arg_val){
				//if this argument exists in our default argument, update its value
				if(array_key_exists($arg_key, $default_args)){
					$default_args[$arg_key] = $arg_val;
				}
			}
		}

		//output
		$html = '';

		$donation_args = array(
			'post_type'		=> 'wp_donations',
			'posts_per_page'=> $default_args['number_of_donations'],
			'post_status'	=> 'publish'
		);
		//if we passed in a single donation to display
		if(!empty($default_args['donation_id'])){
			$donation_args['include'] = $default_args['donation_id'];
		}
		
		$donations = get_posts($donation_args);
		//if we have donations
		if($donations){
			$html .= '<article class="donation_list cf">';
			//foreach donation
			foreach($donations as $donation){
				$html .= '<section class="donation">';
					//collect donation data
					$wp_donation_id = $donation->ID;
					$wp_donation_title = get_the_title($wp_donation_id);
					$wp_donation_thumbnail = get_the_post_thumbnail($wp_donation_id,'thumbnail');
					$wp_donation_content = apply_filters('the_content', $donation->post_content);
					if(!empty($wp_donation_content)){
						$wp_donation_content = strip_shortcodes(wp_trim_words($wp_donation_content, 40, '...'));
					}
					$wp_donation_permalink = get_permalink($wp_donation_id);
					$wp_donation_phone = get_post_meta($wp_donation_id,'wp_donation_phone',true);
					$wp_donation_email = get_post_meta($wp_donation_id,'wp_donation_email',true);
					
					//title
					$html .= '<h2 class="title">';
						$html .= '<a href="' . $wp_donation_permalink . '" title="view donation">';
							$html .= $wp_donation_title;
						$html .= '</a>';
					$html .= '</h2>';
					
				
					//image & content
					if(!empty($wp_donation_thumbnail) || !empty($wp_donation_content)){
								
						$html .= '<p class="image_content">';
						if(!empty($wp_donation_thumbnail)){
							$html .= $wp_donation_thumbnail;
						}
						if(!empty($wp_donation_content)){
							$html .=  $wp_donation_content;
						}
						
						$html .= '</p>';
					}
					
					//phone & email output
					if(!empty($wp_donation_phone) || !empty($wp_donation_email)){
						$html .= '<p class="phone_email">';
						if(!empty($wp_donation_phone)){
							$html .= '<b>Phone: </b>' . $wp_donation_phone . '</br>';
						}
						if(!empty($wp_donation_email)){
							$html .= '<b>Email: </b>' . $wp_donation_email;
						}
						$html .= '</p>';
					}
					
					//readmore
					$html .= '<a class="link" href="' . $wp_donation_permalink . '" title="view donation">View donation</a>';
				$html .= '</section>';
			}
			$html .= '</article>';
			$html .= '<div class="cf"></div>';
		}
		
		return $html;
	}
	
	
	
	//triggered when adding or editing a donation
	public function save_donation($post_id){
		
		//check for nonce
		if(!isset($_POST['wp_donation_nonce_field'])){
			return $post_id;
		}	
		//verify nonce
		if(!wp_verify_nonce($_POST['wp_donation_nonce_field'], 'wp_donation_nonce')){
			return $post_id;
		}
		//check for autosave
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
			return $post_id;
		}
	
		//get our phone, email and address fields
		$wp_donation_phone = isset($_POST['wp_donation_phone']) ? sanitize_text_field($_POST['wp_donation_phone']) : '';
		$wp_donation_email = isset($_POST['wp_donation_email']) ? sanitize_text_field($_POST['wp_donation_email']) : '';
		$wp_donation_address = isset($_POST['wp_donation_address']) ? sanitize_text_field($_POST['wp_donation_address']) : '';
		
		//update phone, memil and address fields
		update_post_meta($post_id, 'wp_donation_phone', $wp_donation_phone);
		update_post_meta($post_id, 'wp_donation_email', $wp_donation_email);
		update_post_meta($post_id, 'wp_donation_address', $wp_donation_address);
		
		//search for our trading hour data and update
		foreach($_POST as $key => $value){
			//if we found our trading hour data, update it
			if(preg_match('/^wp_donation_trading_hours_/', $key)){
				update_post_meta($post_id, $key, $value);
			}
		}
		
		//donation save hook
		//used so you can hook here and save additional post fields added via 'wp_donation_meta_data_output_end' or 'wp_donation_meta_data_output_end'
		do_action('wp_donation_admin_save',$post_id);
		
	}
	
	//enqueus scripts and stles on the back end
	public function enqueue_admin_scripts_and_styles(){
		wp_enqueue_style('wp_donation_admin_styles', plugin_dir_url(__FILE__) . '/css/wp_donation_admin_styles.css');
	}
	
	//enqueues scripts and styled on the front end
	public function enqueue_public_scripts_and_styles(){
		wp_enqueue_style('wp_donation_public_styles', plugin_dir_url(__FILE__). '/css/wp_donation_public_styles.css');
		
	}
	
}
$wp_simple_donations = new wp_simple_donation;

//include shortcodes
include(plugin_dir_path(__FILE__) . 'inc/wp_donation_shortcode.php');
//include widgets
include(plugin_dir_path(__FILE__) . 'inc/wp_donation_widget.php');



?>