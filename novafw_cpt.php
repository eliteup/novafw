<?php

// Set-up Action and Filter Hooks
register_uninstall_hook(__FILE__, 'novafw_framework_cpt_delete_plugin_options');
add_action('admin_init', 'novafw_framework_cpt_init' );
add_action('admin_menu', 'novafw_framework_cpt_add_options_page');
//RUN ON THEME ACTIVATION
register_activation_hook( __FILE__, 'novafw_framework_cpt_activation' );

// Delete options table entries ONLY when plugin deactivated AND deleted
function novafw_framework_cpt_delete_plugin_options() {
	delete_option('novafw_framework_cpt_display_options');
}

// Flush rewrite rules on activation
function novafw_framework_cpt_activation() {
	flush_rewrite_rules(true);
}

// Init plugin options to white list our options
function novafw_framework_cpt_init(){
	register_setting( 'novafw_framework_cpt_plugin_display_options', 'novafw_framework_cpt_display_options', 'novafw_framework_cpt_validate_display_options' );
}

// Add menu page
if(!( function_exists('novafw_framework_cpt_add_options_page') )){
	function novafw_framework_cpt_add_options_page(){
		$theme = wp_get_theme();
		add_options_page( $theme->get( 'Name' ) . ' Post Type Options', $theme->get( 'Name' ) . ' Post Type Options', 'manage_options', __FILE__, 'novafw_framework_cpt_render_form');
	}
}

// Render the Plugin options form
function novafw_framework_cpt_render_form() { 
	$theme = wp_get_theme();
?>
	
	<div class="wrap">
	
		<!-- Display Plugin Icon, Header, and Description -->
		<?php screen_icon('novafw-cpt'); ?>
		<h2><?php echo $theme->get( 'Name' ) . __(' Custom Post Type Settings','novafw'); ?></h2>
		<b>When you make any changes in this plugin, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks, otherwise your changes will not take effect properly.</b>
		
		<div class="wrap">
		
			<!-- Beginning of the Plugin Options Form -->
			<form method="post" action="options.php">
				<?php settings_fields('novafw_framework_cpt_plugin_display_options'); ?>
				<?php $displays = get_option('novafw_framework_cpt_display_options'); ?>
				
				<table class="form-table">
				<!-- Checkbox Buttons -->
					<tr valign="top">
						<th scope="row">Register Post Types</th>
						<td>

							<label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br /><br />
							<input type="text" size="30" name="novafw_framework_cpt_display_options[portfolio_slug]" value="<?php echo $displays['portfolio_slug']; ?>" placeholder="portfolio" /><br />
							 <br />e.g Entering 'portfolio' will result in www.website.com/portfolio becoming the URL to your portfolio.<br />
							 <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
							 
							 <br />
							 <hr />
							 <br />

							<label><b>Enter the URL slug you want to use for this post type. DO-NOT: use numbers, spaces, capital letters or special characters.</b><br /><br />
							<input type="text" size="30" name="novafw_framework_cpt_display_options[team_slug]" value="<?php echo $displays['team_slug']; ?>" placeholder="team" /><br />
							 <br />e.g Entering 'team' will result in www.website.com/team becoming the URL to your team.<br />
							 <b>If you change this setting, be sure to visit <a href="options-permalink.php">Your Permalink Settings</a> & click the 'save changes' button to refresh & re-write your permalinks.</b></label>
							 
						</td>
					</tr>
				</table>
				
				<?php submit_button('Save Options'); ?>
				
			</form>
		
		</div>

	</div>
<?php 
}

/**
 * Validate inputs for post type options form
 */
function novafw_framework_cpt_validate_display_options($input) {
	
	if( get_option('novafw_framework_cpt_display_options') ){
		
		$displays = get_option('novafw_framework_cpt_display_options');
		
		foreach ($displays as $key => $value) {
			if(isset($input[$key])){
				$input[$key] = wp_filter_nohtml_kses($input[$key]);
			}
		}
	
	}
	return $input;
	
}

