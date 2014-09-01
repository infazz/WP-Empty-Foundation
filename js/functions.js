// remap jQuery to $
(function($){
	$(document).ready(function (){

		
		
		var body = navigator.userAgent.indexOf("Safari") > -1 ? 'body' : 'html, body';
		
		
	// ---------------------------------------------------------
	// Tabs
	// ---------------------------------------------------------
	jQuery(".tabs").each(function(){
		
		jQuery(this).find(".tab").hide();
		jQuery(this).find(".tab-menu li:first a").addClass("active").show();
		jQuery(this).find(".tab:first").show();
		
	});
	
	jQuery(".tabs").each(function(){
		
		jQuery(this).find(".tab-menu a").on('click', function() {
			
			jQuery(this).parent().parent().find("a").removeClass("active");
			jQuery(this).addClass("active");
			jQuery(this).parent().parent().parent().parent().find(".tab").hide();
			var activeTab = jQuery(this).attr("href");
			jQuery(activeTab).fadeIn();
			return false;
			
		});
		
	});
	

	// ---------------------------------------------------------
	// Toggle
	// ---------------------------------------------------------
	
	
    var allPanels = $('.box');
    var allPanels2 = $('.trigger');
	
	$('.trigger').on('click', function() {
		allPanels.slideUp();
		allPanels2.removeClass('active');
		
		if($(this).next().css('display') != 'block') $(this).addClass('active').next().slideDown();
		
		return false;
	});

	});
})(window.jQuery);



/* optional triggers

$(window).load(function() {
	
});

$(window).resize(function() {
	
});

*/