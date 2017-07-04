<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * CustomPageTheme_List.
 *
 * @author      Jeetendra
 * @category    Admin
 * @package     WPIMAP/Views
 * @version     1.0
 */
class CustomPageTheme_List extends WP_List_Table {

	/**
	 * Max items.
	 *
	 * @var int
	 */
	protected $max_items;

	/**
	 * items.
	 *
	 * @var array
	 */
	protected $item_list;

	/**
	 * items.
	 *
	 * @var array
	 */
	protected $curr;

	/**
	 * Constructor.
	 */
	public function __construct(  ) {

		parent::__construct( array(
			'singular'  => __( 'Custom Theme', 'custom-page-theme' ),
			'plural'    => __( 'Custom Themes', 'custom-page-theme' ),
			'ajax'      => false
		) );
	}

	/**
	 * No items found text.
	 */
	public function no_items() {
		_e( 'No message found.', 'custom-page-theme' );
	}

	/**
	 * Don't need this.
	 *
	 * @param string $position
	 */
	public function display_tablenav( $position ) {

		if ( $position != 'top' ) {
			parent::display_tablenav( $position );
		}
	}

	/**
	 * Arrange views.
	*/
	function get_views(){
		
		 return  array();
	}

	/**
	 * Output the report.
	 */
	function fetch_output(){  
		if(isset($_GET['action'] ) && $_GET['action'] == 'edit' &&  isset($_GET['theme']) && $_GET['theme']  != null ){  
			$theme = $_GET['theme'] ;
			$action = $error = '';
			require_once(ABSPATH.'wp-admin/theme-editor.php');
		} else if(isset($_GET['action'] ) && $_GET['action'] == 'delete' &&  isset($_GET['theme']) && $_GET['theme']  != null ){  
			$theme = $_GET['theme'] ; 
			$this->delete_selected_theme($_GET); 
		} else { 
			$this->prepare_items();       ?>
			<div class="wrap">        
				<div id="icon-users" class="icon32"><br/></div>
				<h2>Custome Page Themes <a href="<?php echo admin_url('admin.php?page=cstm-page-theme-new');  ?>" class="add-new-h2">Add New</a></h2> 
				<form id="plugins-filter" method="get">        
					<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />          
					<?php $this->display() ?>
				</form>        
			</div>
			<?php
		}    
	}

	function delete_selected_theme($get) {
		if( false != get_option( '_'.$get['theme'].'_js' )){
			delete_option( '_'.$get['theme'].'_js' );		
		}
		if( false != get_option( '_'.$get['theme'].'_css' )){
			delete_option( '_'.$get['theme'].'_css' );	
		}
		// remove the theme folder and all it content files recussively
		$inc = new Inc();
		$inc->rrmdir(ABSPATH.'wp-content/themes/'.$get['theme']);
		$args = array(
			'post_type'		=>	'page',
			'meta_query'	=>	array(
				array(
					'key' => '_custom_page_theme_select',
					'value'	=>	$get['theme']
				)
			)
		);
		$my_query = new WP_Query( $args );
		// The Loop
		while ( $my_query->have_posts() ) {
			$my_query->the_post();
			update_post_meta( get_the_id(), '_custom_page_theme_select', 'default' );
		}
	}

	/**
	 * Get column value.
	 *
	 * @param mixed $item
	 * @param string $column_name
	 */
	function column_default( $item, $column_name ) {
	  switch( $column_name ) { 
		case 'name':
		case 'description':
		case 'author':
		case 'folder':
        return $item[ $column_name ];
		default:
		  return print_r( $item, true ) ; //Show the whole array for troubleshooting purposes
	  }
   }

	/**
	 * Get columns.
	 *
	 * @return array
	 */
	public function get_columns() {

		$columns = array(
			'cb'		   => '<input type="checkbox">',
			'folder'	   => __( '#', 'custom-page-theme' ),
			'name'		   => __( 'Name', 'custom-page-theme' ),
			'description'  => __( 'Description', 'custom-page-theme' ),
			'page'		   => __( 'Pages', 'custom-page-theme' ),
			'snapshot'	   => __( 'Snapshot', 'custom-page-theme' ),
			'author'	   => __( 'Author', 'custom-page-theme' ),
		);

		return $columns;
	}
	
	function column_cb($item)    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item['folder']
        );
	}

	function column_page($item) {
		$args = array(
			'post_type'		=>	'page',
			'meta_query'	=>	array(
				array(
					'key' => '_custom_page_theme_select',
					'value'	=>	$item['folder']
				)
			)
		);
		$my_query = new WP_Query( $args );
		$pg="";
		while ( $my_query->have_posts() ) {
			$my_query->the_post();
			$pg .= ($pg == "" ?'' :', '). get_the_title();
		}

		 return sprintf('%s', $pg);   
    }

	function column_snapshot($item) {
       return sprintf(
				'<img src="%s" width="60px" />', get_site_url().'/wp-content/themes/'.$item['folder'].'/screenshot.png'
        );   
    }

	function column_name($item) {
       $actions = array(
		    'edit'    => sprintf('<a href="?page=%s&action=%s&theme=%s">Edit</a>',$_REQUEST['page'],'edit',$item['folder']),
            'delete'    => sprintf('<a href="?page=%s&action=%s&theme=%s">Delete</a>',$_REQUEST['page'],'delete',$item['folder']),
        );
	   return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions) ); 
    }
	



	function process_bulk_action(){echo "123"; die;
        global $wpdb;

        if ('edit' === $this->current_action()) {
            foreach ($_GET['theme'] as $event) {
                // $wpdb->delete($wpdb->prefix.'atb_events', array('id' => $event));
            }
        }

        if ('delete' === $this->current_action()) {
			print_r($_GET);
            // blah blah
        }
	}

	/**
	 * To arrange columns sorting criteria.
	 */
	function get_sortable_columns() {
	  $sortable_columns = array(
		'name'  => array('name',false),
		'description' => array('description',false),
		'author'   => array('author',false),
		'folder'   => array('folder',false)
	  );
	  return $sortable_columns;
	}

	/**
	 * Bulk action dropdown over the table.
	 */
	function get_bulk_actions() {
	  $actions = array(
		'delete'    => 'Delete'
	  );
	  return $actions;
	}

	function countThemes(){
		$themes = wp_get_themes();
		$i = 0;
		foreach ( $themes as $theme ) {
			if (strpos($theme->get_stylesheet(), 'cstpgthm') !== false) {
				$i++;
			}
		}
		return $i;
	}

	private function table_data()
    {
        $data = array();
		$themes = wp_get_themes();
		foreach ( $themes as $theme ) {
			if (strpos($theme->get_stylesheet(), 'cstpgthm') !== false) {
				$data[] = array(
						'id'   => 1,
						'name' => $theme->get('Name'),
						'description' => $theme->get('Description'),
						'author' => $theme->get('Author'),
						'folder' => $theme->get_stylesheet(),
				);
			}
		}
        return $data;
    }

	/**
	 * Prepare message list items.
	 */
	public function prepare_items() {

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);

		$data = $this->table_data();
		/**
		 * Pagination.
		 */
		$per_page = 10;
		$total_items = $this->countThemes(); 
		$current_page = $this->get_pagenum();
		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
		) );

		$this->items = $data; 
	}

	function single_row( $item ) {
		 echo "<tr id='uid-".$item['id']."' class='msgrow'>";
		 echo $this->single_row_columns( $item );
		 echo "</tr>\n";
	}

}
