<?php
/**
 * Custom Page Theme functions and definitions
 *
 * This file defines the some helper functions and shortcodes, these shortcodes
 * can be embwhich are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Custom Page Theme
 * @subpackage Custom Page Theme Templates
 * @since Custom Page Theme 1.0
 */

 $cpt_themename = basename(__DIR__) ; 

/**
 * Get all assets (like images,scripts and styles) url, to be assed by page any where through shortcode.
 */
function get_custom_page_theme_asset_url($atts, $content = null, $tag ){
	$asset = preg_replace('/^' . preg_quote('custom_page_theme_', '/') . '/', '', preg_replace('/_url$/', '', $tag));
	$asset_url = get_template_directory_uri();
	switch($asset){
		case 'theme':
			$asset_url = get_template_directory_uri();
		break;
		case 'img':
			$asset_url = get_template_directory_uri().'/img/';
		break;
		case 'css':
			$asset_url = get_template_directory_uri().'/css/';
		break;
		case 'js':
			$asset_url = get_template_directory_uri().'/js/';
		break;
    }

	return $asset_url;
}
add_shortcode( 'custom_page_theme_theme_url', 'get_custom_page_theme_asset_url' );
add_shortcode( 'custom_page_theme_img_url', 'get_custom_page_theme_asset_url' );
add_shortcode( 'custom_page_theme_css_url', 'get_custom_page_theme_asset_url' );
add_shortcode( 'custom_page_theme_js_url', 'get_custom_page_theme_asset_url' );




function add_custom_page_theme_nav( $atts ) {
	$a = shortcode_atts( array(
		'menu'	=>	'',
		'menu_class'	=>	'',
		'menu_id'	=>	'',
		'container'	=>	'',
		'container_class'	=>	'',
		'container_id'	=>	'',
		'fallback_cb'	=>	'',
		'before'	=>	'',
		'after'	=>	'',
		'link_before'	=>	'<span class="art">',
		'link_after'	=>	'</span>',
		'echo'	=>	'',
		'depth'	=>	'1',
		'theme_location' => '',
		'walker'	=>	'',
		'items_wrap'	=>	'',
		'item_spacing'	=>	'',
	), $atts );
	$nav = array();
	foreach($a as $key => $value){
		if('' != $value) $nav[$key] =  $value;
	}
    return wp_nav_menu( $nav );
}
add_shortcode( 'custom_page_theme_nav', 'add_custom_page_theme_nav' );




function add_custom_page_theme_widget( $atts, $content = null, $tag ) {
	$a = shortcode_atts( array(
		'classname' => null,
		'title'	=>	null,
		'count'	=>	null,
		'dropdown'	=>	null,
		'hierarchical'	=>	null,
		'category'	=>	null,
		'description'	=>	null,
		'rating'	=>	null,
		'images'	=>	null,
		'name'	=>	null,
		'sortby'	=>	null,
		'exclude'	=>	null,
		'number'	=>	null,
		'url'	=>	null,
		'items' => null,
		'show_summary'	=>	null,
		'show_author'	=>	null,
		'show_date'	=>	null,
		'taxonomy'	=>	null,
		'text'	=>	null,
		'filter'	=>	null,
		'html'	=>	null,
		'cust_args'	=>	null,
		'address'	=>	null,
		'key'	=>	null,
		'width'	=>	null,
		'height'	=>	null,
		'zoom'	=>	null,
		'type'	=>	null,
		'applytitle' =>	null,
		'applycomments' =>null,
	), $atts );
	$nav = array();
	
	//extract the widget type from $tag parameter by removing prefix & postfixs from $tag strig
	$type = preg_replace('/^' . preg_quote('custom_page_theme_', '/') . '/', '', preg_replace('/_widget$/', '', $tag));
	switch($type){
		case 'archives':
			$class = 'WP_Widget_Archives';
		break;
		case 'calendar':
			$class = 'WP_Widget_Calendar';
		break;
		case 'categories':
			$class = 'WP_Widget_Categories';
		break;
		case 'links':
			$class = 'WP_Widget_Links';
		break;
		case 'meta':
			$class = 'WP_Widget_Meta';
		break;
		case 'pages':
			$class = 'WP_Widget_Pages';
		break;
		case 'resent_comments':
			$class = 'WP_Widget_Recent_Comments';
		break;
		case 'recent_posts':
			$class = 'WP_Widget_Recent_Posts';
		break;
		case 'rss':
			$class = 'WP_Widget_RSS';
		break;
		case 'search':
			$class = 'WP_Widget_Search';
		break;
		case 'tag_cloud':
			$class = 'WP_Widget_Tag_Cloud';
		break;
		case 'text':
			$class = 'WP_Widget_Text';
		break;
		case 'googlemap':
			$class = 'CPT_Widget_Googlemap';
		break;
		case 'google_chart':
			$class = 'google_chart';
		break;
		case 'google_doc':
			$class = 'google_doc';
		break;
		case 'banner':
			$class = 'CPT_Widget_Banner';
		break;
		case 'page_content':
			$class = 'CPT_Page_Content';
		break;
	}
	$instance = $args = array();
	foreach($a as $key => $value){
		if(null != $value) $instance[$key] =  $value;
	}
    return the_widget( $class, $instance, $args );
}


