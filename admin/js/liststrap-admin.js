(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
    	 * Liststrap active tab 
    	 */
    	$('li.tab-link').on('click', function(){
    		$('li.tab-link, div.tab-content').removeClass('current');
            $(this).addClass('current');
            var get_tab = $(this).attr('data-tab');
            $('#'+get_tab).addClass('current');
    	});

    	/**
    	 * Liststrap check api and get mailchimp lists
    	 */
    	$('#liststrap_apikey').on('input', function(){
    		var check = $(this).val
    		if(check != '' && check != undefined){
    			$.ajax({
	    			url: liststrap_admin_ajax_object.ajax_url,
	    			type: 'post',
	    			data: {
	    				action 	: 'liststrap_get_lists_ajax',
	    				api_key : $(this).val(),
	    			},
                	beforeSend: function() {
                    	$('#liststrap-apikey > img.liststrap-loader').removeClass('liststrap-hide');                                                        
                	},
	    			success: function(res) {
	    				var option = '';
	    				$('#liststrap-apikey > img.liststrap-loader').addClass('liststrap-hide');
						var obj = JSON.parse(res);
						$('#liststrap-lists').remove();
						if(obj.status == 'success'){
							$(obj.data).each(function( index, value ) {
  								option += '<option value="' + value.id + '">' + value.ucname + '</option>';
							});
							$('#liststrap-status-show').removeClass('neutral').addClass('positive').text(obj.api_status);
							$('div[data-list-key="liststrap-lists"]').after('<div class="form-group w-50 float-left liststrap-lists" id="liststrap-lists" data-list-key="liststrap-lists-data"><label for="liststrap_lists" class="fs-16 lh-24">Select List</label><select id="liststrap_lists" name="liststrap_lists">' + option + '</select></div>');
						}else{
							$('#liststrap-status-show').removeClass('positive').addClass('neutral').text(obj.api_status);
						}
	    			}
				});
    		}
    	});

    	/**
    	 * Liststrap form data save
    	 */
    	$('#liststrap-from-submit').on('click', function(e){
            e.preventDefault();
            var error = 0;
            var message = '';
            var form_data = $('#liststrap-setting').serialize();
            var liststrap_apikey = $('#liststrap_apikey').val();
            var liststrap_lists = $('#liststrap_lists').val();
            if( liststrap_apikey == '' ){
            	error = 1;
            	message = 'Please enter mailchimp api key.';
            }else if( liststrap_apikey == '' && liststrap_lists == undefined ){
            	error = 1;
            	message = 'Please enter mailchimp api key.';
            }else if( liststrap_lists == ''){
            	error = 1;
            	message = 'Please select list.';
            }         
            $.ajax({
                url: liststrap_admin_ajax_object.ajax_url,
                type: 'post',
                data: {
                    action : 'liststrap_form_data_ajax',
                    form_data : form_data,
                },
                beforeSend: function() {
                   $('#liststrap-from-submit-btn > img.liststrap-loader').removeClass('liststrap-hide');                                                         
                },
                success: function(res) {
                	$('#liststrap-from-submit-btn > img.liststrap-loader').addClass('liststrap-hide');
                	if( error == 0){
	                    var obj = JSON.parse(res);
	                    if(obj.status == 'success'){  
	                    	$('#'+obj.form+'-message-success').remove();
	                        $('div[data-list-key="liststrap-from-submit-btn"]').append('<div id="'+obj.form+'-message-success" class="'+obj.form+'-message-success liststrap-success">'+obj.message+'</div>');
	                        setTimeout(function() { 
			            		$('#'+obj.form+'-message-success').remove(); 
			        		}, 3000);
	                    }else{      
	                    	$('#liststrap-setting-message-error').remove();
	                        $('div[data-list-key="liststrap-from-submit-btn"]').append('<div id="'+obj.form+'-message-error" class="'+obj.form+'-message-error liststrap-error">'+obj.message+'</div>');
	                    	setTimeout(function() { 
			            		$('#'+obj.form+'-message-error').remove(); 
			        		}, 3000);                    
	                    }
	                }else{
	                	$('#liststrap-setting-message-error').remove();
	                	$('div[data-list-key="liststrap-from-submit-btn"]').append('<div id="liststrap-setting-message-error" class="liststrap-setting-message-error liststrap-error">'+message+'</div>');
                    	setTimeout(function() { 
		            		$('#liststrap-setting-message-error').remove(); 
		        		}, 3000);
	                }
                }
            });
        });
    });
})( jQuery );
