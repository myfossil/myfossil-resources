<?php
namespace myFOSSIL\Plugin\Resources;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://github.com/myfossil
 * @since      0.0.1
 *
 * @package    myFOSSIL_Resources
 * @subpackage myFOSSIL_Resources/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to enqueue
 * the dashboard-specific stylesheet and JavaScript.
 *
 * @package    myFOSSIL_Resources
 * @subpackage myFOSSIL_Resources/public
 */
class myFOSSIL_Resources_Public
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
     * @var      string    $plugin_name       The name of the plugin.
     * @var      string    $version    The version of this plugin.
     * @param unknown $plugin_name
     * @param unknown $version
     */
    public function __construct( $plugin_name, $version )
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public static function rksort( &$array ) {
        foreach ( $array as &$value )
            if ( is_array( $value ) ) 
                self::rksort( $value );
        return ksort( $array );
    }

    // {{{ AJAX for grabbing stuff
    /**
     * ajax call handler
     *
     * @todo abstract state and type listings
     */
    public function ajax_handler() {
        header('Content-Type: application/json');

        // Check nonce
        if ( !check_ajax_referer( 'myfr_filter', 'nonce', false ) ) {
            $return_args = array(
                "result" => "Error",
                "message" => "403 Forbidden",
                );

            echo json_encode( $return_args );
            die;
        }

        $places = get_posts( 
                array( 
                    'post_type' => 'place', 
                    'posts_per_page' => -1 
                )
            );

        switch ( $_POST['action'] ) {
            case 'myfr_list_states':
                $states = array();
                foreach ( $places as $pl )
                    $states[] = parse_meta( get_post_meta( $pl->ID ) )[ 'state' ];
                asort( $states );

                echo json_encode( array_values( array_unique( $states ) ) );
                die;

                break;


            case 'myfr_list_types':
                $types = array();
                foreach ( $places as $pl )
                    $types[] = parse_meta( get_post_meta( $pl->ID ) )[ 'type' ];
                asort( $types );

                echo json_encode( array_values( array_unique( $types ) ) );

                die;
                break;


            case 'myfr_list_places':
                $pl_array = array();
                foreach ( $places as $pl ) {
                    $fields = parse_meta( get_post_meta( $pl->ID ) );
                    $fields[ 'title' ] = $pl->post_title;
                    $fields[ 'content' ] = $pl->post_content;
                    array_push( $pl_array, $fields );
                }

                echo json_encode( array( 'places' => $pl_array ) );

                die;
                break;
        }
    }
    // }}}


    // {{{ Enqueues
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    0.0.1
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in myFOSSIL_Resources_Public_Loader as all of the hooks are
         * defined in that particular class.
         *
         * The myFOSSIL_Resources_Public_Loader will then create the
         * relationship between the defined hooks and the functions defined in
         * this class.
         */
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) .
                'css/myfossil-resources-public.css', array(), $this->version,
                'all' );

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    0.0.1
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in myFOSSIL_Resources_Public_Loader as all of the hooks are
         * defined in that particular class.
         *
         * The myFOSSIL_Resources_Public_Loader will then create the
         * relationship between the defined hooks and the functions defined in
         * this class.
         */
        wp_enqueue_script( 'es5-shim',
                '//cdnjs.cloudflare.com/ajax/libs/es5-shim/4.0.3/es5-shim.js',
                array( 'jquery' ), $this->version, false );
        wp_enqueue_script( 'handlebars',
                '//cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.js',
                array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) .
                'js/myfossil-resources-public.js', array( 'jquery' ),
                $this->version, false );

    }
    // }}}
}