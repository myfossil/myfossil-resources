( function( $ ) {
    'use strict';

    // {{{ get_places 
    function get_places() {
        var nonce = $( '#myfr_filter_nonce' ).val(); 
        var json = null;

        $.ajax({
            async: false,
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_places',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( data ) {
                json = data;
            },
            error: function ( err ) {
                console.log( err );
            }
        });

        return json;
    }
    // }}}

    // {{{ get_events
    function get_events() {
        var nonce = $( '#myfr_filter_nonce' ).val(); 
        var json = null;

        $.ajax({
            async: false,
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_events',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( data ) {
                json = data;
            },
            error: function ( err ) {
                console.log( err );
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

    // {{{ init_events
    function init_events() {
        var tpl_src = $( '#tpl-events' ).html();
        var nonce = $( '#myfr_filter_nonce' ).val(); 
        var tpl = Handlebars.compile( tpl_src );

        // Populate Events list
        $( '#events-list' ).html( tpl( get_events() ) );

        // {{{ Start date picker
        $( '#start-date-picker' ).datepicker({
            onSelect: function() {
                var json;

                $.ajax({ 
                    type: 'post',
                    url: ajaxurl,
                    data: { 
                            'action': 'myfr_filter_start_date',
                            'nonce': nonce,
                            'start_date': $('#start-date-picker').val(),
                            'end_date': $('#end-date-picker').val()
                        },
                    dataType: 'json',
                    success: function(response) {
                            console.log(response);
                            $('#events-list').html(tpl(response));
                        },
                    failure: function(response) {
                            console.log('failure');
                            console.log(response);
                        },
                    error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                });
            }
        });
        // }}}

        // {{{ End date picker
        $( '#end-date-picker' ).datepicker({
            onSelect: function() {
                var json;

                $.ajax({ 
                    type: 'post',
                    url: ajaxurl,
                    data: { 
                        'action': 'myfr_filter_end_date',
                        'nonce': nonce,
                        'start_date': $('#start-date-picker').val(),
                        'end_date': $('#end-date-picker').val()
                    },
                    dataType: 'json',
                    success: function(response) {
                            console.log(response);
                            $('#events-list').html(tpl(response));
                        },
                    failure: function(response) {
                            console.log('failure');
                            console.log(response);
                        },
                    error: function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                            console.log(textStatus);
                            console.log(errorThrown);
                        }
                });
            }
        });
        // }}}

    }
    // }}}

    // {{{ init_places_filters_state
    function init_places_filters_state() {
        var tpl;
        var nonce = $( '#myfr_filter_nonce' ).val(); 

        // toggle loading
        $( '#state' ).prop( 'disabled', true );
        $( '#state' ).append( '<option id="loading-states">Loading...</option>' ); 

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_states',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( states ) {
                $( '#state' ).append( '<option>United States</option>' );
                states.forEach( function( state ) {
                    tpl = '<option value="' + state + '">' + state + '</option>';
                    $( '#state' ).append( tpl );
                });
                $( '#state' ).prop( 'disabled', false );
                $( '#loading-states' ).remove();
            },
            error: function( err ) {
                console.log( err );
                $( '#loading-states' ).text( 'Error' );
            }
        });

        return 1;
    }
    // }}}

    // {{{ init_places_filters_type
    function init_places_filters_type() {
        var tpl;
        var nonce = $( '#myfr_filter_nonce' ).val(); 

        // toggle loading
        $( '#types-selected' ).append( 
                '<div id="loading-types"><i class="fa fa-fw fa-spinner fa-spin"></i> Loading...</div>' );

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_types',
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
                $( '#loading-types' ).text( '<i class="fa fa-fw fa-warning"></i> Error' );
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
            state = $( '#state' ).val();

        // Reset, hide all.
        $( 'div.panel' ).hide();

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

    // {{{ init_events_filters_state
    function init_events_filters_state() {
        var tpl;
        var nonce = $( '#myfr_filter_nonce' ).val(); 

        // toggle loading
        $( '#state' ).prop( 'disabled', true );
        $( '#state' ).append( '<option id="loading-states">Loading...</option>' ); 

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_events_states',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( states ) {
                $( '#state' ).append( '<option>United States</option>' );
                states.forEach( function( state ) {
                    tpl = '<option value="' + state + '">' + state + '</option>';
                    $( '#state' ).append( tpl );
                });
                $( '#state' ).prop( 'disabled', false );
                $( '#loading-states' ).remove();
            },
            error: function( err ) {
                console.log( err );
                $( '#loading-states' ).text( 'Error' );
            }
        });

        return 1;
    }
    // }}}

    // {{{ init_events_filters_month_year
    function init_events_filters_month_year() {
        var tpl;
        var nonce = $( '#myfr_filter_nonce' ).val(); 

        // toggle loading
        $( '#month-year' ).prop( 'disabled', true );
        $( '#month-year' ).append( '<option id="loading-dates">Loading...</option>' ); 

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_events_month_years',
                'nonce': nonce,
            },
            dataType: 'json',
            success: function( states ) {
                $( '#month-year' ).append( '<option>United States</option>' );
                states.forEach( function( state ) {
                    tpl = '<option value="' + state + '">' + state + '</option>';
                    $( '#month-year' ).append( tpl );
                });
                $( '#month-year' ).prop( 'disabled', false );
                $( '#loading-dates' ).remove();
            },
            error: function( err ) {
                console.log( err );
                $( '#loading-dates' ).text( 'Error' );
            }
        });

        return 1;
    }
    // }}}

    // {{{ init_events_filters_type
    function init_events_filters_type() {
        var tpl;
        var nonce = $( '#myfr_filter_nonce' ).val(); 

        // toggle loading
        $( '#types-selected' ).append( 
                '<div id="loading-types"><i class="fa fa-fw fa-spinner fa-spin"></i> Loading...</div>' );

        $.ajax({
            type: 'post',
            url: ajaxurl,
            data: { 
                'action': 'myfr_list_events_types',
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
                $( '#loading-types' ).text( '<i class="fa fa-fw fa-warning"></i> Error' );
            }
        });

        return 1;
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

    // {{{ init_events_map
    function init_events_map() {
        var events = get_events().events;

        var icon_url = "http://maps.google.com/mapfiles/ms/icons/";
        var ch = {
                "Meeting"       : icon_url + "red-dot.png",
                "Workshop"      : icon_url + "blue-dot.png",
                "Lecture"       : icon_url + "green-dot.png",
                "Other"         : icon_url + "yellow-dot.png",
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
        events.forEach(
            function( event ) {
		console.log(event);
                // Create an info pop-up window for the marker.
                var info = new google.maps.InfoWindow(
                        { content: event.content }
                    );

                // Produce the marker on the map.
                var marker = new google.maps.Marker(
                        {
                            position: {
                                lat: parseFloat( event.place[0].latitude ),
                                lng: parseFloat( event.place[0].longitude )
                            },
                            map: map,
                            title: event.title,
                            icon: ch[ event.type ],
                        }
                    );

                // Show additional information when clicked.
                ( function( marker, event ) {
                    google.maps.event.addListener( marker, 'click', 
                            function() {
				if(prevInfoWindow) 
				    prevInfoWindow.close();
                                info.setContent( 
                                    '<h3>' + event.title + '</h3>' +
                                    '<p>' + event.content + '</p>' 
                                ),
                                info.open( map, marker );
				prevInfoWindow = info;
                            }
                        );
                } )( marker, event );
            }
        );
    }
    // }}}

    $( function() {

        if ( !! $( '#places-list' ).length ) {
            init_places();
            
            // Setup filters and listeners.
            init_places_filters_state();
            init_places_filters_type();
            $( '#state' ).change( filter_places );
            $( '#types-selected' ).on( 'click', 'input[type=checkbox]', filter_places );

            // Load up Google map with markers.
            google.maps.event.addDomListener( window, 'load', init_places_map );
        }

        if ( !! $( '#events-list' ).length ) {
            init_events();

            // Setup filters and listeners.
            init_events_filters_state();
            init_events_filters_type();
            //init_events_filters_month_year();

            // Load up Google map with markers.
            google.maps.event.addDomListener(window, 'load', init_events_map);
        }

    } );

}( jQuery ) );
