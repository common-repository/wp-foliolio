<?php
/*
Plugin Name: WP-Foliolio
Plugin URI: http://mjco.me.uk
Description: A portfolio plugin featuring a Project post-type.
Author: MJCO Web Development
Version: 0.2.5
Author URI: http://mjco.me.uk
License: GPL2
*/
require_once("WPFO_Project.php");
require_once("template-tags.php");

/*  Copyright 2011 Michael O'Toole  (Contact: http://mjco.me.uk/contact/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class WPFoliolio
{
    const WP_OPTION_GROUP = "wpfo_foliolio-option-group";	
	
	var $meta_fields = array("folio-url", "folio-clientname", "folio-date", "folio-punp", "folio-clurl", "folio-clsec");
	var $pluginDir;
	var $pluginUrl;
	var $templateDir;
	
	function WPFoliolio()
	{
		$this->pluginDir = dirname( __FILE__ );
		$url = get_bloginfo('wpurl');
		$this->pluginUrl = $url."/wp-content/plugins/wp-foliolio";
		$this->templateDir = $this->pluginDir . "/views/";
		
		// Register custom post types
		register_post_type('project', array(
			'label' => __('Projects'),
			'singular_label' => __('Project'),
			'labels' => array(
				'name' => __( 'Projects' ),
				'singular_name' => __( 'Project' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Project' ),
				'edit' => __( 'Edit' ),
				'edit_item' => __( 'Edit Project' ),
				'new_item' => __( 'New Project' ),
				'view' => __( 'View Project' ),
				'view_item' => __( 'View Project' ),
				'search_items' => __( 'Search Projects' ),
				'not_found' => __( 'No projects found' ),
				'not_found_in_trash' => __( 'No projects found in Trash' ),
				'parent' => __( 'Parent Project' ),
			),
			'public' => true,
			'show_ui' => true, // UI in admin panel
			'_builtin' => false, // It's a custom post type, not built in
			'_edit_link' => 'post.php?post=%d',
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array("slug" => "project"), // Permalinks
			'query_var' => "project", // This goes to the WP_Query schema
			'supports' => array('title','author', 'excerpt', 'editor', 'thumbnail', 'comments' /*,'custom-fields'*/) // Let's use custom fields for debugging purposes only
		));
		
		add_filter("manage_edit-project_columns", array(&$this, "edit_columns"));
		add_action("manage_posts_custom_column", array(&$this, "custom_columns"));
		
		$tax_labels = array(
		    'name' => _x( 'Platforms', 'taxonomy general name' ),
		    'singular_name' => _x( 'Platform', 'taxonomy singular name' ),
		    'search_items' =>  __( 'Search Platforms' ),
		    'all_items' => __( 'All Platforms' ),
		    'parent_item' => __( 'Parent Platform' ),
		    'parent_item_colon' => __( 'Parent Platform:' ),
		    'edit_item' => __( 'Edit Platform' ), 
		    'update_item' => __( 'Update Platform' ),
		    'add_new_item' => __( 'Add New Platform' ),
		    'new_item_name' => __( 'New Platform Name' ),
		  );
		
		// Register custom taxonomy
		register_taxonomy("platform", array("project"), array(
			"hierarchical" => true, 
			"labels" => $tax_labels,
			"rewrite" => array('slug' => "platform")
		));
		
		//register_taxonomy_for_object_type('project', 'platform');
		
		// Admin interface init
		add_action("admin_init", array(&$this, "admin_init"));
		add_action("template_redirect", array(&$this, 'template_redirect'));
		
		// Insert post hook
		add_action("wp_insert_post", array(&$this, "wp_insert_post"), 10, 2);
		
		//Wp Head Hook
		add_action('wp_head', array(&$this, 'portfolio_headers'));
		
		//Wp Admin Head Hook
		add_action('admin_head', array(&$this, 'folio_admin_header'));
		
		//Add Menu Item
		add_action('admin_menu', array(&$this, 'wp_folio_menu'));
		//Add Admin Settings
		add_action('admin_init',  array(&$this, 'register_mysettings'));
		
		//Default Options
		register_activation_hook( __FILE__, 'activate_wp_folio' );
		register_deactivation_hook( __FILE__, 'deactivate_wp_folio' );
	}
	
	function admin_init() 
	{
		// Custom meta boxes for the edit project screen
		add_meta_box("folio-meta", "Project Details", array(&$this, "meta_details"), "project", "normal", "low");
	}
	
	function activate_wp_folio()
	{
		add_option("wpfo_projects_title", 'Projects |');
		add_option("wpfo_projects_showtitle", 'off');
		add_option("wpfo_projects_postmeta", 'off');
		add_option("wpfo_projects_platforms", 'off');
		flush_rewrite_rules();
	}
	
	function deactivate_wp_folio()
	{
		delete_option("wpfo_projects_title");
		delete_option("wpfo_projects_showtitle");
		delete_option("wpfo_projects_postmeta");
		delete_option("wpfo_projects_platforms");
		flush_rewrite_rules();
	}
	
	function wp_folio_menu() 
	{
		add_submenu_page('edit.php?post_type=project', __('Options','options'), __('Options','options'), 
		'manage_options', 'wpfolio-options', array(&$this, 'wp_folio_options'));
	}
	
	function wp_folio_options() 
	{
		if (!current_user_can('manage_options'))  
		{
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		require_once("incl/options.incl.php");
	}
	
	function register_mysettings() 
	{ // whitelist options
		register_setting( self::WP_OPTION_GROUP, 'wpfo_projects_showtitle' );
		register_setting( self::WP_OPTION_GROUP, 'wpfo_projects_postmeta' );
		register_setting( self::WP_OPTION_GROUP, 'wpfo_projects_platform' );
	}
	
	function folio_admin_header()
	{
		require_once("incl/adminhead.incl.php");
	}
	
	function edit_columns($columns)
	{
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => "Project Title",
			"folio_description" => "Description",
			"folio_url" => "URL",
			"folio_clientname" => "Client Name",
			"folio_clurl" => "Client URL",
			"folio_clsec" => "Client Sector",
			"folio_date" => "Completion Date",
			"folio_punp" => "Type of Work",	
		);
		
		return $columns;
	}
	
	function custom_columns($column)
	{
		global $post;
		switch ($column)
		{
			case "folio_description":
				the_excerpt();
				break;
			case "folio_url":
				$custom = get_post_custom();
				echo $custom["folio-url"][0];
				break;
			case "folio_clientname":
				$custom = get_post_custom();
				echo $custom["folio-clientname"][0];
				break;
			case "folio_clurl":
				$custom = get_post_custom();
				echo $custom["folio-clurl"][0];
				break;
			case "folio_clsec":
				$custom = get_post_custom();
				echo $custom["folio-clsec"][0];
				break;
			case "folio_date":
				$custom = get_post_custom();
				echo $custom["folio-date"][0];
				break;
			case "folio_punp":
				$custom = get_post_custom();
				echo $custom["folio-punp"][0];
				break;
		}
	}
	
	//Insert stuff into header where needed
	function portfolio_headers()
	{
		//Could check for existence of css and js in user template here
		require_once("incl/header.incl.php");
	}
	
	// Template selection
	function template_redirect()
	{
		global $wp;

		//print_r($wp->query_vars);
		if (array_key_exists("post_type", $wp->query_vars) &&
			$wp->query_vars["post_type"] == "project")
		{
			//include(TEMPLATEPATH . "/project.php");
			if( '' == locate_template( array( 'portfolio/single-project.php' ), true ) ) 
			{
				include( $this->templateDir . "single-project.php");
				die();
			}
			
		}
		if (array_key_exists("taxonomy", $wp->query_vars) &&
			$wp->query_vars["taxonomy"] == "platform")
		{
			if( '' == locate_template( array( 'portfolio/taxonomy-platform.php' ), true ) ) 
			{
				include( $this->templateDir . "taxonomy-platform.php");
				die();
			}
			
		}
		if ((array_key_exists("pagename", $wp->query_vars) && $wp->query_vars["pagename"] == "projects") ||
			(array_key_exists("page_id", $wp->query_vars) && $wp->query_vars["page_id"] == "projects"))
		{
			if( '' == locate_template( array( 'portfolio/projects.php' ), true ) ) 
			{	
				//Edit title of projects page
				add_filter('wp_title', array(&$this, 'edit_projects_page_title'));
				include( $this->templateDir . "projects.php");
				die();
			}

		}
		
		
	}
	
	function edit_projects_page_title()
	{
		return  get_option('wpfo_projects_title')." ";
	}
	
	// When a post is inserted or updated
	function wp_insert_post($post_id, $post = null)
	{
		if ($post->post_type == "project")
		{
			// Loop through the POST data
			foreach ($this->meta_fields as $key)
			{
				$value = @$_POST[$key];
				if (empty($value))
				{
					delete_post_meta($post_id, $key);
					continue;
				}

				// If value is a string it should be unique
				if (!is_array($value))
				{	
					// Update meta
					if (!update_post_meta($post_id, $key, $value))
					{
						// Or add the meta data
						add_post_meta($post_id, $key, $value);
					}
				}
				else
				{
					// If passed along is an array, we should remove all previous data
					delete_post_meta($post_id, $key);
					
					// Loop through the array adding new values to the post meta as different entries with the same name
					foreach ($value as $entry)
						add_post_meta($post_id, $key, $entry);
				}
			}
		}
		flush_rewrite_rules();
	}
	
	// Admin post meta contents
	function meta_details()
	{
		global $post;
		$custom = get_post_custom($post->ID);
		$url = $client = $date = $punp = $clurl = $clsec = "";
		
		if(array_key_exists("folio-url", $custom))
			$url = $custom["folio-url"][0];
			
		if(array_key_exists("folio-clientname", $custom))
			$client = $custom["folio-clientname"][0];
		
		if(array_key_exists("folio-clurl", $custom))
			$clurl = $custom["folio-clurl"][0];
			
		if(array_key_exists("folio-clsec", $custom))
			$clsec = $custom["folio-clsec"][0];
			
		if(array_key_exists("folio-date", $custom))
			$date = $custom["folio-date"][0];

		if(array_key_exists("folio-punp", $custom))
			$punp = $custom["folio-punp"][0];
			
		//Include Editor  
		require_once("incl/editor.incl.php");
	}
	
}

// Define Our Widget
class Platforms_Widget extends WP_Widget
{
  function Platforms_Widget()
  {
    $widget_ops = array('classname' => 'Platforms_Widget', 'description' => 'A widget to display the platforms list');
    $this->WP_Widget('Platforms_Widget', 'Platforms Widget', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args((array) $instance, array( 'title' => '' ));
    $title = $instance['title'];
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
	  
    // Do Your Widgety Stuff Here...
	wp_tag_cloud( array( 'taxonomy' => 'platform', 'number' => 45 ) );
 
    echo $after_widget;
  }
}
add_action( 'widgets_init', create_function('', 'return register_widget("Platforms_Widget");') );

// Initiate the plugin
add_action("init", "WPFoliolioInit");
function WPFoliolioInit() 
{ 
	global $foliolio;
	$foliolio = new WPFoliolio();
}