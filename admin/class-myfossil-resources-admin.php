<?php
namespace myFOSSIL\Plugin\Resources;

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://github.com/myfossil
 * @since      0.0.1
 *
 * @package    myFOSSIL_Resources
 * @subpackage myFOSSIL_Resources/admin
 */

require_once 'partials/myfossil-resources-admin-display.php';

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    myFOSSIL_Resources
 * @subpackage myFOSSIL_Resources/admin
 */
class myFOSSIL_Resources_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    0.0.1
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    0.0.1
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.0.1
     * @var      string    $plugin_name       The name of this plugin.
     * @var      string    $version    The version of this plugin.
     * @param unknown $plugin_name
     * @param unknown $version
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function register_menus() {
        /**
         * myFOSSIL Logging administrator settings page.
         */
        add_options_page('myFOSSIL Resources', 'myFOSSIL Resources',
                'administrator', 'myfossil-resources',
                'myFOSSIL\Plugin\Resources\Admin\admin_settings_page' );
    }

    // {{{ Places configuration methods
    /**
     * Create the custom post type Place.
     *
     * This function also calls the function to create the Advanced Custom
     * Fields (ACF) for the Place post type.
     *
     * @author  Joseph Furlott <jmfurlott@geometeor.com>
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @param bool    $acf (optional) Whether to create ACF for post type, default true.
     * @return  bool    True upon success, false upon failure.
     */
    public static function create_places()
    {
        // {{{ Places, labels
        $labels = array(
            'name'               => __( 'Places', 'fossil' ),
            'singular_name'      => __( 'Place', 'fossil' ),
            'menu_name'          => __( 'Places', 'fossil' ),
            'name_admin_bar'     => __( 'Place', 'fossil' ),
            'add_new'            => __( 'Add New', 'fossil' ),
            'add_new_item'       => __( 'Add New Place', 'fossil' ),
            'new_item'           => __( 'New Place', 'fossil' ),
            'edit_item'          => __( 'Edit Place', 'fossil' ),
            'view_item'          => __( 'View Place', 'fossil' ),
            'all_items'          => __( 'All Places', 'fossil' ),
            'search_items'       => __( 'Search Places', 'fossil' ),
            'parent_item_colon'  => __( 'Parent Places:', 'fossil' ),
            'not_found'          => __( 'No Places found.', 'fossil' ),
            'not_found_in_trash' => __( 'No Places found in Trash.', 'fossil' )
        );
        // }}}
        // {{{ Places, arguments
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'menu_icon'          => 'dashicons-location-alt',
            'rewrite'            => array( 'slug' => 'place' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail',  'comments' )
        );
        // }}}

        // Tell WordPress.
        return register_post_type( 'place', $args );
    }

    // }}}

    // {{{ Events configuration methods
    /**
     * Create the custom post type Event.
     *
     * This function also calls the function to create the Advanced Custom
     * Fields (ACF) for the Event post type.
     *
     * @author  Joseph Furlott <jmfurlott@geometeor.com>
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @param   bool    $acf (optional) Whether to create ACF for post type, default true.
     * @return  bool    True upon success, false upon failure.
     */
    public static function create_events()
    {
        // {{{ Events, labels
        $labels = array(
            'name'               => __( 'Events', 'fossil' ),
            'singular_name'      => __( 'Event', 'fossil' ),
            'menu_name'          => __( 'Events', 'fossil' ),
            'name_admin_bar'     => __( 'Event', 'fossil' ),
            'add_new'            => __( 'Add New', 'fossil' ),
            'add_new_item'       => __( 'Add New Event', 'fossil' ),
            'new_item'           => __( 'New Event', 'fossil' ),
            'edit_item'          => __( 'Edit Event', 'fossil' ),
            'view_item'          => __( 'View Event', 'fossil' ),
            'all_items'          => __( 'All Events', 'fossil' ),
            'search_items'       => __( 'Search Events', 'fossil' ),
            'parent_item_colon'  => __( 'Parent Events:', 'fossil' ),
            'not_found'          => __( 'No Events found.', 'fossil' ),
            'not_found_in_trash' => __( 'No Events found in Trash.', 'fossil' )
        );
        // }}}
        // {{{ Events, arguments
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'menu_icon'          => 'dashicons-calendar',
            'rewrite'            => array( 'slug' => 'event' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail',  'comments' )
        );
        // }}}

        // Tell WordPress.
        return register_post_type( 'event', $args );
    }


    /**
     * ajax callback for admin panel ajax
     */
    public function ajax_handler() {
        if ( $_POST[ 'action'] == 'myfr_load_data' ) {
            echo (int) self::load_data_places();
        }
        die();
    }

    // {{{ WordPress, enqueues
    /**
     * Register the stylesheets for the Dashboard.
     *
     * @since    0.0.1
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in myFOSSIL_Resources_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The myFOSSIL_Resources_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( realpath( __FILE__ ) ) .
                'css/myfossil-resources-admin.css', array(), $this->version,
                'all' );

        wp_enqueue_style( 'fontawesome',
                "//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css",
                array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the dashboard.
     *
     * @since    0.0.1
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in myFOSSIL_Resources_Admin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The myFOSSIL_Resources_Admin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( realpath( __FILE__ ) ) .
                'js/myfossil-resources-admin.js', array( 'jquery' ),
                $this->version, false );
    }
    // }}}

}
