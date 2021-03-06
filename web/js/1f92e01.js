
    function GoogleMaps() {

        this.infoWindow = null;

        var box = document.getElementById("map");
        var mapLocation = new google.maps.LatLng(46.604167162931844,32.897186279296875);

        this.map = new google.maps.Map(box, {
            streetViewControl : false,
            overviewMapControl: false,
            mapTypeControl: false,
            panControl : false,
            scrollwheel: false,
            center: mapLocation,
            zoom: 10
        });
    }

    GoogleMaps.prototype.setMarkers = function(markersOption) {
        if(Object.keys(markersOption.items).length) {
            this.addMarkers(markersOption.items);
        }
    };

    GoogleMaps.prototype.addMarkers = function(items) {
        var gMaps = this;
        $.each(items,function(key,value){
            var position = new google.maps.LatLng(value.lat,value.lng);
            var markerOptions = {};
            markerOptions.position = position;
            if(value.icon) {
                var icon = value.icon.replace('\\','');
                markerOptions.icon = icon;
            }
            var marker=new google.maps.Marker(markerOptions);
            marker.setMap(gMaps.map);
            gMaps.map.setCenter(position);

            contentString = document.getElementById("infobox");
            var infowindow = new InfoBox({
                content: contentString,
                disableAutoPan: false,
                maxWidth: 150,
                pixelOffset: new google.maps.Size(-140, 0),
                zIndex: null,
                boxStyle: {
                    background: "url('../assets/img/icon-arrow-map.png') 92px top  no-repeat",
                    width: "325px",
                    left: "70px"
                },
                closeBoxMargin: "12px 4px 2px 2px",
                closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                infoBoxClearance: new google.maps.Size(1, 1)
            });

            marker.addListener('click', function() {
                infowindow.open(gMaps.map, marker);
                gMaps.map.setCenter(marker.getPosition());
                gMaps.map.setZoom(15);
                gMaps.infoWindow = infowindow;
            });

            google.maps.event.addListener(infowindow, 'closeclick',
                function(){
                    gMaps.map.setZoom(10);
                    gMaps.infoWindow = null;
                }
            );

            gMaps.map.addListener('click', function() {
                gMaps.map.setZoom(10);
                if(gMaps.infoWindow != null) {
                    gMaps.infoWindow.close();
                    gMaps.infoWindow = null;
                }
            });

        })
    };


