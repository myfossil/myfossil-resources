<?php
namespace myFOSSIL\Plugin\Resources;

/**
 * PluginActivationComponentsTest class.
 *
 * @author      Brandon Wood <bwood@atmoapps.com>
 * @package     myFOSSIL
 * @subpackage  myFOSSIL/tests
 */
class PluginActivationComponentsTest extends Tests\myFOSSIL_Resources_Test 
{
    /**
     * Test that Place custom post type (CPT) created with ACF.
     */
    public function testCptPlaceWithAcf() {
        $this->assertNotFalse( myFOSSIL_Resources_Activator::create_places() );
        $this->assertNotFalse( myFOSSIL_Resources_Activator::create_places_acf() );
        $this->assertNotFalse( myFOSSIL_Resources_Activator::acf_compatible( 'place' ) );
        $this->assertNotFalse( post_type_exists( 'place' ) );
    }

    /**
     * Test that Event custom post type (CPT) created with ACF.
     */
    public function testCptEventWithAcf() {
        $this->assertNotFalse( myFOSSIL_Resources_Activator::create_events() );
        $this->assertNotFalse( myFOSSIL_Resources_Activator::create_events_acf() );
        $this->assertNotFalse( myFOSSIL_Resources_Activator::acf_compatible( 'event' ) );
        $this->assertNotFalse( post_type_exists( 'event' ) );
    }

    /**
     * Test that the data loader is working.
     *
     * @depends testCptPlaceWithAcf
     */
    public function testLoadPlacesFromCsv() {
        $this->assertNotFalse( myFOSSIL_Resources_Activator::acf_compatible( 'place' ) );
        $this->assertNotFalse( myFOSSIL_Resources_Activator::load_data_places() );

        // Test that we actually have something...
        $data = array(
                'state' => "California",
                'type' => "Museum",
                'city' => "Los Angeles",
                'latitude' => 34.052234,
                'longitude' => -118.243685,
                'url' => "www.nhm.org",
            );

        $title = "Natural History Museum of Los Angeles County";
        $post_object = get_page_by_title( $title, OBJECT, 'place' );

        foreach ( get_fields( $post_object->ID ) as $field_name => $value )
            $this->assertEquals( $value, $data[ $field_name ] );
    }
}
