<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ravindrasinghmeyda.com/
 * @since      1.0.0
 *
 * @package    Liststrap
 * @subpackage Liststrap/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Liststrap
 * @subpackage Liststrap/public
 * @author     Ravindra Singh Meyda <meyda.ravi79@gmail.com>
 */
class Liststrap_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_shortcode( 'liststrap-shortcode', array( $this, 'liststrap_shortcode' ) );
		add_action( 'wp_ajax_liststrap_subscription_ajax', array( $this, 'liststrap_subscription_ajax' ) );
		add_action( 'wp_ajax_nopriv_liststrap_subscription_ajax', array($this, 'liststrap_subscription_ajax' ) );
        
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Liststrap_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Liststrap_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, LISTSTRAP_URL . 'public/css/liststrap-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Liststrap_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Liststrap_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, LISTSTRAP_URL . 'public/js/liststrap-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'liststrap_public_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}

	/**
	 * Liststrap form field data
	 *
	 * @since    1.0.0
	 */
	public function liststrap_form_field_data($data){
		$output = '';
		$arr_data = array();
		if( !empty( $data['liststrap-widget-location'] ) && $data['liststrap-widget-location'] == 'sidebar' ) :
			$liststrap_widget_location = 'liststrap-sidebar-widget-subscription-form';
 		else :
 			$liststrap_widget_location = 'liststrap-widget-subscription-form';
		endif;
		if( !empty( $data['liststrap-widget'] ) && $data['liststrap-widget'] == true ) :
			$liststrap_widget_horizontal = 'liststrap-widget-horizontal';
			$liststrap_wrapper_horizontal = 'liststrap-widget-wrapper liststrap-wrapper-widget-horizontal';
			$liststrap_widget_vertical = 'liststrap-widget-vertical';
			$liststrap_wrapper_vertical = 'liststrap-widget-wrapper liststrap-wrapper-widget-vertical';
			$liststrap_subscription_form_widget = $liststrap_widget_location;
			$liststrap_widget_form_container = 'liststrap-widget-form-container';
			$liststrap_form_group_warpper_id = 'liststrap-widget-from-submit-btn';
			$liststrap_form_group_warpper_class = 'form-group w-50 float-left liststrap-widget-from-submit-btn';
			$liststrap_form_group_warpper_data = 'liststrap-widget-from-submit-btn';
			$liststrap_from_submit_id = 'liststrap-widget-from-submit';
			$liststrap_from_submit_name = 'liststrap_widget_from_submit_btn';
			$liststrap_submit_inputcls = 'form-control liststrap-widget-form-control';
			$liststrap_from_submit_btn_alt = 'liststrap-widget-from-submit-btn';
			$liststrap_image_class = 'liststrap-loader liststrap-hide liststrap-widget-from-submit-btn-cls';
			$liststrap_name_field_wrapper_id = 'liststrap-widget-name';
			$liststrap_name_field_wrapper_class = 'form-group w-50 float-left liststrap-widget-name';
			$liststrap_name_field_data = 'liststrap-widget-name';
			$liststrap_name_field_id = 'liststrap_widget_name';
			$liststrap_name_field_name = 'liststrap_widget_name';
			$liststrap_name_field_label_class = 'fs-16 lh-24 liststrap-widget-label';
			$liststrap_name_field_input_class = 'form-control liststrap-input-widget-form-control';
			$liststrap_email_field_wrapper_id = 'liststrap-widget-email';
			$liststrap_email_field_wrapper_class = 'form-group w-50 float-left liststrap-widget-email';
			$liststrap_email_field_data = 'liststrap-widget-email';
			$liststrap_email_field_id = 'liststrap_widget_email';
			$liststrap_email_field_name = 'liststrap_widget_email';
			$liststrap_email_field_label_class = 'fs-16 lh-24 liststrap-widget-label';
			$liststrap_email_field_input_class = 'form-control liststrap-input-widget-form-control';
		else :
			$liststrap_widget_horizontal = 'liststrap-horizontal';
			$liststrap_wrapper_horizontal = 'liststrap-wrapper liststrap-wrapper-horizontal';
			$liststrap_widget_vertical = 'liststrap-vertical';
			$liststrap_wrapper_vertical = 'liststrap-wrapper liststrap-wrapper-vertical';
			$liststrap_subscription_form_widget = 'liststrap-subscription-form';
			$liststrap_widget_form_container = 'form-container';
			$liststrap_form_group_warpper_id = 'liststrap-from-submit-btn';
			$liststrap_form_group_warpper_class = 'form-group w-50 float-left liststrap-from-submit-btn';
			$liststrap_form_group_warpper_data = 'liststrap-from-submit-btn';
			$liststrap_from_submit_id = 'liststrap-from-submit';
			$liststrap_from_submit_name = 'liststrap_from_submit_btn';
			$liststrap_submit_inputcls = 'form-control';
			$liststrap_from_submit_btn_alt = 'liststrap-from-submit-btn';
			$liststrap_image_class = 'liststrap-loader liststrap-hide liststrap-from-submit-btn-cls';
			$liststrap_name_field_wrapper_id = 'liststrap-name';
			$liststrap_name_field_wrapper_class = 'form-group w-50 float-left liststrap-name';
			$liststrap_name_field_data = 'liststrap-name';
			$liststrap_name_field_id = 'liststrap_name';
			$liststrap_name_field_name = 'liststrap_name';
			$liststrap_name_field_label_class = 'fs-16 lh-24';
			$liststrap_name_field_input_class = 'form-control';
			$liststrap_email_field_wrapper_id = 'liststrap-email';
			$liststrap_email_field_wrapper_class = 'form-group w-50 float-left liststrap-email';
			$liststrap_email_field_data = 'liststrap-email';
			$liststrap_email_field_id = 'liststrap_email';
			$liststrap_email_field_name = 'liststrap_email';
			$liststrap_email_field_label_class = 'fs-16 lh-24';
			$liststrap_email_field_input_class = 'form-control';
		endif;
		if( !empty( $data['liststrap-form-style'] ) && $data['liststrap-form-style'] == 'horizontal' ) :
			$liststrap_wrapper_id = $liststrap_widget_horizontal;
			$liststrap_wrapper = $liststrap_wrapper_horizontal;
		else : 
			$liststrap_wrapper_id = $liststrap_widget_vertical;
			$liststrap_wrapper = $liststrap_wrapper_vertical;
		endif;
		if( !empty( $data['liststrap-heading-show'] ) && $data['liststrap-heading-show'] == true ) :
			$liststrap_form_heading = !empty( $data['liststrap-form-heading'] ) ? $data['liststrap-form-heading'] : esc_html__( 'Subscribe To Our Newsletter', 'liststrap' ); 
		else :
			$liststrap_form_heading = '';
		endif;
		if( !empty( $data['liststrap-text-show'] ) && $data['liststrap-text-show'] == true ) :
			$liststrap_form_text = !empty( $data['liststrap-form-text'] ) ? $data['liststrap-form-text'] : esc_html( 'Join our subscribers list to get the latest news, updates and special offers delivered directly in your inbox.', 'liststrap' );
		else :
			$liststrap_form_text = '';
		endif;
		$liststrap_wrapper_data = !empty( $data['liststrap-wrapper-data'] ) ? $data['liststrap-wrapper-data'] : $liststrap_subscription_form_widget; 
		$liststrap_subscription_form = !empty( $data['liststrap-subscription-form'] ) ? $data['liststrap-subscription-form'] : $liststrap_subscription_form_widget; 
		$liststrap_form_container = !empty( $data['liststrap-form-container'] ) ? $data['liststrap-form-container'] : $liststrap_widget_form_container;   
		$liststrap_name_title = !empty( $data['liststrap-name-title'] ) ? $data['liststrap-name-title'] : esc_html__( 'Name', 'liststrap' ); 
		$liststrap_name_placeholder = !empty( $data['liststrap-name-placeholder'] ) ? $data['liststrap-name-placeholder'] : esc_html__( 'Please enter name.', 'liststrap' );
		$liststrap_email_title = !empty( $data['liststrap-email-title'] ) ? $data['liststrap-email-title'] : esc_attr__( 'Email', 'liststrap' ); 
		$liststrap_email_placeholder = !empty( $data['liststrap-email-placeholder'] ) ? $data['liststrap-email-placeholder'] : esc_attr__( 'Please enter email.', 'liststrap' );
		$liststrap_name_field_show = !empty( $data['liststrap-name-field-show'] ) ? $data['liststrap-name-field-show'] : false;
		$liststrap_label_show = !empty( $data['liststrap-label-show'] ) ? $data['liststrap-label-show'] : false;
		$liststrap_submit_button = !empty( $data['liststrap-submit-button'] ) ? $data['liststrap-submit-button'] : esc_attr__( 'Submit', 'liststrap' ); 
		if( $liststrap_name_field_show == true ) : 
			$arr_data[] = array(
					   	  'form-group-warpper-id'    => esc_attr( $liststrap_name_field_wrapper_id ),
					   	  'form-group-warpper-class' => esc_attr( $liststrap_name_field_wrapper_class ),
					   	  'form-group-warpper-data'  => esc_attr( $liststrap_name_field_data ),
						  'id'                       => esc_attr( $liststrap_name_field_id ),
               			  'name'                     => esc_attr( $liststrap_name_field_name ),
               			  'label'                    => esc_attr( $liststrap_label_show ),
               			  'type'                     => 'text',
                          'title'                    => esc_attr( $liststrap_name_title ),
                          'label-class'              => $liststrap_name_field_label_class,
                          'placeholder'              => esc_attr( $liststrap_name_placeholder ),
                          'input-class'              => $liststrap_name_field_input_class,
                          'value'                    => '',
					   	  );
		endif;
			$arr_data[] = array(
				   		  'form-group-warpper-id'    => esc_attr( $liststrap_email_field_wrapper_id ),
				   		  'form-group-warpper-class' => esc_attr( $liststrap_email_field_wrapper_class ),
				   		  'form-group-warpper-data'  => esc_attr( $liststrap_email_field_data ),
					   	  'id'                       => esc_attr( $liststrap_email_field_id ),
	       			      'name'                     => esc_attr( $liststrap_email_field_name ),
	       			      'label'                    => esc_attr( $liststrap_label_show ),
	       			      'type'                     => 'email',
	                      'title'                    => esc_attr( $liststrap_email_title ),
	                      'label-class'              => esc_attr( $liststrap_email_field_label_class ),
	                      'placeholder'              => esc_attr( $liststrap_email_placeholder ),
	                      'input-class'              => esc_attr( $liststrap_email_field_input_class ),
	                      'value'                    => '',
				   		  );
			$arr_data[] = array(
				   		  'form-group-warpper-id'    => $liststrap_form_group_warpper_id,
				   		  'form-group-warpper-class' => $liststrap_form_group_warpper_class,
				   		  'form-group-warpper-data'  => $liststrap_form_group_warpper_data,
					   	  'id'                       => $liststrap_from_submit_id,
	       			      'name'                     => $liststrap_from_submit_name,
	       			      'type'                     => 'submit',
	                      'input-class'              => $liststrap_submit_inputcls,
	                      'value'                    => esc_attr( $liststrap_submit_button ),
	                      'loader'                   => true,
	                      'url'                      => esc_url( LISTSTRAP_URL . 'admin/images/loader.gif' ),
	                      'alt'                      => $liststrap_from_submit_btn_alt,
	                      'img-class'                => $liststrap_image_class,
	                      'data-form-id'             => $liststrap_subscription_form_widget,
	                      'data-btn-parent-loader'   => $liststrap_form_group_warpper_id,
				   		  );
			$output = array(
				      'liststrap-wrapper-id'    => esc_attr( $liststrap_wrapper_id ),
				      'liststrap-wrapper-class' => esc_attr( $liststrap_wrapper ),
				      'liststrap-data-tab'      => esc_attr( $liststrap_wrapper_data ),
				      'liststrap-form-id'       => esc_attr( $liststrap_subscription_form ),
				      'liststrap-form-method'   => 'post',
				      'liststrap-form-action'   => '',
				      'liststrap-form-class'    => esc_attr( $liststrap_form_container ),
				      'liststrap-form-heading'  => esc_html( $liststrap_form_heading ),
				      'liststrap-form-text'     => esc_html( $liststrap_form_text ),
				      'fields'                  => $arr_data,
			          ); 
		return $output;		
	}
    
    /**
	 * Liststrap front form
	 *
	 * @since    1.0.0
	 */
	public function liststrap_front_form($atts){
		$output = $data = '';
		$liststrap_admin = new Liststrap_Admin($this->plugin_name, $this->version);
		$data = $this->liststrap_form_field_data($atts);
		$liststrap_form = $liststrap_admin->liststrap_form($data, $side = '');
		$output = $liststrap_form;
		return $output;
	}

	/**
	 * Liststrap shortcode
	 *
	 * @since    1.0.0
	 */
	public function liststrap_shortcode($atts){
		$output = '';
		$atts = shortcode_atts( array(
        						'liststrap-form-style'        => '',
        						'liststrap-widget-location'   => '',
								'liststrap-heading-show'      => '',
								'liststrap-form-heading'      => '',
								'liststrap-text-show' 		  => '',  
								'liststrap-form-text'         => '',
								'liststrap-wrapper-data'      => '',
								'liststrap-subscription-form' => '',
								'liststrap-form-container'    => '',
								'liststrap-name-title'        => '',
								'liststrap-name-placeholder'  => '',
								'liststrap-email-title'       => '',
								'liststrap-email-placeholder' => '',
								'liststrap-name-field-show'   => '',
								'liststrap-label-show'        => '',
								'liststrap-submit-button'     => '',
								'liststrap-widget'            => '',
    			), $atts, 'liststrap-shortcode' );
		$output = $this->liststrap_front_form($atts);
		return $output;
	}

	/**
	 * Liststrap mailchimp subscription check
	 *
	 * @since    1.0.0
	 */
	public function liststrap_mailchimp_subscription_check($api_key, $listid, $email){
		$output = '';
		if( !empty( $api_key ) && !empty( $listid ) && !empty( $email ) ) :
    		$memberid = md5( strtolower( $email ) );
	    	$output = array(
	    			  'api_key'  => $api_key,
	    			  'endpoint' => 'lists/' . $listid . '/members/' . $memberid,
	    			  'headres'  => array( 'Authorization' => 'user: ' . $api_key, 'Content-Type' => 'application/json'),
	    	          );
        endif;
		return $output;
	}
	/**
	 * Liststrap prepare data for subscription
	 *
	 * @since    1.0.0
	 */
    public function liststrap_prepare_data_for_subscription($api_key, $listid, $name, $email){
    	$output = '';
    	if( !empty( $api_key ) && !empty( $listid ) && !empty( $email ) ) :
    		$memberid = md5( strtolower( $email ) );
    	    $fields = array( 
    	    	      'email_address' => $email, 
    	    	      'full_name'     => $name, 
    	    	      'status'        => 'subscribed'
    	    	      );
    	    if( !empty( $name ) ) : 
    	        $fields['merge_fields'] = array( 'FNAME' => $name, 'LNAME' => '' );
    	    endif;
	    	$output = array(
	    		      'method'   => 'PUT',
	    			  'api_key'  => $api_key,
	    			  'endpoint' => 'lists/' . $listid . '/members/' . $memberid,
	    			  'headres'  => array( 'Authorization' => 'user: ' . $api_key, 'Content-Type' => 'application/json'),
	    			  'fields'   => json_encode( $fields ),
	    	          );
        endif;
    	return $output;
    }

	/**
	 * Liststrap subscription ajax
	 *
	 * @since    1.0.0
	 */
	public function liststrap_subscription_ajax(){
		$output = '';
		$form_data = array();
    	parse_str($_POST['form_data'], $form_data); 
    	$form_data = wp_unslash($form_data);
    	if( !empty( $form_data ) ) :
    		foreach( $form_data as $form_data_key => $form_data_val ) : 
		    	switch( $form_data_key ) :
		    		case 'liststrap_name':
		    			$liststrap_name = !empty( $form_data_val ) ? sanitize_text_field( $form_data_val ) : ''; 
		    		break;
		    		case 'liststrap_email':
		    			$liststrap_email = !empty( $form_data_val ) ? sanitize_text_field( $form_data_val ) : ''; 
		    		break;
		    		case 'liststrap_widget_name':
		    			$liststrap_name = !empty( $form_data_val ) ? sanitize_text_field( $form_data_val ) : ''; 
		    		break;
		    		case 'liststrap_widget_email':
		    			$liststrap_email = !empty( $form_data_val ) ? sanitize_text_field( $form_data_val ) : ''; 
		    		break;
		    	endswitch;
    		endforeach;
    	endif;
    	$liststrap_form_id = !empty( $_POST['liststrap_form_id'] ) ? sanitize_text_field( $_POST['liststrap_form_id'] ) : '';
		$liststrap_admin = new Liststrap_Admin($this->plugin_name, $this->version);
		$liststrapadmin = $liststrap_admin->liststrap_get_mailchimp_data();
		$api_key = !empty( $liststrapadmin['api_key'] ) ? $liststrapadmin['api_key'] : '';
		$listid = !empty( $liststrapadmin['lists'] ) ? $liststrapadmin['lists'] : '';
		$subscription_check = $this->liststrap_mailchimp_subscription_check($api_key, $listid, $liststrap_email);
		$check = $liststrap_admin->liststrap_mailchimp_api($subscription_check, 'GET');
		if( $check['code'] == 200 && $check['body']['status'] == 'subscribed' ) :
			echo json_encode( array( 'status' => 'success', 'form' => $liststrap_form_id, 'message' => esc_html__( 'You have already subscribed.', 'liststrap' ) ) );
		else :
			$data = $this->liststrap_prepare_data_for_subscription($api_key, $listid, $liststrap_name, $liststrap_email);
			$res_data = $liststrap_admin->liststrap_mailchimp_api($data, $data['method']);
			if( $res_data['code'] == 200 ) :
				echo json_encode( array( 'status' => 'success', 'form' => $liststrap_form_id, 'message' => esc_html__( 'Your have successfully subscribed.', 'liststrap' ) ) );
			else :
				echo json_encode( array( 'status' => 'error', 'form' => $liststrap_form_id, 'message' => esc_html__( 'Oops, something went wrong, your data was not saved.', 'liststrap' ) ) );
			endif;
		endif;
		wp_die();
		return $output;
	}
    
}