add_shortcode( 'custom_page_theme_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_archives_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_calendar_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_categories_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_links_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_meta_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_pages_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_resent_comments_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_recent_posts_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_rss_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_search_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_tag_cloud_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_text_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_googlemap_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_google_chart_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_google_doc_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_banner_widget', 'add_custom_page_theme_widget' );
add_shortcode( 'custom_page_theme_page_content_widget', 'add_custom_page_theme_widget' );


/* Register Google map widget */
class CPT_Widget_Googlemap extends WP_Widget { 

	function __construct() {
		parent::__construct(
			// Base ID of widget
			'CPT_Widget_Googlemap', 

			// Widget name to appear in UI
			__('Googlemap Widget', 'CPT_Widget_Googlemap_domain'), 

			// Widget description
			array( 'description' => __( 'Google Map widget', 'CPT_Widget_Googlemap_domain' ), ) 
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'google_map_api_js' ) );
	}

	/* Enqueue google map script */
	function google_map_api_js() {
		 wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?&sensor=false', false);
	}

	function get_geocode($address, $key=''){ 
    // url encode of address
    $address = urlencode($address);
	$key = isset($key) ? '&key='.urlencode($key) : '';
    $url = "http://maps.google.com/maps/api/geocode/json?address={$address}{$key}";
 
    // get the json response
    $json_resp = file_get_contents($url);
     
    // decode the json
    $resp = json_decode($json_resp, true);
 
    // response status will be 'OK', if able to geocode given address 
    if($resp['status']=='OK'){
 
        // get the important data
        $lat = $resp['results'][0]['geometry']['location']['lat'];
        $lng = $resp['results'][0]['geometry']['location']['lng'];
        $formatted_address = $resp['results'][0]['formatted_address'];
         
        // verify if data is complete
        if($lat && $lng && $formatted_address){
         
            // put the data in the array
            $data_arr = array();            
             
            array_push(
                $data_arr, 
                    $lat, 
                    $lng, 
                    $formatted_address
                );
             
            return $data_arr;
             
        }else{
            return false;
        }
         
    }else{
        return false;
    }
}

	function portraymap($geocode, $canvasId, $zoom = '2', $maptype = 'ROADMAP', $key =''){ 
		$latitude = $geocode[0];
		$longitude = $geocode[1];
		$formatted_address = $geocode[2];
		echo __( '<script type="text/javascript">', 'wpb_widget_domain' );
		echo __( 'function init_map() {', 'wpb_widget_domain' );
		echo __( 'var myOptions = {', 'wpb_widget_domain' );
		echo __( 'zoom: '.$zoom.',', 'wpb_widget_domain' );
		echo __( 'center: new google.maps.LatLng('.$latitude.', '. $longitude.'),', 'wpb_widget_domain' );
		echo __( 'mapTypeId: google.maps.MapTypeId.'.$maptype.'', 'wpb_widget_domain' );
		echo __( '};', 'wpb_widget_domain' );
		echo __( 'map = new google.maps.Map(document.getElementById("'.$canvasId.'"), myOptions);', 'wpb_widget_domain' );
		echo __( 'marker = new google.maps.Marker({', 'wpb_widget_domain' );
		echo __( 'map: map,', 'wpb_widget_domain' );
		echo __( 'position: new google.maps.LatLng('.$latitude.', '. $longitude.')', 'wpb_widget_domain' );
		echo __( '});', 'wpb_widget_domain' );
		echo __( 'infowindow = new google.maps.InfoWindow({', 'wpb_widget_domain' );
		echo __( 'content: "'.$formatted_address.'"', 'wpb_widget_domain' );
		echo __( '});', 'wpb_widget_domain' );
		echo __( 'google.maps.event.addListener(marker, "click", function () {', 'wpb_widget_domain' );
		echo __( 'infowindow.open(map, marker);', 'wpb_widget_domain' );
		echo __( '});', 'wpb_widget_domain' );
		echo __( 'infowindow.open(map, marker);', 'wpb_widget_domain' );
		echo __( '}', 'wpb_widget_domain' );
		echo __( 'google.maps.event.addDomListener(window, "load", init_map);', 'wpb_widget_domain' );
		echo __( '</script>', 'wpb_widget_domain' );
	}


	// Front-end markup for widget 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		$key = '';
		$geocode = $this->get_geocode($instance['address'], $key);
		if($geocode){
			$canvasId = "cpt_".time()."_canvas";
			$w = $h = '200px';
			$z = '2';
			$t = 'ROADMAP';
			$w = isset($instance['width']) ? $instance['width'] : $w;
			$h = isset($instance['height']) ? $instance['height'] : $h;	
			$z = isset($instance['zoom']) ? $instance['zoom'] : $z;
			$t = isset($instance['type']) ? $instance['type'] : $t;
			echo "<div id='$canvasId' style='width:$w;height:$h;'>Loading map...</div>";
			$this->portraymap($geocode, $canvasId, $z, $t, $key);
		}
		echo $args['after_widget'];
	}

}	// Class CPT_Widget_Googlemap ends here


