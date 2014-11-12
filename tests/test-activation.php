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
        $this->assertNotFalse( myFOSSIL_Resources_Admin::create_places() );
        $this->assertNotFalse( post_type_exists( 'place' ) );
    }

    /**
     * Test that Event custom post type (CPT) created with ACF.
     */
    public function testCptEventWithAcf() {
        $this->assertNotFalse( myFOSSIL_Resources_Admin::create_events() );
        $this->assertNotFalse( post_type_exists( 'event' ) );
    }
}
