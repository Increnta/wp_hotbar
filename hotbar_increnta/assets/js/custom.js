/**
 * Plugin Name: Hot Bar
 * Description: Add top bar with text and button on website.
 * File version: 1.0
 * Author: Alberto González - Increnta
 *
 */

jQuery(document).ready(function(){
	jQuery('.topBar').hide().fadeToggle('slow',function(){
		var h = jQuery('.topBar').height();
		h = h + 'px';
		jQuery('.mk-header-holder').css('top', h,'important');
	});

	jQuery('.closeTopBar').click(function(){
	
		jQuery('.topBar').hide().fadeOut('slow',function(){
			jQuery('.mk-header-holder').css('top','');
		});		
		
	});
});



