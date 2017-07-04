jQuery(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper_js         = jQuery("#supportive_js"); //Fields wrapper_js
    var add_button_js      = jQuery("#add_field_button_js"); //Add button ID
    var wrapper_css         = jQuery("#supportive_css"); //Fields wrapper_css
    var add_button_css      = jQuery("#add_field_button_css"); //Add button ID
    var wrapper_img         = jQuery("#supportive_img"); //Fields wrapper_img
    var add_button_img      = jQuery("#add_field_button_img"); //Add button ID
	var add_button_fnt      = jQuery("#add_field_button_fonts"); //Add button ID
	 var wrapper_fnt         = jQuery("#supportive_fonts"); //Fields supportive_fonts
	
    var x = 1; //initlal text box count
    jQuery(add_button_js).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
		  jQuery(wrapper_js).append('<li class = "default"><span><input type="text" name="theme_js_title[]"></span>&nbsp;&nbsp;&nbsp;<input type="file" name="theme_js[]" value="" /><a href="#" class="remove_field">Remove</a></li>'); //add input box
        }
    });
   
    jQuery(wrapper_js).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); jQuery(this).parent('li').remove(); x--;
    });


	var y = 1; //initlal text box count
    jQuery(add_button_css).click(function(e){ //on add input button click
        e.preventDefault();
        if(y < max_fields){ //max input box allowed
            y++; //text box increment
		  jQuery(wrapper_css).append('<li class = "default"><span><input type="text" name="theme_css_title[]"></span>&nbsp;&nbsp;&nbsp;<input type="file" name="theme_css[]" value="" /><a href="#" class="remove_field">Remove</a></li>'); //add input box
        }
    });
   
    jQuery(wrapper_css).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); jQuery(this).parent('li').remove(); y--;
    });

	var z = 1; //initlal text box count
    jQuery(add_button_img).click(function(e){ //on add input button click
        e.preventDefault();
        if(z < max_fields){ //max input box allowed
            z++; //text box increment
		  jQuery(wrapper_img).append('<li class = "default"><input type="file" name="theme_img[]" value="" /><a href="#" class="remove_field">Remove</a></li>'); //add input box
        }
    });
   
   	var t = 1; //initlal text box count
    jQuery(add_button_fnt).click(function(e){ //on add input button click
        e.preventDefault();
        if(t < max_fields){ //max input box allowed
            t++; //text box increment
		  jQuery(wrapper_fnt).append('<li class = "default"><input type="file" name="theme_fonts[]" value="" /><a href="#" class="remove_field">Remove</a></li>'); //add input box
        }
    });
   

    jQuery(wrapper_img).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); jQuery(this).parent('li').remove(); z--;
    });

});