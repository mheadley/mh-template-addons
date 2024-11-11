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
 


} 

$mh_template_addons = new MH_template_addon();