function novafw_framework_register_mega_menu() {

    $labels = array( 
        'name' => __( 'Nova Mega Menu', 'novafw' ),
        'singular_name' => __( 'Nova Mega Menu Item', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Nova Mega Menu Item', 'novafw' ),
        'edit_item' => __( 'Edit Nova Mega Menu Item', 'novafw' ),
        'new_item' => __( 'New Nova Mega Menu Item', 'novafw' ),
        'view_item' => __( 'View Nova Mega Menu Item', 'novafw' ),
        'search_items' => __( 'Search Nova Mega Menu Items', 'novafw' ),
        'not_found' => __( 'No Nova Mega Menu Items found', 'novafw' ),
        'not_found_in_trash' => __( 'No Nova Mega Menu Items found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Nova Mega Menu Item:', 'novafw' ),
        'menu_name' => __( 'Nova Mega Menu', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'menu_icon' => 'dashicons-menu',
        'description' => __('Mega Menus entries for the theme.', 'novafw'),
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 40,
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'mega_menu', $args );
}

function novafw_framework_register_portfolio() {

$displays = get_option('novafw_framework_cpt_display_options');

if( $displays['portfolio_slug'] ){ $slug = $displays['portfolio_slug']; } else { $slug = 'portfolio'; }

    $labels = array( 
        'name' => __( 'Portfolio', 'novafw' ),
        'singular_name' => __( 'Portfolio', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Portfolio', 'novafw' ),
        'edit_item' => __( 'Edit Portfolio', 'novafw' ),
        'new_item' => __( 'New Portfolio', 'novafw' ),
        'view_item' => __( 'View Portfolio', 'novafw' ),
        'search_items' => __( 'Search Portfolios', 'novafw' ),
        'not_found' => __( 'No portfolios found', 'novafw' ),
        'not_found_in_trash' => __( 'No portfolios found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Portfolio:', 'novafw' ),
        'menu_name' => __( 'Portfolio', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Portfolio entries for the novafw Theme.', 'novafw'),
        'supports' => array( 'title', 'editor', 'thumbnail', 'post-formats', 'comments' ),
        'taxonomies' => array( 'portfolio-category' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-portfolio',
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'portfolio', $args );
}

function novafw_framework_create_portfolio_taxonomies(){
	$labels = array(
	    'name' => _x( 'Portfolio Categories','novafw' ),
	    'singular_name' => _x( 'Portfolio Category','novafw' ),
	    'search_items' =>  __( 'Search Portfolio Categories','novafw' ),
	    'all_items' => __( 'All Portfolio Categories','novafw' ),
	    'parent_item' => __( 'Parent Portfolio Category','novafw' ),
	    'parent_item_colon' => __( 'Parent Portfolio Category:','novafw' ),
	    'edit_item' => __( 'Edit Portfolio Category','novafw' ), 
	    'update_item' => __( 'Update Portfolio Category','novafw' ),
	    'add_new_item' => __( 'Add New Portfolio Category','novafw' ),
	    'new_item_name' => __( 'New Portfolio Category Name','novafw' ),
	    'menu_name' => __( 'Portfolio Categories','novafw' ),
	  ); 	
  register_taxonomy('portfolio_category', array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => true,
  ));
}

function novafw_framework_register_team() {

$displays = get_option('novafw_framework_cpt_display_options');

if( $displays['team_slug'] ){ $slug = $displays['team_slug']; } else { $slug = 'team'; }

    $labels = array( 
        'name' => __( 'Team Members', 'novafw' ),
        'singular_name' => __( 'Team Member', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Team Member', 'novafw' ),
        'edit_item' => __( 'Edit Team Member', 'novafw' ),
        'new_item' => __( 'New Team Member', 'novafw' ),
        'view_item' => __( 'View Team Member', 'novafw' ),
        'search_items' => __( 'Search Team Members', 'novafw' ),
        'not_found' => __( 'No Team Members found', 'novafw' ),
        'not_found_in_trash' => __( 'No Team Members found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Team Member:', 'novafw' ),
        'menu_name' => __( 'Team Members', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Team Member entries for the novafw Theme.', 'novafw'),
        'supports' => array( 'title', 'thumbnail', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => $slug ),
        'capability_type' => 'post'
    );

    register_post_type( 'team', $args );
}

function novafw_framework_create_team_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Team Categories','novafw' ),
		'singular_name' => _x( 'Team Category','novafw' ),
		'search_items' =>  __( 'Search Team Categories','novafw' ),
		'all_items' => __( 'All Team Categories','novafw' ),
		'parent_item' => __( 'Parent Team Category','novafw' ),
		'parent_item_colon' => __( 'Parent Team Category:','novafw' ),
		'edit_item' => __( 'Edit Team Category','novafw' ), 
		'update_item' => __( 'Update Team Category','novafw' ),
		'add_new_item' => __( 'Add New Team Category','novafw' ),
		'new_item_name' => __( 'New Team Category Name','novafw' ),
		'menu_name' => __( 'Team Categories','novafw' ),
	); 
		
	register_taxonomy('team_category', array('team'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function novafw_framework_register_client() {

    $labels = array( 
        'name' => __( 'Clients', 'novafw' ),
        'singular_name' => __( 'Client', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Client', 'novafw' ),
        'edit_item' => __( 'Edit Client', 'novafw' ),
        'new_item' => __( 'New Client', 'novafw' ),
        'view_item' => __( 'View Client', 'novafw' ),
        'search_items' => __( 'Search Clients', 'novafw' ),
        'not_found' => __( 'No Clients found', 'novafw' ),
        'not_found_in_trash' => __( 'No Clients found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Client:', 'novafw' ),
        'menu_name' => __( 'Clients', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Client entries.', 'novafw'),
        'supports' => array( 'title', 'thumbnail' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-businessman',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'client', $args );
}

function novafw_framework_create_client_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Client Categories','novafw' ),
		'singular_name' => _x( 'Client Category','novafw' ),
		'search_items' =>  __( 'Search Client Categories','novafw' ),
		'all_items' => __( 'All Client Categories','novafw' ),
		'parent_item' => __( 'Parent Client Category','novafw' ),
		'parent_item_colon' => __( 'Parent Client Category:','novafw' ),
		'edit_item' => __( 'Edit Client Category','novafw' ), 
		'update_item' => __( 'Update Client Category','novafw' ),
		'add_new_item' => __( 'Add New Client Category','novafw' ),
		'new_item_name' => __( 'New Client Category Name','novafw' ),
		'menu_name' => __( 'Client Categories','novafw' ),
	); 
		
	register_taxonomy('client_category', array('client'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function novafw_framework_register_testimonial() {

    $labels = array( 
        'name' => __( 'Testimonials', 'novafw' ),
        'singular_name' => __( 'Testimonial', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Testimonial', 'novafw' ),
        'edit_item' => __( 'Edit Testimonial', 'novafw' ),
        'new_item' => __( 'New Testimonial', 'novafw' ),
        'view_item' => __( 'View Testimonial', 'novafw' ),
        'search_items' => __( 'Search Testimonials', 'novafw' ),
        'not_found' => __( 'No Testimonials found', 'novafw' ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Testimonial:', 'novafw' ),
        'menu_name' => __( 'Testimonials', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Testimonial entries.', 'novafw'),
        'supports' => array( 'title', 'editor' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-editor-quote',
        'show_in_nav_menus' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'testimonial', $args );
}

function novafw_framework_create_testimonial_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Testimonial Categories','novafw' ),
		'singular_name' => _x( 'Testimonial Category','novafw' ),
		'search_items' =>  __( 'Search Testimonial Categories','novafw' ),
		'all_items' => __( 'All Testimonial Categories','novafw' ),
		'parent_item' => __( 'Parent Testimonial Category','novafw' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:','novafw' ),
		'edit_item' => __( 'Edit Testimonial Category','novafw' ), 
		'update_item' => __( 'Update Testimonial Category','novafw' ),
		'add_new_item' => __( 'Add New Testimonial Category','novafw' ),
		'new_item_name' => __( 'New Testimonial Category Name','novafw' ),
		'menu_name' => __( 'Testimonial Categories','novafw' ),
	); 
		
	register_taxonomy('testimonial_category', array('testimonial'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function novafw_framework_register_faq() {

    $labels = array( 
        'name' => __( 'FAQs', 'novafw' ),
        'singular_name' => __( 'FAQ', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New FAQ', 'novafw' ),
        'edit_item' => __( 'Edit FAQ', 'novafw' ),
        'new_item' => __( 'New FAQ', 'novafw' ),
        'view_item' => __( 'View FAQ', 'novafw' ),
        'search_items' => __( 'Search FAQs', 'novafw' ),
        'not_found' => __( 'No faqs found', 'novafw' ),
        'not_found_in_trash' => __( 'No FAQs found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent FAQ:', 'novafw' ),
        'menu_name' => __( 'FAQs', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('FAQ Entries.', 'novafw'),
        'supports' => array( 'title', 'editor' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'faq', $args );
}

function novafw_framework_create_faq_taxonomies(){
	
	$labels = array(
		'name' => _x( 'FAQ Categories','novafw' ),
		'singular_name' => _x( 'FAQ Category','novafw' ),
		'search_items' =>  __( 'Search FAQ Categories','novafw' ),
		'all_items' => __( 'All FAQ Categories','novafw' ),
		'parent_item' => __( 'Parent FAQ Category','novafw' ),
		'parent_item_colon' => __( 'Parent FAQ Category:','novafw' ),
		'edit_item' => __( 'Edit FAQ Category','novafw' ), 
		'update_item' => __( 'Update FAQ Category','novafw' ),
		'add_new_item' => __( 'Add New FAQ Category','novafw' ),
		'new_item_name' => __( 'New FAQ Category Name','novafw' ),
		'menu_name' => __( 'FAQ Categories','novafw' ),
	); 
		
	register_taxonomy('faq_category', array('faq'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => true,
	));
  
}

function novafw_framework_register_menu() {

    $labels = array( 
        'name' => __( 'Menu Items', 'novafw' ),
        'singular_name' => __( 'Menu Item', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Menu Item', 'novafw' ),
        'edit_item' => __( 'Edit Menu Item', 'novafw' ),
        'new_item' => __( 'New Menu Item', 'novafw' ),
        'view_item' => __( 'View Menu Item', 'novafw' ),
        'search_items' => __( 'Search Menu Items', 'novafw' ),
        'not_found' => __( 'No Menu Items found', 'novafw' ),
        'not_found_in_trash' => __( 'No Menu Items found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Menu Item:', 'novafw' ),
        'menu_name' => __( 'Menu Items', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Menu Item Entries.', 'novafw'),
        'supports' => array( 'title', 'editor' ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-carrot',
        'show_in_nav_menus' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => false,
        'can_export' => true,
        'rewrite' => false,
        'capability_type' => 'post'
    );

    register_post_type( 'menu', $args );
}

function novafw_framework_create_menu_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Menu Item Categories','novafw' ),
		'singular_name' => _x( 'Menu Item Category','novafw' ),
		'search_items' =>  __( 'Search Menu Item Categories','novafw' ),
		'all_items' => __( 'All Menu Item Categories','novafw' ),
		'parent_item' => __( 'Parent Menu Item Category','novafw' ),
		'parent_item_colon' => __( 'Parent Menu Item Category:','novafw' ),
		'edit_item' => __( 'Edit Menu Item Category','novafw' ), 
		'update_item' => __( 'Update Menu Item Category','novafw' ),
		'add_new_item' => __( 'Add New Menu Item Category','novafw' ),
		'new_item_name' => __( 'New Menu Item Category Name','novafw' ),
		'menu_name' => __( 'Menu Item Categories','novafw' ),
	); 
		
	register_taxonomy('menu_category', array('menu'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => false,
		'rewrite' => false,
	));
  
}

function novafw_framework_register_class() {

    $labels = array( 
        'name' => __( 'Classes', 'novafw' ),
        'singular_name' => __( 'Class', 'novafw' ),
        'add_new' => __( 'Add New', 'novafw' ),
        'add_new_item' => __( 'Add New Class', 'novafw' ),
        'edit_item' => __( 'Edit Class', 'novafw' ),
        'new_item' => __( 'New Class', 'novafw' ),
        'view_item' => __( 'View Class', 'novafw' ),
        'search_items' => __( 'Search Classes', 'novafw' ),
        'not_found' => __( 'No Classes found', 'novafw' ),
        'not_found_in_trash' => __( 'No Classes found in Trash', 'novafw' ),
        'parent_item_colon' => __( 'Parent Classes:', 'novafw' ),
        'menu_name' => __( 'Classes', 'novafw' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => __('Class Entries.', 'novafw'),
        'supports' => array( 'title', 'editor', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'classes' ),
        'capability_type' => 'post'
    );

    register_post_type( 'class', $args );
}

function novafw_framework_create_class_taxonomies(){
	
	$labels = array(
		'name' => _x( 'Class Categories','novafw' ),
		'singular_name' => _x( 'Class Category','novafw' ),
		'search_items' =>  __( 'Search Class Categories','novafw' ),
		'all_items' => __( 'All Class Categories','novafw' ),
		'parent_item' => __( 'Parent Class Category','novafw' ),
		'parent_item_colon' => __( 'Parent Class Category:','novafw' ),
		'edit_item' => __( 'Edit Class Category','novafw' ), 
		'update_item' => __( 'Update Class Category','novafw' ),
		'add_new_item' => __( 'Add New Class Category','novafw' ),
		'new_item_name' => __( 'New Class Category Name','novafw' ),
		'menu_name' => __( 'Class Categories','novafw' ),
	); 
		
	register_taxonomy('class_category', array('class'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => false,
		'rewrite' => false,
	));
  
}