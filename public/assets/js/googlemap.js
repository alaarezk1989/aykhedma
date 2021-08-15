
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    function initAutocomplete(lat = "30.046275160232675", lng = "31.244865309119177") {
        var position = {lat: parseFloat(lat), lng: parseFloat(lng)};

        var map = new google.maps.Map(document.getElementById('map'), {
            center: position,
            zoom: 13,
            mapTypeId: 'roadmap'
        });

        var Oldmarker = new google.maps.Marker({
            draggable: true, // Boolean, to set the draggable action to true.
            position: position, // The default latitude and longitude object.
            map: map, // The Map Object that we created.
            title: "Drag to your Location"
        });

        google.maps.event.addListener(Oldmarker, 'click', function(event) {
            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("long").value = this.getPosition().lng();
            var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng());
            getLatLongDetail(latlng);
       

        });

        google.maps.event.addListener(Oldmarker, 'dragend', function(event) {
            document.getElementById("lat").value = this.getPosition().lat();
            document.getElementById("long").value = this.getPosition().lng();
            var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng());
            getLatLongDetail(latlng);
          
        });
        
      
        function getLatLongDetail(myLatlng) {

            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': myLatlng},
            function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        if (results[0].formatted_address != null) {
                            formattedAddress = results[0].formatted_address;
                            jQuery('#address').val(results[0].formatted_address);
                        }
                    }
                }
            });
        }


        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };
                // document.getElementById("lat").value = place.geometry.location.lat();
                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    draggable: true,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });

            markers.forEach(function (marker) {
                google.maps.event.addListener(marker, 'click', function(event) {
                    document.getElementById("lat").value = this.getPosition().lat();
                    document.getElementById("long").value = this.getPosition().lng();
                    
                    var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng());
                    getLatLongDetail(latlng);
                });

                google.maps.event.addListener(marker, 'dragend', function(event) {
                    document.getElementById("lat").value = this.getPosition().lat();
                    document.getElementById("long").value = this.getPosition().lng();
                    
                    var latlng = new google.maps.LatLng(this.getPosition().lat(), this.getPosition().lng());
                    getLatLongDetail(latlng);
                });
            });
            map.fitBounds(bounds);
        });
    }

