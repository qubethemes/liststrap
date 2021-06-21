<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://ravindrasinghmeyda.com/
 * @since      1.0.0
 *
 * @package    Liststrap
 * @subpackage Liststrap/public/partials
 */

class Liststrap_Mailchimp_Widget extends WP_Widget {   
	function __construct() {
		$widget_ops = array('classname' => 'liststrap_mailchimp_widget', 'description' => __( 'Liststrap mailchimp widget.', 'liststrap') );
		parent::__construct('liststrap-mailchimp', __('Liststrap Mailchimp', 'liststrap'), $widget_ops );        
	}
    
    /**
     * Liststrap widget public form
     */
	function widget( $args, $instance ) {
		$ouput = '';
		extract( $args );
		$title = !empty( $instance['title'] ) ? $instance['title']  : '';
		$subtitle = !empty( $instance['subtitle'] ) ? $instance['subtitle']  : '';
		$liststrap_form_style = !empty( $instance['liststrap_form_style'] ) ? $instance['liststrap_form_style']  : '';
		$liststrap_widget_location = !empty( $instance['liststrap_widget_location'] ) ? $instance['liststrap_widget_location']  : '';
		$liststrap_name_title = !empty( $instance['liststrap_name_title'] ) ? $instance['liststrap_name_title']  : '';
		$liststrap_name_placeholder = !empty( $instance['liststrap_name_placeholder'] ) ? $instance['liststrap_name_placeholder']  : '';
		$liststrap_email_title = !empty( $instance['liststrap_email_title'] ) ? $instance['liststrap_email_title']  : '';
		$liststrap_email_placeholder = !empty( $instance['liststrap_email_placeholder'] ) ? $instance['liststrap_email_placeholder']  : '';
		if( !empty( $subtitle ) ) :
			$liststrap_text_show = true;
			$liststrap_form_text = esc_html( $subtitle );
 		else :
 			$liststrap_text_show = '';
 			$liststrap_form_text = '';
		endif;
		if( !empty( $instance['liststrap_name_field_show'] ) && $instance['liststrap_name_field_show'] == 'yes' ) : 
			$liststrap_name_field_show = true;
	    else :
	    	$liststrap_name_field_show = '';
	    endif;
	    if( !empty( $instance['liststrap_label_show'] ) && $instance['liststrap_label_show'] == 'yes' ) : 
			$liststrap_label_show = true;
	    else :
	    	$liststrap_label_show = '';
	    endif;
		$liststrap_submit_button_text = !empty( $instance['liststrap_submit_button_text'] ) ? $instance['liststrap_submit_button_text']  : '';
		$ouput .= $before_widget;
		$ouput .= '<div class="liststrap-widget-main-wrapper" id="liststrap-widget-main-wrapper">';
			    if( !empty( $title ) ) :
			    	$ouput .= '<div class="liststrap-widget-heading-wrapper" id="liststrap-widget-heading-wrapper">';
					$ouput .= $args['before_title'] . esc_html( $title ) . $args['after_title'];
					$ouput .= '</div>';
				endif;
				$ouput.= do_shortcode('[liststrap-shortcode liststrap-form-style="' . esc_attr( $liststrap_form_style ) . '" liststrap-widget-location="' . esc_attr( $liststrap_widget_location ) . '" liststrap-text-show="' . esc_attr( $liststrap_text_show ) . '" liststrap-form-text="' . esc_attr( $liststrap_form_text ) . '" liststrap-name-title="' . esc_attr( $liststrap_name_title ) . '" liststrap-name-placeholder="' . esc_attr( $liststrap_name_placeholder ) . '" liststrap-email-title="' . esc_attr( $liststrap_email_title ) . '" liststrap-email-placeholder="' . esc_attr( $liststrap_email_placeholder ) . '" liststrap-name-field-show="' . esc_attr( $liststrap_name_field_show ) . '" liststrap-label-show="' . esc_attr( $liststrap_label_show ) . '" liststrap-submit-button="' . esc_attr( $liststrap_submit_button_text ) . '" liststrap-widget="true"]');
	    $ouput .= '</div>';
		$ouput .= $after_widget;
		echo __( $ouput ); 
	}

