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

    /**
     * Configure path to Advanced Custom Fields in the plugin.
     *
     * @since 0.0.1
     */
    public function acf_settings_path( $path ) {
        return plugin_dir_url( __FILE__ ) . 'includes/acf/';
    }


    /**
     * Configure directory to Advanced Custom Fields in the plugin.
     *
     * @since 0.0.1
     */
    public function acf_settings_dir( $dir ) {
        return $this->acf_settings_path( $dir );
    }

    /**
     * Enable or disable showing the ACF menu in the admin panel.
     *
     * @since 0.0.1
     */
    public function acf_show_admin( $show ) {
        return false;
    }

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
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) .
                'css/myfossil-resources-admin.css', array(), $this->version,
                'all' );

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
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) .
                'js/myfossil-resources-admin.js', array( 'jquery' ),
                $this->version, false );

    }

}
