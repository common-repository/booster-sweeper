jQuery(document).ready(function($) {
	"use strict";
	
	/**
	 * Validate alphanumeric + "-_;" allowed.
	 */
	$.fn.bs_validate_alphanumeric = function() {
		var validate_characters     =   /[^A-Za-z0-9-_; \n]/,
			error_text				=	booster_sweeper_localize.error_text,
			validation_error_text   =   '<div class="bs-validation-error-message" style="color:red;padding: 3px 0;">' +error_text +'</div>';
		this.find('input[type="text"], textarea').each(function() {
			// show the error message on the load, if it exists
			if ($(this).val().match(validate_characters)) {
				// add validation error to the field
				if (!$(this).siblings('.bs-validation-error-message').length) {
					$(this).after(validation_error_text);
				}
			}
			$(this).on('input', function() {
				if ($(this).val().match(validate_characters)) {
					// add validation error to the field
					if (!$(this).siblings('.bs-validation-error-message').length) {
						$(this).after(validation_error_text);
					}
				} else {
					if ($(this).siblings('.bs-validation-error-message').length) {
						// remove the validation error from the field
						$(this).siblings('.bs-validation-error-message').remove();
					}
				}
			});
		});
		return this;
	};
	$(".bs-valid-alphanumeric").bs_validate_alphanumeric();

	/** 
	 * Validate numbers and space field.
	 */
	$.fn.bs_validate_numbers_space = function() {
		var validate_characters     =   /[^0-9 ]/, // numeric and space allowed
			validation_error_text   =   '<div class="bs-validation-error-message" style="color:red;padding: 3px 0;">Only numeric characters allowed!</div>';
		this.find('input[type="text"]').each(function() {
			// show the error message on the load, if it exists
			if ($(this).val().match(validate_characters)) {
				// add validation error to the field
				if (!$(this).siblings('.bs-validation-error-message').length) {
					$(this).after(validation_error_text);
				}
			}
			$(this).on('input', function() {
				if ($(this).val().match(validate_characters)) {
					// add validation error to the field
					if (!$(this).siblings('.bs-validation-error-message').length) {
						$(this).after(validation_error_text);
					}
				} else {
					if ($(this).siblings('.bs-validation-error-message').length) {
						// remove the validation error from the field
						$(this).siblings('.bs-validation-error-message').remove();
					}
				}
			});
		});
		return this;
	};
	$(".bs-valid-numbers-space").bs_validate_numbers_space();

	/**
	 * Reset the individual Post's metabox of the Booster Sweeper (the function is in the Pro version: reset.php file).
	 */
	var reset_post_id	=	$('.bs-reset-post-id');
	reset_post_id.on('click', '.csf-after-text', function() {
		// set data for ajax
		var data = {
			'action': 'booster_sweeper_reset_post',
			'post_id': reset_post_id.find('input').val(),
			'nonce': booster_sweeper_localize.resetpostid_nonce,
		};
		// ajax update
		$.post(
			booster_sweeper_localize.ajax_url,
			data,
			function(response) {
				reset_post_id.addClass('postid-reseted');
				reset_post_id.find('input').val('');
				reset_post_id.find('input').attr('placeholder', response);
			}
		);
	});

}); // end jQuery