/* Register Banner widget */
class CPT_Widget_Banner extends WP_Widget { 

	private $banner = '';

	function __construct() {
		parent::__construct(
			// Base ID of widget
			'CPT_Widget_Banner', 

			// Widget name to appear in UI
			__('Banner Widget', 'CPT_Widget_Banner_domain'), 

			// Widget description
			array( 'description' => __( 'CPT Banner widget', 'CPT_Widget_Banner_domain' ), ) 
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'jquery_lib_js' ) );
		$this->banner = '<slider><slide><image>'.get_template_directory_uri().'/screenshot.png</image><heading>Custom Page Theme Banner slide1</heading><text>text for slide1</text><link></link></slide><slide><image>'.get_template_directory_uri().'/screenshot.png</image><heading>Custom Page Theme Banner slide2</heading><text>text for slide2</text><link></link></slide></slider>';
	}

	/* Enqueue jQuery min library script */
	function jquery_lib_js() {
		 wp_enqueue_script('jquery-lib', '//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', false);
		 wp_enqueue_style( 'banner-style', get_template_directory_uri() . '/css/banner.css' );
	}

	

	function portraybanner($banner, $bannerId, $w, $h){ 
		$w = '100%';
		$html = '<div id="'.$bannerId.'" style="width:'.$w.';height:'.$h.';"><div class="slider"><div class="container"><div class="slidewrapper">';
		foreach($banner as $k => $v){
			$html .= '<div class="slide" style="z-index:20;">';
            $html .= '<img src="'.$v->image.'" />';
            $html .= '<div class="slidetext">';
            $html .= '<h2>'.$v->heading.'</h2>';
            $html .= '<p>'.$v->text.'</p>';
            if('' !=$v->link)$html .= '<a class="button" href="'.$v->link.'">Learn More</a>';
            $html .= '</div>';
            $html .= '</div>';
		}
		$html .= '</div></div></div></div>';
		echo $html;
		echo '<script type="text/javascript">';
		echo 'var currentSlide = 0;';
		echo 'var totalSlide = jQuery(".slide").length - 1;';
		echo 'jQuery(document).ready(function(){';
		echo 'jQuery.fn.timer = function() { ';
		echo 'if(currentSlide < totalSlide){ ';
		echo 'currentSlide = currentSlide + 1 ; ';
		echo 'jQuery(".slide").eq(currentSlide).animate({ opacity: 1}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).css({ "z-index": 10}) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().animate({ opacity: 0}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().css({ "z-index": 0}) ; ';
		echo 'jQuery("ul.slide_nav li").eq(currentSlide).siblings().children("a").css({ "background":"none"}) ; ';
		echo '} else{ ';
		echo 'currentSlide = 0 ; ';
		echo 'jQuery(".slide").eq(currentSlide).animate({ opacity: 1}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).css({ "z-index": 10}) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().animate({ opacity: 0}, 200) ; ';
		echo 'jQuery(".slide").eq(currentSlide).siblings().css({ "z-index": 0}) ; ';
		echo 'jQuery("ul.slide_nav li").eq(currentSlide).siblings().children("a").css({ "background":"none"}) ; ';
		echo '} ';
		echo '} ';
		echo '}); ';
		echo 'window.setInterval(function() { jQuery("#example").timer() ; }, 4000) ; ';
		echo '</script>';
	}


	// Front-end markup for widget 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// before and after widget arguments are defined by themes
		$this->banner = isset($args['banner']) ? $args['banner'] : $this->banner;
		$bannererXMLData = "<?xml version='1.0' encoding='UTF-8'?>".$this->banner;
		$banner=simplexml_load_string($bannererXMLData) or die("Error: Cannot create object");
		///echo "<pre>"; print_r($xml);echo "</pre>"; 

		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		if($banner){
			$bannerId = "cpt_".time()."_banner";
			$w = $h = '200px';
			$w = isset($instance['width']) ? $instance['width'] : $w;
			$h = isset($instance['height']) ? $instance['height'] : $h;				
			$this->portraybanner($banner, $bannerId, $w, $h);
		}
		echo $args['after_widget'];
	}

}	// Class CPT_Widget_Banner ends here


