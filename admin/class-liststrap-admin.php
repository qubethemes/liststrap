<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ravindrasinghmeyda.com/
 * @since      1.0.0
 *
 * @package    Liststrap
 * @subpackage Liststrap/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Liststrap
 * @subpackage Liststrap/admin
 * @author     Ravindra Singh Meyda <meyda.ravi79@gmail.com>
 */
class Liststrap_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		add_action( 'admin_menu', array( $this, 'liststrap_create_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'liststrap_settings_register' ) );
		add_action( 'wp_ajax_liststrap_get_lists_ajax', array( $this, 'liststrap_get_lists_ajax' ) );
		add_action( 'wp_ajax_nopriv_liststrap_get_lists_ajax', array($this, 'liststrap_get_lists_ajax' ) );
		add_action( 'wp_ajax_liststrap_form_data_ajax', array( $this, 'liststrap_form_data_ajax' ) );
		add_action( 'wp_ajax_nopriv_liststrap_form_data_ajax', array($this, 'liststrap_form_data_ajax' ) );
		add_action( 'widgets_init', array( $this, 'liststrap_require_widget_file' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, LISTSTRAP_URL . 'admin/css/liststrap-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, LISTSTRAP_URL . 'admin/js/liststrap-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'liststrap_admin_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

	}
    
    /**
	 * Liststrap require widget file
	 *
	 * @since    1.0.0
	 */
	public function liststrap_require_widget_file(){
		$args = array('Liststrap_Mailchimp_Widget' => 'class-mailchimp-widget.php');
	    foreach( $args as $args_key => $args_val ) :
		    require_once LISTSTRAP_DIR_PATH . 'admin/partials/'.$args_val;
		    register_widget( $args_key );	
		endforeach;
	}

	/**
	 * Liststrap create admin menu
	 *
	 * @since    1.0.0
	 */
	public function liststrap_create_admin_menu(){
		add_menu_page( __( 'ListStrap', 'liststrap' ), 'ListStrap', 'manage_options', 'liststrap-settings', array($this, 'liststrap_pages'), esc_url( LISTSTRAP_URL . 'admin/images/liststrap-white-icon.svg' ) );
	}

	/**
	 * Liststrap setting options.
	 *
	 * @since    1.0.0
	 */
	public function liststrap_option_fields(){
   		$output = '';
   		$output = array( 'liststrap_setting' => array( 'liststrap_apikey', 'liststrap_lists' ) );
   	    return $output;
	}

    /**
	 * Liststrap menu item
	 *
	 * @since    1.0.0
	 */
    public function liststrap_menu_item(){
    	$output = '';
    	$output = array(
    				array(
                    'class' => 'tab-link current',
                    'data'  => 'tab-1',
                    'title' => esc_html__( 'API Setting', 'liststrap' ),
    				),
    				array(
                    'class' => 'tab-link',
                    'data'  => 'tab-2',
                    'title' => esc_html__( 'Liststrap Shortcode', 'liststrap' ),
    				),
    	          );
    	return $output;
    }

	/**
	 * Liststrap menu
	 *
	 * @since    1.0.0
	 */
    public function liststrap_menu(){
    	$output = $menu_items = '';
    	$menu_items = $this->liststrap_menu_item();
    	$output .= '<ul class="tabs">';
	    	foreach( $menu_items as $menu_item_key => $menu_item_val ) :
		    		 $output .= '<li class="' . esc_attr( $menu_item_val['class'] ) . '" data-tab="' . esc_attr( $menu_item_val['data'] ) . '"><strong>' . esc_html( $menu_item_val['title'] ) . '</strong></li>';
		    endforeach;
	    $output .= '</ul>';
    	return $output;
    }

	/**
	 * Liststrap pages
	 *
	 * @since    1.0.0
	 */
	public function liststrap_pages() {
        $output = $lists = '';
		$output .= '<div class="wrap">
					  	<h1>' . esc_html__( 'Liststrap Settings', 'liststrap' ) . '</h1>
					  	<div class="liststrap-setting-list">';
					        $output .= $this->liststrap_menu(); 
					        $output .= $this->liststrap_setting_page(); 
					        $output .= $this->liststrap_shortcode_lists_page(); 
			$output .= '</div>  
					</div>';
	    echo __( $output );
	}

	/**
	 * Liststrap images
	 *
	 * @since    1.0.0
	 */
    public function liststrap_image($args){
    	$output = '';
    	if( !empty( $args) && !empty( $args['url'] ) && !empty( $args['alt'] ) ) :
    		$width = !empty( $args['width'] ) ? 'width="' . esc_attr( $args['width'] ) . '"' : '';
    		$height = !empty( $args['height'] ) ? 'height="' . esc_attr( $args['height'] ) . '"' : '';
    		$output .= '<img src="' . esc_url( $args['url'] ) . '" alt="' . esc_attr( $args['alt'] ) . '" ' . esc_attr( $width . ' ' . $height ) . ' class="' . esc_attr( $args['img-class'] ) . '">';
    	endif;
    	return $output;
    }

	/**
	 * Liststrap form field
	 *
	 * @since    1.0.0
	 */
    public function liststrap_form_field($fields, $selected_val = ''){
    	$output = '';
    	switch($fields['type']) :
			case 'status':
			    if( $fields['label'] == true ) :
					$output .= '<label for="' . esc_attr( $fields['id'] ) . '" class="' . esc_attr( $fields['label-class'] ) . '">' . esc_html( $fields['title'] ) . '</label>';
				endif;
    			if(!empty($fields['status']) && $fields['status'] == 'Connected') :
  	      			$output .= '<span class="status positive" id="liststrap-status-show">' . esc_html__( 'Connected', 'liststrap' ) . '</span>';
  	      		else :
  	      			$output .= '<span class="status neutral" id="liststrap-status-show">' . esc_html__( 'Not Connected', 'liststrap' ) . '</span>';
  	      		endif;
			break;
			case 'text':
			    if( $fields['label'] == true ) :
					$output .= '<label for="' . esc_attr( $fields['id'] ) . '" class="' . esc_attr( $fields['label-class'] ) . '">' . esc_html( $fields['title'] ) . '</label>';
				endif;
    			$output .= '<input id="' . esc_attr( $fields['id'] ) . '" name="' . esc_attr( $fields['name'] ) . '" type="text" placeholder="' . esc_attr( $fields['placeholder'] ) . '" class="' . esc_attr( $fields['input-class'] ) . '" value="' . esc_attr( $fields['value'] ) . '">';
			break;
			case 'email':
			    if( $fields['label'] == true ) :
					$output .= '<label for="' . esc_attr( $fields['id'] ) . '" class="' . esc_attr( $fields['label-class'] ) . '">' . esc_html( $fields['title'] ) . '</label>';
				endif;
    			$output .= '<input id="' . esc_attr( $fields['id'] ) . '" name="' . esc_attr( $fields['name'] ) . '" type="email" placeholder="' . esc_attr( $fields['placeholder'] ) . '" class="' . esc_attr( $fields['input-class'] ) . '" value="' . esc_attr( $fields['value'] ) . '">';
			break;
			case 'select':
			    if( !empty( $fields['option'] ) ) :
			    	if( $fields['label'] == true ) :
						$output .= '<label for="' . esc_attr( $fields['id'] ) . '" class="' . esc_attr( $fields['label-class'] ) . '">' . esc_html( $fields['title'] ) . '</label>';
					endif;
	    			$output .= '<select id="' . esc_attr( $fields['id'] ) . '" name="' . esc_attr( $fields['name'] ) . '">';
	    				foreach( $fields['option'] as $option_key => $option_val ) :
	    					if( $option_key == $selected_val ) :
	    						$output .= '<option value="' . esc_attr( $option_key ) . '" selected>' . esc_html( $option_val ) . '</option>';
	    					else :
	    						$output .= '<option value="' . esc_attr( $option_key ) . '">' . esc_html( $option_val ) . '</option>';
	    					endif;
	    				endforeach;
	    			$output .= '</select>';
    			endif;
			break;
			case 'submit':
			    if( !empty( $fields['data-form-id'] ) ) :
			     	$data_form_id = 'data-form-id=' . esc_attr( $fields['data-form-id'] ) . '';
			    else :
			    	$data_form_id = '';
			    endif;
			    if( !empty( $fields['data-btn-parent-loader'] ) ) :
			        $data_btn_parent_loader = 'data-btn-parent-loader=' . esc_attr( $fields['data-btn-parent-loader'] ) . '';
			    else :
			    	$data_btn_parent_loader = '';
			    endif;
				$output .= '<input id="' . esc_attr( $fields['id'] ) . '" name="' . esc_attr( $fields['name'] ) . '" type="submit" class="' . esc_attr( $fields['input-class'] ) . '" value="' . esc_attr( $fields['value'] ) . '" ' . esc_attr( $data_form_id ) .' ' . esc_attr( $data_btn_parent_loader ) . '>';
			break;
    	endswitch;
    	if( !empty( $fields['help'] ) ) :
			$output .= '<a href="' . esc_url( $fields['help']['url'] ) . '" target="_blank">' . esc_html( $fields['help']['text'] ) . '</a>';
		endif;
		if( !empty( $fields['loader'] ) && $fields['loader'] == true ) :
		    $output .= $this->liststrap_image($fields);
		endif; 
    	return $output;
    }

	/**
	 * Liststrap form
	 *
	 * @since    1.0.0
	 */
    public function liststrap_form($data, $side){
    	$output = '';
    	if( !empty( $data ) ) :
    		if( $side == 'backend' ) :
    			ob_start();
    		endif;
	    	$output .= '<div id="' . esc_attr( $data['liststrap-wrapper-id'] ) . '" class="' . esc_attr( $data['liststrap-wrapper-class'] ) . '" data-tab="' . esc_attr( $data['liststrap-data-tab'] ) . '">';
	    		if( !empty( $data['liststrap-form-heading'] ) ) :
	    			$output .= '<h3>' . esc_html( $data['liststrap-form-heading'] ) . '</h3>';
	    		endif;
	    		if( !empty( $data['liststrap-form-text'] ) ) :
	    			$output .= '<p>' . esc_html( $data['liststrap-form-text'] ) . '</p>';
	    		endif;
	    		if( !empty( $data['liststrap-form-action'] ) ) :
	    			$action = 'action="' . esc_attr( $data['liststrap-form-action'] ) . '"';
	    		else :
	    			$action = '';
	    		endif;
	    		$output .= '<form id="' . esc_attr( $data['liststrap-form-id'] ) . '" method="' . esc_attr( $data['liststrap-form-method'] ) . '" class="' . esc_attr( $data['liststrap-form-class'] ) . '" ' . esc_attr( $action ) . '>';
	    						if( $side == 'backend' ) :
						    		$output .= settings_fields(esc_attr( $data['liststrap-form-id'] ));
	                				$output .= do_settings_sections(esc_attr( $data['liststrap-form-id'] ));
	                				$output .= ob_get_clean();
						    	endif;
						    	foreach( $data['fields'] as $data_field_key => $data_filed_val ) :
						    		$output .= '<div class="' . esc_attr( $data_filed_val['form-group-warpper-class'] ) . '" id="' . esc_attr( $data_filed_val['form-group-warpper-id'] ) . '" data-list-key="' . esc_attr( $data_filed_val['form-group-warpper-data'] ) . '">';
						    			if( !empty( $data_filed_val['option'] ) && $data_filed_val['type'] == 'select' ) :
						    				$get_mailchimp = $this->liststrap_get_mailchimp_data();
    										$selected_val = !empty( $get_mailchimp['lists'] ) ? $get_mailchimp['lists'] : '';
						    				$output .= $this->liststrap_form_field($data_filed_val, $selected_val);
						    			else :
						    				$output .= $this->liststrap_form_field($data_filed_val, $selected_val = '');
						    			endif;
						    		$output .= '</div>';
						    	endforeach;
	    		$output .= '</form>
	    			</div>';
        endif;
    	return $output;
    }

	/**
	 * Liststrap setting page.
	 *
	 * @since    1.0.0
	 */
	public function liststrap_form_field_data(){
		$output = $liststrap_get_lists = $api_key = '';
		$liststrap_get_lists = $this->liststrap_list_show_in_admin();
		$get_mailchimp = $this->liststrap_get_mailchimp_data();
    	$api_key = !empty( $get_mailchimp['api_key'] ) ? $get_mailchimp['api_key'] : '';
    	$liststrap_status = !empty( $get_mailchimp['liststrap_status'] ) ? $get_mailchimp['liststrap_status'] : '';
		$output = array(
			      'liststrap-wrapper-id'    => 'tab-1',
			      'liststrap-wrapper-class' => 'tab-content current',
			      'liststrap-data-tab'      => 'liststrap-setting',
			      'liststrap-form-id'       => 'liststrap-setting',
			      'liststrap-form-method'   => 'post',
			      'liststrap-form-action'   => 'options.php',
			      'liststrap-form-class'    => 'form-container',
			      'fields'                  => array(
			      							   		array(
			      							   		'form-group-warpper-id'    => 'liststrap-status',
			      							   		'form-group-warpper-class' => 'form-group w-50 float-left liststrap-status',
			      							   		'form-group-warpper-data'  => 'liststrap-status',
 			      							   		'id'                       => 'liststrap_status',
		                                   			'name'                     => 'liststrap_status',
		                                   			'label'                    => true,
		                                   			'type'                     => 'status',
		                                            'title'                    => esc_html__( 'Status', 'liststrap' ),
		                                            'label-class'              => 'fs-16 lh-24',
		                                            'status'                   => $liststrap_status,
			      							   		),
			      							   		array(
			      							   		'form-group-warpper-id'    => 'liststrap-apikey',
			      							   		'form-group-warpper-class' => 'form-group w-50 float-left liststrap-apikey',
			      							   		'form-group-warpper-data'  => 'liststrap-lists',
 			      							   		'id'                       => 'liststrap_apikey',
		                                   			'name'                     => 'liststrap_apikey',
		                                   			'label'                    => true,
		                                   			'type'                     => 'text',
		                                            'title'                    => esc_html__( 'MailChimp API Key', 'liststrap' ),
		                                            'label-class'              => 'fs-16 lh-24',
		                                            'placeholder'              => esc_html__( 'MailChimp', 'liststrap' ),
		                                            'input-class'              => 'form-control',
		                                            'value'                    => $api_key,
		                                            'help'                     => array(
                                                                                  'url'  => esc_url( 'https://mailchimp.com/' ),
                                                                                  'text' => esc_html__( 'Get MailChimp API Key Here', 'liststrap' ),
		                                                                          ),
		                                            'loader'                   => true,
		                                            'url'                      => esc_url( LISTSTRAP_URL . 'admin/images/loader.gif' ),
		                                            'alt'                      => 'liststrap-apikey',
		                                            'img-class'                => 'liststrap-loader liststrap-hide liststrap-apikey-cls',
			      							   		),
			      							   		array(
			      							   		'form-group-warpper-id'    => 'liststrap-lists',
			      							   		'form-group-warpper-class' => 'form-group w-50 float-left liststrap-lists',
			      							   		'form-group-warpper-data'  => 'liststrap-lists-data',
 			      							   		'id'                       => 'liststrap_lists',
		                                   			'name'                     => 'liststrap_lists',
		                                   			'label'                    => true,
		                                   			'type'                     => 'select',
		                                            'title'                    => esc_html__( 'Select List', 'liststrap' ),
		                                            'label-class'              => 'fs-16 lh-24',
		                                            'placeholder'              => esc_html__( 'Select List', 'liststrap' ),
		                                            'input-class'              => 'form-control',
		                                            'option'                   => $liststrap_get_lists
			      							   		),
			      							   		array(
			      							   		'form-group-warpper-id'    => 'liststrap-from-submit-btn',
			      							   		'form-group-warpper-class' => 'form-group w-50 float-left liststrap-from-submit-btn',
			      							   		'form-group-warpper-data'  => 'liststrap-from-submit-btn',
 			      							   		'id'                       => 'liststrap-from-submit',
		                                   			'name'                     => 'btn liststrap_from_submit_btn',
		                                   			'type'                     => 'submit',
		                                            'input-class'              => 'form-control',
		                                            'value'                    => esc_html__( 'Submit', 'liststrap' ),
		                                            'loader'                   => true,
		                                            'url'                      => esc_url( LISTSTRAP_URL . 'admin/images/loader.gif' ),
		                                            'alt'                      => 'liststrap-from-submit-btn',
		                                            'img-class'                => 'liststrap-loader liststrap-hide liststrap-from-submit-btn-cls',
			      							   		),
			                                   )
		          );
		return $output;		
	}

	/**
	 * Liststrap setting page.
	 *
	 * @since    1.0.0
	 */
	public function liststrap_setting_page(){
		$output = '';
		$data = $this->liststrap_form_field_data();
		$output = $this->liststrap_form($data, 'backend');
		return $output;
	}

	/**
	 * Liststrap shortcode list page.
	 *
	 * @since    1.0.0
	 */
	public function liststrap_shortcode_data(){
		$output = '';
		$output = array( 'liststrap_shortcode_lists' => array( 'liststrap-shortcode' => esc_html__( 'Liststrap Shortcode', 'liststrap' ) ) );
		return $output;
	}

	/**
	 * Liststrap shortcode list page.
	 *
	 * @since    1.0.0
	 */
	public function liststrap_shortcode_lists_page(){
		$output = '';
		$shortcode_list = $this->liststrap_shortcode_data();
		if(!empty($shortcode_list['liststrap_shortcode_lists'])) :
			$output .= '<div id="tab-2" class="tab-content" data-tab="liststrap-lists">';
				 $output .= '<div class="form-group w-50 float-left">';
				 				foreach($shortcode_list['liststrap_shortcode_lists'] as $shortcode_list_key => $shortcode_list_val) :
					                $output .= '<div class="form-group w-25 float-left">
					  	      						<label for="liststrap_shortcode_name">' . esc_html( $shortcode_list_val ) . '</label>
					  	      			        </div>
					  	      			        <div class="form-group w-25 float-right">[' . esc_html( $shortcode_list_key ) . ']</div>';
	  	      			   		endforeach;
	  	    	 $output .= '</div>
					   </div>';
		endif;
		return $output;
	}

	/**
	 * Register liststrap setting register.
	 *
	 * @since    1.0.0
	 */
	public function liststrap_settings_register() {	
		$args = '';
        $args = $this->liststrap_option_fields();
		if(!empty($args)) :
		    foreach($args as $key => $val) :
		    	switch($key){
		    		case 'liststrap_setting':
		    		    foreach($val as $valk => $valv) :
		    				register_setting( 'liststrap-setting', sanitize_text_field( $valv ) );
		    			endforeach;
		    		break;
		    	}
		    endforeach;
		endif;
	}

	/**
	 * Liststrap mailchimp api
	 *
	 * @since    1.0.0
	 */
	public function liststrap_mailchimp_api($data, $action){
		$output = $response = '';
		$dataCenter = substr( $data['api_key'], strpos( $data['api_key'], '-' ) +1 );
        $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/' . $data['endpoint'];
        $api_data = array();
        $methods = array('POST', 'PUT');
		$api_data = array(
	                'timeout'     => 45,
	                'redirection' => 5,
	                'httpversion' => '1.0',
	                'blocking'    => true,
	                'headers'     => $data['headres'],
	                'body'        => $data['fields'],			    
	                );
		if( in_array( $action, $methods ) ) :
        	$api_data['method'] = $data['method'];
        endif;
		if( $action == 'GET' ) :
			$output = wp_remote_get($url, $api_data);
		else :
			$output = wp_remote_post($url, $api_data);
		endif;
		$response = array(
                    'code' => wp_remote_retrieve_response_code($output),
                    'body' => json_decode( wp_remote_retrieve_body($output), true )
		            );
		return $response;
	}

	/**
	 * Liststrap prepare data for to get lists
	 *
	 * @since    1.0.0
	 */
    public function liststrap_prepare_data_for_to_get_lists($api_key){
    	$output = '';
    	if( !empty( $api_key ) ) :
	    	$output = array(
	    			  'api_key'  => $api_key,
	    			  'endpoint' => 'lists',
	    			  'headres'  => array( 'Authorization' => 'user: ' . $api_key, 'Content-Type' => 'application/json'),
	    			  'fields'   => array( 'fields' => 'lists' ),
	    	          );
        endif;
    	return $output;
    }

    /**
	 * Liststrap get mailchimp lists
	 *
	 * @since    1.0.0
	 */
    public function liststrap_get_mailchimp_lists($api_key){
    	$data = $get_data = $get_mailchimp = '';
    	$output = array();
    	$data = $this->liststrap_prepare_data_for_to_get_lists($api_key);
    	if( !empty( $data ) ) :
	    	$get_data = $this->liststrap_mailchimp_api($data, 'GET');
	    	if( !empty( $get_data ) && $get_data['code'] == 200 ) :
	    		foreach( $get_data['body']['lists'] as $body_key => $body_val ) :
	    			$output[] = array(
	                            'id'      => $body_val['id'],
	                            'name'    => $body_val['name'],
	                            'ucname'  => ucfirst( $body_val['name'] ),
	    			            );
	    		endforeach;
	    	endif;
    	endif;
    	return $output;
    }

    /**
	 * Liststrap list show in admin
	 *
	 * @since    1.0.0
	 */
    public function liststrap_list_show_in_admin(){
    	$data = $get_data = '';
    	$output = array();
    	$get_mailchimp = $this->liststrap_get_mailchimp_data();
    	$api_key = !empty( $get_mailchimp['api_key'] ) ? $get_mailchimp['api_key'] : '';
    	$data = $this->liststrap_prepare_data_for_to_get_lists($api_key);
    	if( !empty( $data ) ) :
    		$get_data = $this->liststrap_mailchimp_api($data, 'GET');
    		if( !empty( $get_data ) && $get_data['code'] == 200 ) :
    			foreach( $get_data['body']['lists'] as $body_key => $body_val ) :
    				$output[$body_val['id']] = ucfirst( $body_val['name'] );
    			endforeach;
    		endif;
    	endif;
    	return $output;
    }

	/**
	 * Liststrap form data ajax
	 *
	 * @since    1.0.0
	 */
    public function liststrap_get_lists_ajax(){
    	$api_key = !empty( $_POST['api_key'] ) ? sanitize_text_field( $_POST['api_key'] ) : '';
    	$liststrap_get_lists = $this->liststrap_get_mailchimp_lists($api_key);
    	if( !empty( $liststrap_get_lists ) ) :
        	echo json_encode( array( 'status' => 'success', 'form' => 'liststrap-setting', 'api_status' => esc_html__( 'Connected', 'liststrap' ), 'data' => $liststrap_get_lists ) );
    	else :
        	echo json_encode( array( 'status' => 'error', 'form' => 'liststrap-setting', 'api_status' => esc_html__( 'Not Connected', 'liststrap' ), 'data' => '' ) );
    	endif;
    	wp_die();
    }

    /**
	 * Liststrap form data ajax
	 *
	 * @since    1.0.0
	 */
    public function liststrap_form_data_ajax(){
    	$data = '';
    	$form_data = array();
    	parse_str($_POST['form_data'], $form_data); 
    	$form_data = wp_unslash($form_data);
    	$liststrap_apikey = sanitize_text_field( trim( $form_data['liststrap_apikey'] ) );
    	$liststrap_lists = sanitize_text_field( trim( $form_data['liststrap_lists'] ) );
    	if( !empty( $liststrap_apikey ) && !empty( $liststrap_lists ) ) :
    		$liststrap_status = 'Connected';
    		update_option('liststrap_apikey', sanitize_text_field( $liststrap_apikey ) );
    		update_option('liststrap_lists', sanitize_text_field( $liststrap_lists ) );
    		update_option('liststrap_status', sanitize_text_field( $liststrap_status ) );
        	echo json_encode( array( 'status' => 'success', 'form' => 'liststrap-setting', 'message' => esc_html__( 'Your data has been successfully saved.', 'liststrap' ) ) );
    	else :
    		update_option('liststrap_apikey', '');
    		update_option('liststrap_lists', '');
    		update_option('liststrap_status', '');
        	echo json_encode( array( 'status' => 'error', 'form' => 'liststrap-setting', 'message' => esc_html__( 'Oops, something went wrong, your data was not saved.', 'liststrap' ) ) );
    	endif;
    	wp_die();
    }

    /**
	 * Liststrap get saved data
	 *
	 * @since    1.0.0
	 */
    public function liststrap_get_mailchimp_data(){
    	$output = '';
    	$api_key = !empty( get_option( 'liststrap_apikey' ) ) ? get_option( 'liststrap_apikey' ) :  '';
    	$api_lists = !empty( get_option( 'liststrap_lists' ) ) ? get_option( 'liststrap_lists' ) :  '';
    	$status = !empty( get_option( 'liststrap_status' ) ) ? get_option( 'liststrap_status' ) :  '';
    	if( !empty( $api_key ) && !empty( $api_lists ) ) :
	    	$output = array(
	                  'api_key'          => $api_key,
	                  'lists'            => $api_lists,
	                  'liststrap_status' => $status,
	    	          );
        endif;
    	return $output;
    	wp_die();
    }
}
