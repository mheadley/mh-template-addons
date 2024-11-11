<?php /*
Plugin Name: MH template Add ons
Author: Michael Headley
Author URI: https://mheadley.com
Plugin URI: https://mheadley.com/developing/wordpress-plugins/
Description:  Tools to add recipe post type and various tools/settings and blocks to support recipe post types
Version: 1.0.0
License:  GPL v3

*/

class MH_template_addon
{
  protected static $instance = NULL;
  public $post_type;
  public $taxonomies;

  
  /**
   * Used for regular plugin work.
   *
   * @wp-hook plugins_loaded
   * @return  void
   */
  public function plugin_setup()
  {        
    // add taxonmies
    add_action( 'init', array( $this, 'mh_register_recipe_taxonomies' ) );
    // add post type
    add_action( 'init', array( $this, 'mh_register_recipe_posttype' ) );
      
    add_filter('body_class', array( $this, 'mh_template_addons_body_class'));

  }



  /**
   * Constructor, init the functions inside WP
   *
   * @since   1.0.0
   * @return  void
   */
  public function __construct() {
      //init and make recipe post type
      $this->post_type = 'recipe';
      add_action(
          'plugins_loaded',
          array ( $this, 'plugin_setup')
      );
  }

  /**
   * Handler for the action 'init'. Instantiates this class.
   *
   * @since   1.0.0
   * @access  public
   * @return  $instance
   */
  public function get_object() 
  {
      NULL === self::$instance and self::$instance = new self;
      return self::$instance;
  }
  /**
     * Setup Taxonomies
     * Creates 'recipeentry_tag' and 'recipeentry_location' taxonomies.
     * Enhance via filter `mh_template_addons_taxonomies`
     * 
     * @uses    register_taxonomy, apply_filters
     * @since   1.0.0
     * @return  void
     */
    function mh_register_recipe_taxonomies() 
    {
        $mh_template_addons_taxonomies = array();


        $labels = array(
            'name'              => _x( 'Recipe Entry Tags', 'taxonomy general name', 'mh_template_addons_plugin' ),
            'singular_name'     => _x( 'Recipe Entry Tag', 'taxonomy singular name', 'mh_template_addons_plugin' ),
            'search_items'      => __( 'Search Recipe Entry Tags', 'mh_template_addons_plugin' ),
            'all_items'         => __( 'All Recipe Entry Tags', 'mh_template_addons_plugin' ),
            'parent_item'       => __( 'Parent Recipe Entry Tag', 'mh_template_addons_plugin' ),
            'parent_item_colon' => __( 'Parent Recipe Entry Tag:', 'mh_template_addons_plugin' ),
            'edit_item'         => __( 'Edit Recipe Entry Tag', 'mh_template_addons_plugin' ), 
            'update_item'       => __( 'Update Recipe Entry Tag', 'mh_template_addons_plugin' ),
            'add_new_item'      => __( 'Add New Recipe  EntryTag', 'mh_template_addons_plugin' ),
            'new_item_name'     => __( 'New Recipe Entry Tag Name', 'mh_template_addons_plugin' ),
            'menu_name'         => __( 'Entry Tags', 'mh_template_addons_plugin' ),
        );

        $args = array(
            'hierarchical' => FALSE,
            'labels'       => $labels,
            'show_ui'      => TRUE,
            'show_admin_column' => FALSE,
            'query_var'    => TRUE,
            'rewrite'      => TRUE,
            'show_in_rest' => TRUE
        );

        $mh_template_addons_taxonomies[] = array(
            'taxonomy'  => 'recipeentry_tag',
            'post_type' => 'recipeentry',
            'args'      => $args
        );

                
        // categories
        $labels = array(
            'name'              => _x( 'Entry Category', 'taxonomy general name', 'mh_template_addons_plugin' ),
            'singular_name'     => _x( 'Entry Category', 'taxonomy singular name', 'mh_template_addons_plugin' ),
            'search_items'      => __( 'Search Entry Category', 'mh_template_addons_plugin' ),
            'all_items'         => __( 'All Entry Categories', 'mh_template_addons_plugin' ),
            'parent_item'       => __( 'Parent Entry Category', 'mh_template_addons_plugin' ),
            'parent_item_colon' => __( 'Parent Entry Category:', 'mh_template_addons_plugin' ),
            'edit_item'         => __( 'EditEntry Category', 'mh_template_addons_plugin' ), 
            'update_item'       => __( 'Update Entry Category', 'mh_template_addons_plugin' ),
            'add_new_item'      => __( 'Add New Entry Category', 'mh_template_addons_plugin' ),
            'new_item_name'     => __( 'New Entry Category Name', 'mh_template_addons_plugin' ),
            'menu_name'         => __( 'Entry Category', 'mh_template_addons_plugin' ),
        );

        $args = array(
            'hierarchical' => TRUE,
            'labels'       => $labels,
            'show_ui'      => TRUE,
            'query_var'    => TRUE,
            //'rewrite'      => TRUE,
            'rewrite'      => array('slug' => 'recipe/cat', 'with_front' => false),
            'public' 	   => TRUE,
            'show_in_rest' => TRUE,
            'show_in_menu' => TRUE,
            'meta_box_cb' => FALSE,
            'show_admin_column' => FALSE,

        );

        $mh_template_addons_taxonomies[] = array(
            'taxonomy'  => 'recipeentry_category',
            'post_type' => 'recipe',
            'args'      => $args
        );
        foreach ( $mh_template_addons_taxonomies as $attachment_taxonomy ) {
            register_taxonomy(
                $attachment_taxonomy['taxonomy'],
                $attachment_taxonomy['post_type'],
                $attachment_taxonomy['args']
            );
        }
    }
    function mh_template_addons_body_class($classes) {
        $classes[] = 'mh-template-toolkit';
        return $classes;
    }
    function mh_register_recipe_posttype() {
        $labels = array(
          'name'               => _x( 'Recipe', 'post type general name' , 'mh_template_addons_plugin' ),
          'singular_name'      => _x( 'Recipe', 'post type singular name' , 'mh_template_addons_plugin' ),
          'add_new'            => _x( 'Add Entry', 'Recipe Entry' , 'mh_template_addons_plugin' ),
          'add_new_item'       => __( 'Add New Entry' , 'mh_template_addons_plugin' ),
          'edit_item'          => __( 'Edit entry' , 'mh_template_addons_plugin' ),
          'new_item'           => __( 'New entry' , 'mh_template_addons_plugin' ),
          'all_items'          => __( 'All Recipe Entries' , 'mh_template_addons_plugin' ),
          'view_item'          => __( 'View entry' , 'mh_template_addons_plugin' ),
          'search_items'       => __( 'Search entries' , 'mh_template_addons_plugin' ),
          'not_found'          => __( 'No entries found' , 'mh_template_addons_plugin' ),
          'not_found_in_trash' => __( 'No entries found in the Trash' , 'mh_template_addons_plugin' ), 
          'parent_item_colon'  => "’",
          'menu_name'          => 'Recipes'
        );
        $args = array(
          'labels'        => $labels,
          'description'   => 'A complete collection of all the entries that are published.',
          'public'        => true,
            'menu_position' => 5,
            'show_in_rest' => true,
          'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions', 'author' ),
        'has_archive'   => true,
        'rewrite' => array('slug' => 'recipe','with_front' => false),
        'taxonomies' 	      => array('recipeentry_location', 'recipeentry_tag'),
        );
        register_post_type( 'recipe', $args ); 
    }


} 

$mh_template_addons = new MH_template_addon();