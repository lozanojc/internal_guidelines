jQuery(function($)
{
	// Excerpt show
	$('#postexcerpt-hide:not(:checked)').prop('checked', true);
	$('#postexcerpt').show();

	// Slider init
	window.gallerySliderInit = function()
	{
		$('.media-modal:visible')
			.each(function(index, el) {
				$('.sn_gallery_type', this).toggle( $('select[data-setting="type"]', this).val() !== 'normal' );
			});
	};

	//
	$(document)
		// Post admin
		.on('change', 'input.post-format', function(event)
		{
			var id;

			switch(this.id)
			{
				case 'post-format-gallery':
					id = '#post-gallery';
					break;
				case 'post-format-video':
					id = '#post-video';
					break;
				case 'post-format-link':
					id = '#post-link';
					break;
				case 'post-format-quote':
					id = '#post-quote';
					break;
				case 'post-format-audio':
					id = '#post-audio';
					break;
				default:
					id = '#post-others'
			}

			$('#post-gallery, #post-video, #post-link, #post-quote, #post-audio').show().not(id).hide()
		})
		// Font admin
		.on('change', '#section-sn_css_font_settings input:radio', function(event)
		{
			var id;

			switch(this.id)
			{
				case 'optionsframework_spacetype-sn_css_font_settings-typekit':
					id = '#wrap-typekit';
					break;
				case 'optionsframework_spacetype-sn_css_font_settings-google_fonts':
					id = '#wrap-google_fonts';
					break;
				case 'optionsframework_spacetype-sn_css_font_settings-custom_fonts':
					id = '#wrap-custom_fonts';
					break;
				default:
					id = '#wrap-other_fonts'
			}

			$('#wrap-typekit, #wrap-google_fonts, #wrap-custom_fonts').show().not(id).hide()
		})
		// Galery admin
		.on('change', 'select[data-setting="type"]', function(event)
		{
			window.gallerySliderInit();
		})
		// Trigger to start
		.find('input.post-format:checked, #section-sn_css_font_settings input:radio:checked')
			.trigger('change')



})