	/**
	 * Liststrap update widget form settings
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( !empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( !empty( $new_instance['subtitle'] ) ) {
			$instance['subtitle'] = sanitize_text_field( $new_instance['subtitle'] );
		}	
		if ( !empty( $new_instance['liststrap_form_style'] ) ) {
			$instance['liststrap_form_style'] = sanitize_text_field( $new_instance['liststrap_form_style'] );
		}
		if ( !empty( $new_instance['liststrap_widget_location'] ) ) {
			$instance['liststrap_widget_location'] = sanitize_text_field( $new_instance['liststrap_widget_location'] );
		}
		if ( !empty( $new_instance['liststrap_name_title'] ) ) {
			$instance['liststrap_name_title'] = sanitize_text_field( $new_instance['liststrap_name_title'] );
		}
		if ( !empty( $new_instance['liststrap_name_placeholder'] ) ) {
			$instance['liststrap_name_placeholder'] = sanitize_text_field( $new_instance['liststrap_name_placeholder'] );
		}
		if ( !empty( $new_instance['liststrap_email_title'] ) ) {
			$instance['liststrap_email_title'] = sanitize_text_field( $new_instance['liststrap_email_title'] );
		}
		if ( !empty( $new_instance['liststrap_email_placeholder'] ) ) {
			$instance['liststrap_email_placeholder'] = sanitize_text_field( $new_instance['liststrap_email_placeholder'] );
		}	
		if ( !empty( $new_instance['liststrap_name_field_show'] ) ) {
			$instance['liststrap_name_field_show'] = sanitize_text_field( $new_instance['liststrap_name_field_show'] );
		}
		if ( !empty( $new_instance['liststrap_label_show'] ) ) {
			$instance['liststrap_label_show'] = sanitize_text_field( $new_instance['liststrap_label_show'] );
		}
		if ( !empty( $new_instance['liststrap_submit_button_text'] ) ) {
			$instance['liststrap_submit_button_text'] = sanitize_text_field( $new_instance['liststrap_submit_button_text'] );
		}		
		return $instance;
	}

	/**
	 * Liststrap widget admin form
	 */	
    function form( $instance ) {	  
	   $output = '';
	   $title = isset( $instance['title'] ) ? $instance['title'] : '';
	   $subtitle = isset( $instance['subtitle'] ) ? $instance['subtitle'] : '';
	   $liststrap_form_style = isset( $instance['liststrap_form_style'] ) ? $instance['liststrap_form_style'] : '';
	   $liststrap_widget_location = isset( $instance['liststrap_widget_location'] ) ? $instance['liststrap_widget_location'] : '';
	   $liststrap_name_title = isset( $instance['liststrap_name_title'] ) ? $instance['liststrap_name_title'] : '';
	   $liststrap_name_placeholder = isset( $instance['liststrap_name_placeholder'] ) ? $instance['liststrap_name_placeholder'] : '';
	   $liststrap_email_title = isset( $instance['liststrap_email_title'] ) ? $instance['liststrap_email_title'] : '';
	   $liststrap_email_placeholder = isset( $instance['liststrap_email_placeholder'] ) ? $instance['liststrap_email_placeholder'] : '';
	   $liststrap_name_field_show = isset( $instance['liststrap_name_field_show'] ) ? $instance['liststrap_name_field_show'] : 'yes';
	   $liststrap_label_show = isset( $instance['liststrap_label_show'] ) ? $instance['liststrap_label_show'] : '';
	   $liststrap_submit_button_text = isset( $instance['liststrap_submit_button_text'] ) ? $instance['liststrap_submit_button_text'] : '';
       $hide_show = array('no' => esc_html__( 'Hide' , 'liststrap' ), 'yes' => esc_html__( 'Show', 'liststrap' ) );
       $form_style = array('vertical' => esc_html__( 'Vertical' , 'liststrap' ), 'horizontal' => esc_html__( 'Horizontal', 'liststrap' ) );
       $form_location = array('fooetr' => esc_html__( 'Footer' , 'liststrap' ), 'sidebar' => esc_html__( 'Sidebar', 'liststrap' ) );
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">' . esc_html__( 'Title:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '" />';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'subtitle' ) ) . '">' . esc_html__( 'Sub Title:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'subtitle' ) ) . '" name="' . esc_attr( $this->get_field_name( 'subtitle' ) ) . '" type="text" value="' . esc_attr( $subtitle ) . '" />';
	   $output .= '</p>';
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_form_style' ) ) . '">' . esc_html__( 'Form Style:', 'liststrap' ) . '</label>';
	   $output .= '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_form_style' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_form_style' ) ) . '">';
		   	if( !empty( $form_style ) ) :
		   		foreach( $form_style as $form_style_key => $form_style_val ) :
		   			$output .= '<option value="' . esc_attr( $form_style_key ) . '" ' . selected($liststrap_form_style , $form_style_key, false ) . '>' . esc_html( $form_style_val ) . '</option>';
		   		endforeach;
		   	endif;
	   $output .= '</select>';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_widget_location' ) ) . '">' . esc_html__( 'Form Location:', 'liststrap' ) . '</label>';
	   $output .= '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_widget_location' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_widget_location' ) ) . '">';
		   	if( !empty( $form_location ) ) :
		   		foreach( $form_location as $form_location_key => $form_location_val ) :
		   			$output .= '<option value="' . esc_attr( $form_location_key ) . '" ' . selected($liststrap_widget_location , $form_location_key, false ) . '>' . esc_html( $form_location_val ) . '</option>';
		   		endforeach;
		   	endif;
	   $output .= '</select>';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_name_title' ) ) . '">' . esc_html__( 'Label for name field:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_name_title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_name_title' ) ) . '" type="text" value="' . esc_attr( $liststrap_name_title ) . '" />';
	   $output .= '</p>';  
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_name_placeholder' ) ) . '">' . esc_html__( 'Placeholder for name field:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_name_placeholder' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_name_placeholder' ) ) . '" type="text" value="' . esc_attr( $liststrap_name_placeholder ) . '" />';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_email_title' ) ) . '">' . esc_html__( 'Label for email field:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_email_title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_email_title' ) ) . '" type="text" value="' . esc_attr( $liststrap_email_title ) . '" />';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_email_placeholder' ) ) . '">' . esc_html__( 'Placeholder for email field:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_email_placeholder' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_email_placeholder' ) ) . '" type="text" value="' . esc_attr( $liststrap_email_placeholder ) . '" />';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_name_field_show' ) ) . '">' . esc_html__( 'Name field Hide / Show:', 'liststrap' ) . '</label>';
	   $output .= '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_name_field_show' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_name_field_show' ) ) . '">';
		   	if( !empty( $hide_show ) ) :
		   		foreach( $hide_show as $hide_show_key => $hide_show_val ) :
		   			$output .= '<option value="' . esc_attr( $hide_show_key ) . '" ' . selected($liststrap_name_field_show , $hide_show_key, false ) . '>' . esc_html( $hide_show_val ) . '</option>';
		   		endforeach;
		   	endif;
	   $output .= '</select>';
	   $output .= '</p>'; 
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_label_show' ) ) . '">' . esc_html__( 'Label Hide / Show:', 'liststrap' ) . '</label>';
	   $output .= '<select class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_label_show' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_label_show' ) ) . '">';
		   	if( !empty( $hide_show ) ) :
		   		foreach( $hide_show as $hide_show_key => $hide_show_val ) :
		   			$output .= '<option value="' . esc_attr( $hide_show_key ) . '" ' . selected($liststrap_label_show , $hide_show_key, false ) . '>' . esc_html( $hide_show_val ) . '</option>';
		   		endforeach;
		   	endif;
	   $output .= '</select>';
	   $output .= '</p>';
	   $output .= '<p>';
	   $output .= '<label for="' . esc_attr( $this->get_field_id( 'liststrap_submit_button_text' ) ) . '">' . esc_html__( 'Submit Button Text:', 'liststrap' ) . '</label>';
	   $output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( 'liststrap_submit_button_text' ) ) . '" name="' . esc_attr( $this->get_field_name( 'liststrap_submit_button_text' ) ) . '" type="text" value="' . esc_attr( $liststrap_submit_button_text ) . '" />';
	   $output .= '</p>'; 	   
	   printf( $output );
	}
}
?>