/* Register Page Content widget */
class CPT_Page_Content extends WP_Widget { 

	function __construct() {
		parent::__construct(
			// Base ID of widget
			'CPT_Page_Content', 

			// Widget name to appear in UI
			__('Content Widget', 'CPT_Page_Content_domain'), 

			// Widget description
			array( 'description' => __( 'CPT Page Content widget', 'CPT_Page_Content_domain' ), ) 
		);
	}

	// Front-end markup for widget 
	public function widget( $args, $instance ) {
		$applytitle = apply_filters( 'applytitle', isset($instance['applytitle']) ? $instance['applytitle']: true );
		$applycomments = apply_filters( 'applycomments', isset($instance['applycomments']) ? $instance['applycomments']: true );
		
		echo $args['before_widget'];

		$containerId = "cpt_".time()."_content_area";
		$w = $h = '200px';
		$w = isset($instance['width']) ? $instance['width'] : $w;
		$h = isset($instance['height']) ? $instance['height'] : $h;		
		echo '<div id="'.$containerId.'" style="width:'.$w.';height:'.$h.';" class="content-area">';
		//Add Comments and comment form if comments is required
		if($applytitle)	the_title( '<h1 class="content-title">', '</h1>' );

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			
			//The content of Post
			the_content();

			/*
			 * Add Comments and comment form if comments is required. Also If the current post is protected by a password and
			 * the visitor has not yet entered the password then comments should not be visible to user.
			 */
			  if($applycomments){
				$commentareaId = "cpt_".time()."_comment_area";
				echo '<div id="'.$commentareaId.'" style="width:'.$w.';height:'.$h.';" class="comments-area">'; 
					
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				comment_form();
				echo '</div>';
			  }
			// End the loop.
		endwhile; else:
			echo '<p>Sorry, no posts matched your criteria.</p>';
		endif;
			echo '</div>';

		echo $args['after_widget'];
	}

}	// Class CPT_Page_Content ends here


/* Register and load all the custom widgets */
function CPT_load_widget() {
	register_widget( 'CPT_Widget_Banner' );
	register_widget( 'CPT_Page_Content' );
	register_widget( 'CPT_Widget_Googlemap' );

}
add_action( 'widgets_init', 'CPT_load_widget' );


/**
 * Enqueue scripts and styles.
 */
${$cpt_themename."_scripts"} = function() {
	global $cpt_themename;
    // Load our main stylesheet.
	wp_enqueue_style( 'cpt-style', get_stylesheet_uri() );

	//enque js files into theme
	$js = get_option( "_".$cpt_themename."_js" );
	if($js ){
		$jslst = unserialize($js);
		foreach($jslst as $key => $value){
			wp_enqueue_script( $key, get_template_directory_uri() . '/js/'.$value, array(), '', true );
		}
	}	

	//enque css files into theme
	$css = get_option( "_".$cpt_themename."_css" );
	if($css ){
		$csslst = unserialize($css);
		foreach($csslst as $key => $value){
			wp_enqueue_style( $key, get_template_directory_uri() . '/css/'.$value );
		}
	}	
};

add_action( 'wp_enqueue_scripts', ${$cpt_themename."_scripts"} );