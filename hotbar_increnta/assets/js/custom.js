/**
 * Plugin Name: Hot Bar
 * Description: Add top bar with text and button on website.
 * File version: 1.0
 * Author: Alberto González - Increnta
 *
 */

jQuery(document).ready(function(){
	jQuery('.topBar').hide().fadeToggle('slow',function(){
		jQuery('.mk-header-holder').css('top','82px','important');
	});

	jQuery('.closeTopBar').click(function(){
	
		jQuery('.topBar').hide().fadeOut('slow',function(){
			jQuery('.mk-header-holder').css('top','');
		});		
		
	});
});



