(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready( function(){
		/**
		 * Liststrap shotcode form submit
		 */
		$('#liststrap-from-submit').on('click', function(e){
        	e.preventDefault();
        	$.fn.liststrap_submit(this);
    	});

    	/**
    	 * Liststrap widget form submit
    	 */
    	$('#liststrap-widget-from-submit').on('click', function(e){
        	e.preventDefault();
        	$.fn.liststrap_submit(this);
    	});

    	/**
    	 * Liststrap submit function
    	 */
		$.fn.liststrap_submit = function(e){
			var error = 0;
        	var regex = '';
        	var get_result = '';
        	var get_form_id = $(e).attr('data-form-id');
        	var get_submit_btn_loader = $(e).attr('data-btn-parent-loader');
        	var form_data = $('#'+get_form_id).serializeArray();
            $.each(form_data, function(i, value){
	            var get_type = $('#'+value.name).attr('type');
	            var get_value = $('#'+value.name).val();
	            $('#liststrap-'+value.name+'-error').remove();
	            if(get_value != '' ){
	            	if(get_type == 'email'){
	            		regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	            		if(regex.test(get_value) == false){
	            		   $('#'+value.name).after('<span class="liststrap-error" id="liststrap-'+value.name+'-error">Please enter valid email address.</span>');
	            		   error = error + 1;
	            		}
	            	}
	            }else{
	            	$('#'+value.name).after('<span class="liststrap-error" id="liststrap-'+value.name+'-error">Please fill the field.</span>');
	            	error = error + 1;
	            }
	        });
	        if(error == 0){
                $.ajax({
	    			url: liststrap_public_ajax_object.ajax_url,
	    			type: 'post',
	    			data: {
	    				action : 'liststrap_subscription_ajax',
	    				form_data : $('#'+get_form_id).serialize(),
	    				liststrap_form_id : get_form_id,
	    			},
                	beforeSend: function() {
                		$(e).attr('disabled', true);
                    	$('#'+get_submit_btn_loader+' > img.liststrap-loader').removeClass('liststrap-hide');                                                        
                	},
	    			success: function(res) {
	    				$(e).removeAttr('disabled');
	    				$('#'+get_submit_btn_loader+' > img.liststrap-loader').addClass('liststrap-hide');
						var obj = JSON.parse(res);
						if(obj.status == 'success'){
							$('#'+obj.form+'-message-success').remove();
	                        $('div[data-tab="'+obj.form+'"] > form').after('<div id="'+obj.form+'-message-success" class="'+obj.form+'-message-success liststrap-success">'+obj.message+'</div>');
	                        setTimeout(function() { 
			            		$('#'+obj.form+'-message-success').remove(); 
			            		$('#'+obj.form).trigger("reset");
			        		}, 3000);							
						}else{
							$('#'+obj.form+'-message-success').remove();
	                        $('div[data-tab="'+obj.form+'"] > form').after('<div id="'+obj.form+'-message-error" class="'+obj.form+'-message-error liststrap-error">'+obj.message+'</div>');
	                    	setTimeout(function() { 
			            		$('#'+obj.form+'-message-error').remove(); 
			        		}, 3000);
						}
	    			}
				});
	        }
		}
	});
})( jQuery );
