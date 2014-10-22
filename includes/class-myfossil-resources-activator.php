<?php
namespace myFOSSIL\Plugin\Resources;

/**
 * Fired during plugin activation
 *
 * @link    http://github.com/myfossil
 * @since   0.0.1
 *
 * @subpackage myFOSSIL_Resources/includes
 * @author  Joseph Furlott <jmfurlott@geometeor.com>
 * @author  Brandon Wood <btwood@geometeor.com>
 * @package    myFOSSIL_Resources
 */


/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.1
 * @package    myFOSSIL_Resources
 * @subpackage myFOSSIL_Resources/includes
 */
class myFOSSIL_Resources_Activator
{

    /**
     * Fired during plugin activation.
     *
     * This class defines all code necessary to run during the plugin's
     * activation.
     *
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @return  bool    True upon success, false upon failure.
     */
    public static function activate()
    {
    }

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
     * Returns whether ACF is currently supported for the given CPT.
     *
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @param   string  $post_type (optional) Post type.
     * @return  bool    True if ACF is ready to be used, false if not.
     */
    public static function acf_compatible( $post_type=null )
    {
        // Check whether we can even add custom fields
        if ( !function_exists( 'register_field_group' ) )
            false;

        // Check whether the CPT exists, if provided
        if ( $post_type && !post_type_exists( $post_type ) )
            return false;

        return true;
    }

    /**
     * Add custom fields to the Place custom post type.
     *
     * @author  Joseph Furlott <jmfurlott@geometeor.com>
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @return  bool    True upon success, false upon failure.
     */
    public static function create_places_acf()
    {
        if ( !self::acf_compatible( 'place' ) )
            return false;

        // {{{ ACF settings, Place
        register_field_group( array (
                'id' => 'acf_place',
                'title' => 'Place',
                'fields' => array (
                    array (
                        'key' => 'field_5442c744bbe43',
                        'label' => 'Type',
                        'name' => 'type',
                        'type' => 'select',
                        'choices' => array (
                            'City Park' => 'City Park',
                            'State Park' => 'State Park',
                            'National Park' => 'National Park',
                            'Collecting Site' => 'Collecting Site',
                            'Museum' => 'Museum',
                            'Other' => 'Other',
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_5442dd627866c',
                        'label' => 'Country',
                        'name' => 'country',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c8e0e55fa',
                        'label' => 'State',
                        'name' => 'state',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c8e5e55fb',
                        'label' => 'County',
                        'name' => 'county',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c8f2e55fc',
                        'label' => 'City',
                        'name' => 'city',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c8f9e55fd',
                        'label' => 'Zip',
                        'name' => 'zip',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c902e55fe',
                        'label' => 'Address',
                        'name' => 'address',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c90ce55ff',
                        'label' => 'Latitude',
                        'name' => 'latitude',
                        'type' => 'text',
                        'default_value' => '-000001',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c929e5600',
                        'label' => 'Longitude',
                        'name' => 'longitude',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c931e5601',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5442c93fe5602',
                        'label' => 'Map URL',
                        'name' => 'map_url',
                        'type' => 'text',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'html',
                        'maxlength' => '',
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'place',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'no_box',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ) );
        // }}}

        return true;
    }

    /**
     * Add custom fields to the Event custom post type.
     *
     * @author  Joseph Furlott <jmfurlott@geometeor.com>
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @return  bool    True upon success, false upon failure.
     */
    public static function create_events_acf()
    {
        if ( !self::acf_compatible( 'event' ) )
            return false;

        // {{{ ACF settings, Event
        register_field_group( array (
                'id' => 'acf_event',
                'title' => 'Event',
                'fields' => array (
                    array (
                        'key' => 'field_5442c96ff0df4',
                        'label' => 'Type',
                        'name' => 'type',
                        'type' => 'select',
                        'choices' => array (
                            'Meeting' => 'Meeting',
                            'Workshop' => 'Workshop',
                            'Lecture' => 'Lecture',
                            'Other' => 'Other',
                        ),
                        'default_value' => '',
                        'allow_null' => 0,
                        'multiple' => 0,
                    ),
                    array (
                        'key' => 'field_5442c986f0df5',
                        'label' => 'Place',
                        'name' => 'place',
                        'type' => 'relationship',
                        'return_format' => 'object',
                        'post_type' => array (
                            0 => 'place',
                        ),
                        'taxonomy' => array (
                            0 => 'all',
                        ),
                        'filters' => array (
                            0 => 'search',
                        ),
                        'result_elements' => array (
                            0 => 'post_type',
                            1 => 'post_title',
                        ),
                        'max' => '',
                    ),
                    array (
                        'key' => 'field_5442c9acf0df6',
                        'label' => 'Starts At',
                        'name' => 'starts_at',
                        'type' => 'date_picker',
                        'date_format' => 'mmddyy',
                        'display_format' => 'mm/dd/yy',
                        'first_day' => 1,
                    ),
                    array (
                        'key' => 'field_5442c9bdf0df7',
                        'label' => 'Ends At',
                        'name' => 'ends_at',
                        'type' => 'date_picker',
                        'date_format' => 'mmddyy',
                        'display_format' => 'mm/dd/yy',
                        'first_day' => 1,
                    ),
                ),
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'event',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'no_box',
                    'hide_on_screen' => array (
                    ),
                ),
                'menu_order' => 0,
            ) );
        // }}}

        return true;
    }

    /**
     * Load in data from CSV into Places.
     *
     * @author  Joseph Furlott <jmfurlott@geometeor.com>
     * @author  Brandon Wood <btwood@geometeor.com>
     * @since   0.0.1
     * @static
     * @param   string  $filename   Path to CSV file that has Places information.
     * @param   array   $field_map  Array that lists the field names in order that they appear in the CSV.
     * @return  bool    True upon success, false upon failure.
     */
    public static function load_data_places( $filename=null, $field_map=null )
    {
        // Exit if we can't do this yet.
        if ( !self::acf_compatible( 'place' ) )
            return false;

        // Set default filename
        if ( !$filename )
            $filename = plugin_dir_path( dirname( __FILE__ ) ) .
                'includes/data/places.csv';

        // Exit if the file doesn't exist.
        if ( !file_exists( $filename ) )
            return false;

        // Define the default field_map for the CSV, order *is* important.
        if ( !$field_map )
            $field_map = array( 'state', 'title', 'type', 'city', 'latitude',
                    'longitude', 'url', 'description' );

        // List of ACF's for Places, order is not important.
        $acf_fields = array( 'state', 'type', 'city', 'latitude', 'longitude',
                'url' );

        // Load the entire CSV 
        $csv = array_map( 'str_getcsv', file( $filename ) );

        // Load data as posts
        foreach ( $csv as $raw_data ) {
            // Parse data from CSV reader
            $data = array();
            foreach ( $field_map as $idx => $field_name )
                $data[ $field_name ] = $raw_data[ $idx ];

            // Fix edge case for City
            $data[ 'city' ] = substr( $data['city'], 0, ( strlen( $data['city'] ) - 4 ) );

            $post_args = array(
                    'post_title'    => $data[ 'title' ],
                    'post_content'  => $data[ 'description' ],
                    'post_status'   => 'publish',
                    'post_type'     => 'place',
                );

            // Insert the post into the database
            $post_id = wp_insert_post( $post_args );

            // Check that it actually went in
            if ( !$post_id )
                return false;
    
            // Load in ACF data for the Place
            foreach ( $acf_fields as $field_name )
                update_field( $field_name, $data[ $field_name ], $post_id );
        }

        return true;
    }

}
