jQuery(document).ready(function() {
	// Mobile navigation
	jQuery(".mobile-nav .icon-menu").click(function(){
		jQuery("#site-nav").toggleClass("mobile-nav-open");
		jQuery(".mobile-nav i").toggleClass("icon-close").toggleClass("icon-menu");

	});

	jQuery(".menu-item-has-children").click(function(){	
		if (jQuery(this).is(".show-submenu")) {
			jQuery(".menu-item-has-children").removeClass("show-submenu");
		} else {
			jQuery(".menu-item-has-children").removeClass("show-submenu");
			jQuery(this).addClass("show-submenu");
		}
	});

	jQuery("#site-main").click(function(){	
			jQuery(".menu-item-has-children").removeClass("show-submenu");
	});


	// Search toggle

	jQuery(".filter-toggle").click(function(){
		jQuery(".search-filter").toggleClass("open-filter");
	});


	// Tablist

	jQuery(".tablist .tablist-item").click(function(){	
		if (jQuery(this).is(".active-tablist")) {
			jQuery(".tablist .tablist-item").removeClass("active-tablist");
			jQuery("i", this).removeClass("icon-rotated");
		} else {
			jQuery(".tablist .tablist-item").removeClass("active-tablist");
			jQuery(this).addClass("active-tablist");
			jQuery(".tablist .tablist-item i").removeClass("icon-rotated");
			jQuery("i", this).addClass("icon-rotated");
		}
	});


	// Select first 10 checkboxes

	jQuery(".fast-print").click(function(){
		jQuery( ".contact-table input" ).prop( "checked", false );
		jQuery( ".contact-table input" ).slice( 0, 10 ).prop( "checked", true );
	});


	// Disable print button if nothing is checked
	
	jQuery('input[type="checkbox"]').click(function() {
		var atLeastOneIsChecked = jQuery('.contact-table input[type="checkbox"]:checked').length > 0;

       	if(atLeastOneIsChecked == true) {
        	jQuery(".selection-print").prop('disabled', false);
       	}  else {
       		jQuery(".selection-print").prop('disabled', true);
       	}
    });

	
	// Show sidebar filters

	jQuery(".show-filters").click(function(){
		jQuery(this).next().toggleClass("show");
		jQuery("i",this).toggleClass("icon-plus").toggleClass("icon-plus icon-rotated");
	});

});

	