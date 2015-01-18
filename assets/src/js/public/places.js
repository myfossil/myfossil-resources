( function( $ ) {
    'use strict';

    // {{{ get_places 
    function get_places() {
        var nonce = $( '#myfossil_resources_filter_nonce' ).val(); 
        var json = null;

        $.ajax({
            async: false,
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfossil_resources_list_places',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( data ) {
                json = data;
            },
            error: function ( err ) {
                console.error( err );
            }
        });

        return json;
    }
    // }}}

    // {{{ init_places
    function init_places() {
        var tpl_src = $( '#tpl-places' ).html();
        var tpl = Handlebars.compile( tpl_src );
        $( '#places-list' ).html( tpl( get_places() ) );
    }
    // }}}

    // {{{ init_places_filters_state
    function init_places_filters_state() {
        var tpl;
        var nonce = $( '#myfossil_resources_filter_nonce' ).val(); 

        // toggle loading
        $( '#state-filter' ).prop( 'disabled', true );
        $( '#state-filter' ).append( '<option id="loading-states">Loading...</option>' ); 

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfossil_resources_list_states',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( states ) {
                $( '#state-filter' ).append( '<option>United States</option>' );

                states.forEach( function( state ) {
                    tpl = '<option value="' + state + '">' + state + '</option>';
                    $( '#state-filter' ).append( tpl );
                });

                $( '#state-filter' ).prop( 'disabled', false );
                $( '#loading-states' ).remove();
            },
            error: function( err ) {
                console.log( err );
                $( '#loading-states' ).text( 'Error' );
            },
	    failure: function(err) {
		console.log('failure');
	    }
        });

        return 1;
    }
    // }}}

    // {{{ init_places_filters_type
    function init_places_filters_type() {
        var tpl;
        var nonce = $( '#myfossil_resources_filter_nonce' ).val(); 

        // toggle loading
        $( '#types-selected' ).append( 
                '<div id="loading-types"><i class="fa fa-fw fa-spinner fa-spin"></i> Loading...</div>' );

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfossil_resources_list_types',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( types ) {
                types.forEach( function( type ) {
                    tpl = '<div class="checkbox"><label>';
                    tpl += '<input type="checkbox" value="' + type + '" checked="checked">';
                    tpl += type + '</label></div>';
                    $( '#types-selected' ).append( tpl );
                });

                $( '#loading-types' ).remove();
            },
            error: function( err ) {
                console.log( err );
                $( '#loading-types' ).html( '<i class="fa fa-fw fa-warning"></i> Error' );
            }
        });

        return 1;
    }
    // }}}

    // {{{ filter_places
    function filter_places() {
        var tpl,
            tpl_state = '[data-place-state="%state%"]',
            tpl_types = '[data-place-type="%type%"]',
            state = $( '#state-filter' ).val();

        // Reset, hide all.
        $( 'div.place' ).hide();

        // Filter by type and state where ( type && state ).
        $( 'input:checkbox:checked' )
            .map( function() { return this.value; } )
            .get()
            .forEach(
                function( type ) { 
                    tpl = 'div';
                    if ( state !== 'United States' )
                        tpl += tpl_state.replace( /%state%/, state );
                    tpl += tpl_types.replace( /%type%/, type );
                    $( tpl ).show();
                }
            );
    }
    // }}}
    
    // {{{ init_places_map
    function init_places_map() {
        var places = get_places().places;

        var icon_url = "http://maps.google.com/mapfiles/ms/icons/";
        var ch = {
                "City Park"       : icon_url + "red-dot.png",
                "State Park"      : icon_url + "blue-dot.png",
                "National Park"   : icon_url + "green-dot.png",
                "Collecting Site" : icon_url + "orange-dot.png",
                "Museum"          : icon_url + "purple-dot.png",
                "Other"           : icon_url + "yellow-dot.png",
            };

        var mapOptions = {
                center: { 
                    lat: 39.50, 
                    lng: -98.35
                },
                zoom: 4
            };

        var map = new google.maps.Map( document.getElementById("map-canvas"), mapOptions );
	
	var prevInfoWindow;
        // Add a marker for each place on the map.
        places.forEach(
            function( place ) {
                // Create an info pop-up window for the marker.
                var info = new google.maps.InfoWindow(
                        { content: place.content }
                    );

                // Produce the marker on the map.
                var marker = new google.maps.Marker(
                        {
                            position: {
                                lat: parseFloat( place.latitude ),
                                lng: parseFloat( place.longitude )
                            },
                            map: map,
                            title: place.title,
                            icon: ch[ place.type ],
                        }
                    );

                // Show additional information when clicked.
                ( function( marker, place ) {
                    google.maps.event.addListener( marker, 'click', 
                            function() {
				if(prevInfoWindow) 
				    prevInfoWindow.close();
                                info.setContent( 
                                    '<h3>' + place.title + '</h3>' +
                                    '<p>' + place.content + '</p>' 
                                ),
                                info.open( map, marker );
				prevInfoWindow = info;
                            }
                        );
                } )( marker, place );
            }
        );
    }
    // }}}

    // {{{ create_place_submit
    function create_place_submit() {
        var nonce = $( '#myfossil_resources_filter_nonce' ).val(); 

        $('#new-place-form').submit( function( event ) {
            // Prevent default browser submit behavior on Enter keydown
            event.preventDefault();
            event.stopPropagation();

            // Pull Place data from modal
            var data = {};
            var data_keys = [ 'name', 'description', 'type', 'country',
                    'state', 'county', 'city', 'zip', 'address', 'latitude',
                    'longitude', 'url', 'map_url' ];
            $.map( data_keys, function( key ) {
                data[key] = $( 'input#' + key ).val();
                if ( key === 'type' ) data[key] = $( 'select#type' ).val();
            });

            // Perform the ajax call 
            $.ajax({
                type: 'post',
                url: ajaxurl,
                data: { 
                    'action': 'myfossil_resources_create_place',
                    'nonce': nonce,
                    'data': data
                },
                dataType: 'json',
                success: function( response ) {
                    // Added successfully, hide modal
                    $( '#placesModal' ).modal( 'hide' );
                    location.reload();
                },
                error: function( err ) {
                    console.info( data );
                    console.error( err );
                }
            });
        });
    }
    // }}}

    // {{{ clear_place_filters
    function clear_place_filters() {
        $('#clear-filters').click(function() {
            // Reset state dropdown
            $('#state-filter').val($('#state-filter option:first').val());

            // Reset type checkboxes
            var checkboxes = $('#types-selected').find('input');
            checkboxes.each(function() {
                $(this).prop('checked', true);
            });

            // Trigger update of Places
            filter_places();
        });
    }
    // }}}

    $( function() {
        if ( !! $( '#places-list' ).length ) {
            // Initialize Places
            init_places();
            
            // Setup filters and listeners
            init_places_filters_state();

            init_places_filters_type();  // the extra function call for issue #8

            $( '#state-filter' ).change( filter_places );
            $( '#types-selected' ).on( 'click', 'input[type=checkbox]', filter_places );

            // Load Google Map with markers
            google.maps.event.addDomListener( window, 'load', init_places_map );

            // Initialize Place creation form behavior
            create_place_submit();

            // Initialize Place filters
            clear_place_filters();
        }
    } );

}( jQuery ) );
