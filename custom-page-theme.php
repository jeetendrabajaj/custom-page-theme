<?PHP
/**
Plugin Name: Custom Page Theme
Plugin URI: http://patriotmemory.us 
Description: Using this plugin you can craft your wordpress page with a completely different view, irrespective of whatever view your active theme applies over it, with no (or vary small programming). It's page specific theming concept allows you to apply any dormant or idle theme to your wordpress page, through admin panel without any programming intervention. It's Add/Edit Custom Page theme wizard also helps you to convert your html markup into a wordpress theme. So with this plugin you can design your wordpress with you custom html design.
Version: 1.0 
Author: J.K.
Author URI: https://www.linkedin.com/in/jeetendra-bajaj-14020b14/ */ 

if ( ! class_exists( 'CSTM_PAGE_THEME' ) ) :

/**
 * Main CSTM_PAGE_THEME Class.
 *
 * @class CSTM_PAGE_THEME
 * @version	1.0
 */
final class CSTM_PAGE_THEME {
	
	/**
	 * CSTM_PAGE_THEME version.
	 *
	 * @var string
	 */
	public $version = '1.0';

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->include_files();
		$this->initialize_hooks();
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Define Constants.
	 */
	private function define_constants() {
		$this->define( 'CSTM_PAGE_THEME_PLUGIN_FILE', __FILE__ );
		$this->define( 'CSTM_PAGE_THEME_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
		$this->define( 'CSTM_PAGE_THEME_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		$this->define( 'CSTM_PAGE_THEME_FOLDER_PATH', trailingslashit( dirname(get_template_directory())) );
		$this->define( 'CSTM_PAGE_THEME_VERSION', $this->version );
		$this->define( 'CSTM_PAGE_THEME_DELIMITER', '|' );
		//$this->define( 'CSTM_PAGE_THEME_LOG_DIR', $upload_dir['basedir'] . '/CSTM_PAGE_THEME-logs/' );
	}

	/**
	 * Include required lib files.
	 */
	public function include_files() {
		include_once( CSTM_PAGE_THEME_PATH . 'classes/Inc.php' );
	}
	
	/**
	 * Hook into actions and filters.
	 */
	private function initialize_hooks() {
		add_action( "add_meta_boxes", array( $this, "add_custom_page_theme_meta_box" ) );
		add_action( "save_post", array( $this, "save_custom_page_theme" ), 10, 3);
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
		add_action( 'admin_action_cstpgthm10500', array( $this, 'wpse10500_admin_action' ));
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );


		/** 
		 * At User end examin the page request and find the theme->template pointed on this   
		 * page if page is pointed to some custome page theme then hooked function will load 
		 * the attached theme->template else it will open the active theme->template page.
		 */
		add_action( 'setup_theme', array( $this, 'switch_page_theme'));

	}
	
	
	 /**
	 * Add admin menu & it's items.
	 */
	public function admin_menu() {
		add_menu_page( "Custom Page Theme", "Custom Page Theme", "administrator", "cstm-page-theme", array( $this, 'all_cstm_page_theme_lst' ), CSTM_PAGE_THEME_URL.'/img/icon.png', null );

		/*add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $function = '' )*/
		add_submenu_page( 'cstm-page-theme', 'All Custom Page Themes', 'All Custom Page Themes', 'administrator', 'cstm-page-theme', array( $this, 'all_cstm_page_theme_lst' ) );
		add_submenu_page( 'cstm-page-theme', 'Add Custom Page Theme', 'Add Custom Page Theme', 'administrator', 'cstm-page-theme-new', array( $this, 'add_cstm_page_theme_form_markup' ));
		

	}

	/**
	 * Add list of scripts into admin panel
	 */
	public function admin_scripts(){
		wp_enqueue_script( 'admin-script', CSTM_PAGE_THEME_URL . 'js/admin.js', array( 'jquery' ), CSTM_PAGE_THEME_VERSION );
		wp_enqueue_script( 'jquery-ui', CSTM_PAGE_THEME_URL . 'js/jquery-ui.js', array( 'jquery' ), CSTM_PAGE_THEME_VERSION );
		wp_enqueue_style( 'admin-style', CSTM_PAGE_THEME_URL . 'css/admin.css' );
	}

	 /**
	 * Add Custome page theme form markup.
	 */
	function add_cstm_page_theme_form_markup(){
		include( CSTM_PAGE_THEME_PATH . 'views/add_thm.html' );
	}

	 /**
	 * Custome page theme Listing markup.
	 */
	function all_cstm_page_theme_lst(){
		include( CSTM_PAGE_THEME_PATH . 'views/list_thm.php' );
		$template = new CustomPageTheme_List();
		$template->fetch_output();
	}

	 /**
	 * Create a Custome page theme in the theme folder.
	 */	
	function wpse10500_admin_action(){

		if(isset($_POST['submit'])){
			if("" != $_POST['theme_title'] && "" != $_POST['theme_description'] && 0 == $_FILES['theme_index_markup']['error'] && 0 == $_FILES['theme_style']['error'] && "index.php" == $_FILES['theme_index_markup']['name'] && "style.css" == $_FILES['theme_style']['name'] ){
				//echo "<pre>"; print_r($_POST); echo "</pre>";
				//echo "<pre>"; print_r($_FILES); echo "</pre>";
				$theme_name = 'cstpgthm'.time();
				$dir = CSTM_PAGE_THEME_FOLDER_PATH.$theme_name;
				mkdir($dir);
				$inc = new Inc();
			    $inc->rcopy(CSTM_PAGE_THEME_PATH."assets", $dir);
				copy($_FILES['theme_index_markup']['tmp_name'],$dir."/index.php");
				copy($_FILES['theme_style']['tmp_name'],$dir."/style.css");

				//if associative js files uploaded and move it to /js/ folder of theme
				$suportive_js = array();
				if(!empty($_FILES['theme_js'])){
					$jspath = $dir."/js/";
					for($i=0;$i<count($_FILES['theme_js']['tmp_name']);$i++){
						if(0 == $_FILES['theme_js']['error'][$i] && '' != $_POST['theme_js_title'][$i]){
							copy($_FILES['theme_js']['tmp_name'][$i],$jspath.$_FILES['theme_js']['name'][$i]);
							$suportive_js[$inc->string_sanitize($_POST['theme_js_title'][$i])] = $inc->filename_sanitize($_FILES['theme_js']['name'][$i]);
						}
					}
					add_option( '_'.$theme_name.'_js', serialize ($suportive_js) );
				}

				//if associative css files uploaded and move it to /css/ folder of theme
				$suportive_css = array();
				if(!empty($_FILES['theme_css'])){
					$csspath = $dir."/css/";
					for($i=0;$i<count($_FILES['theme_css']['tmp_name']);$i++){
						if(0 == $_FILES['theme_css']['error'][$i] && '' != $_POST['theme_css_title'][$i]){
							copy($_FILES['theme_css']['tmp_name'][$i],$csspath.$_FILES['theme_css']['name'][$i]);
							$suportive_css[$inc->string_sanitize($_POST['theme_css_title'][$i])] = $inc->filename_sanitize($_FILES['theme_css']['name'][$i]);
						}
					}
					add_option( '_'.$theme_name.'_css', serialize ($suportive_css) );
				}
				
				//if associative images uploaded and move it to /img/ folder of theme
				$suportive_img = array();
				if(!empty($_FILES['theme_img'])){
					$imgpath = $dir."/img/";
					for($i=0;$i<count($_FILES['theme_img']['tmp_name']);$i++){
						if(0 == $_FILES['theme_img']['error'][$i]){
							copy($_FILES['theme_img']['tmp_name'][$i],$imgpath.$_FILES['theme_img']['name'][$i]);
						}
					}
				}

				//if associative fonts uploaded and move it to /fonts/ folder of theme
				$suportive_fonts = array();
				if(!empty($_FILES['theme_fonts'])){
					$fontspath = $dir."/fonts/";
					for($i=0;$i<count($_FILES['theme_fonts']['tmp_name']);$i++){
						if(0 == $_FILES['theme_fonts']['error'][$i]){
							copy($_FILES['theme_fonts']['tmp_name'][$i],$fontspath.$_FILES['theme_fonts']['name'][$i]);
						}
					}
				}
				
				$prepand = "/*";
				$prepand .= "\n"."Theme Name: ".$_POST['theme_title'];
				$prepand .= "\n"."Author: Custom Page Theme Plugin Support";
				$prepand .= "\n"."Description: ".$_POST['theme_description'];
				$prepand .= "\n"."Version: 0.0.1";
				//$prepand .= "Tags: bootstrap
				$prepand .= "\n"."*/";
				$inc->prepand_text($prepand, $dir."/style.css");
				$inc->prepand_text("<?php get_header(); ?>"."\r\n", $dir."/index.php");
				$inc->postappand_text("\r\n"."<?php get_footer(); ?>"."\r\n", $dir."/index.php");
			}
		}
		 $url = site_url('/wp-admin/admin.php?page=cstm-page-theme');
		 if ( wp_redirect( $url ) ) {
			exit;
		}
	}

	/**
	 * Hook custom page theme meta box into admin panel edit page.
	 */
	function add_custom_page_theme_meta_box(){
	    add_meta_box("custom-theme-meta-box", "Custom Page Theme",  array( $this, "custom_page_theme_meta_box_markup" ), "page", "side", "low", null);
	}


	/**
	 * Custom page theme meta box markup.
	 */
	function custom_page_theme_meta_box_markup(){
	    global $post;
		$values = get_post_custom( $post->ID );
	    $selected = isset( $values['_custom_page_theme_select'] ) ? esc_attr( $values['_custom_page_theme_select'][0] ) : '';
		// We'll use this nonce field later on when saving.
	    wp_nonce_field( basename(__FILE__), 'meta_box_nonce' );
		echo '<p>';
		$themes = wp_get_themes();  //get the list of themes
		echo '<label for="custom_page_theme_select">Select Page Theme</label>';
		echo '<select name="custom_page_theme_select" id="custom_page_theme_select">';
		echo '<option value="default" '.selected( $selected, 'default' ).'>Default</option>';
		foreach ( $themes as $theme ) {
		   echo '<option value="'.$theme->get_stylesheet().'" '.selected( $selected, $theme->get_stylesheet() ).'>'.$theme->get('Name').'</option>';
		}
		echo '</select>';
		echo '</p>';  
	}
	

	/**
	 * Save the custome page theme selected with the page meta items.
	 */
	function save_custom_page_theme($post_id, $post, $update){ 
	    if (!isset($_POST["meta_box_nonce"]) || !wp_verify_nonce($_POST["meta_box_nonce"], basename(__FILE__)))
		    return $post_id;

		if(!current_user_can("edit_post", $post_id))
			return $post_id;

		if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
			return $post_id;

		$slug = "page";
		if($slug != $post->post_type)
			return $post_id;

	    $custom_page_theme_select = "";

	    if(isset($_POST["custom_page_theme_select"])) {
	        $custom_page_theme_select = $_POST["custom_page_theme_select"];
		}   
	    update_post_meta($post_id, "_custom_page_theme_select", $custom_page_theme_select);
	}

	/** 
	 * At User end examin the page request and find the theme->template pointed on this   
	 * page if page is pointed to some custome page theme then load the attached
	 * theme->template else it will open the active theme->template page.
	 */
	function switch_page_theme() {
		$req_uri = $_SERVER['REQUEST_URI'] ;
		$post_id = url_to_postid( $_SERVER['REQUEST_URI'] );
		
		$selected_page_theme = get_post_meta( $post_id, '_custom_page_theme_select', true );
		$page_theme = ('' != $selected_page_theme && 'default' != $selected_page_theme) ? $selected_page_theme : get_option('stylesheet');

		 add_filter( 'template', create_function( '$t', 'return "' . $page_theme . '";' ) );
		 add_filter( 'stylesheet', create_function( '$s', 'return "' . $page_theme . '";' ) );
	}
}	

endif;

// Global for backwards compatibility.
$GLOBALS['cstm_page_theme'] = new CSTM_PAGE_THEME();