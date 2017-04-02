var Maps = function(settings){
    this.container = settings.container;
    this.path = settings.path;
    this.markers = settings.markers;
    this.map = {};
    this.mapOptions = settings.mapOptions;
};

Maps.prototype.Init = function()
{
    var s = this
    var mapLocation = new google.maps.LatLng(s.mapOptions.center[0],s.mapOptions.center[1]);
    var box = document.getElementById(s.container);
    this.map = new google.maps.Map(box, {
        streetViewControl : false,
        overviewMapControl: false,
        mapTypeControl: false,
        zoomControl : false,
        panControl : false,
        scrollwheel: false,
        center: mapLocation,
        zoom: 5
    });
    $('#contactsCountrySelect').unbind('change');
    $('#contactsCountrySelect').change(function(){
        s.showOffices($(this));
    });
};

Maps.prototype.getLatLng = function(LatLngArray)
{
    return new google.maps.LatLng(LatLngArray[0], LatLngArray[1]);
};


Maps.prototype.addMarkers = function()
{
    var s = this;
    for(key in this.markers)
    {
        var marker = new google.maps.Marker({
            position: s.getLatLng(s.markers[key].LatLng),
            icon: s.markers[key].icon,
            map: s.map
        });
        var infobox = new InfoBox({
            content: s.markers[key].description,
            disableAutoPan: false,
            maxWidth: 150,
            pixelOffset: new google.maps.Size(-140, 0),
            zIndex: null,
            boxStyle: {
                background: "url('/bundles/netcasturestmain/img/icon-arrow-map.png') 92px top  no-repeat",
                width: "325px",
                left: "70px"
            },
            closeBoxMargin: "12px 4px 2px 2px",
            closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
            infoBoxClearance: new google.maps.Size(1, 1)
        });

        google.maps.event.addListener(marker, 'click', function() {
            infobox.open(s.map, this);
            s.map.panTo(s.getLatLng(s.markers[key].LatLng));
        });
    }
}


Maps.prototype.showOffices = function(el){
    var country = el.val();
    var s = this;
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: s.path.replace('__id__', country),
        cache: false,
        contentType: false,
        processData: false,
        error: function() {
            console.log('Ошибка при загрузке отделений');
        },
        success: function(data) {
            if(data.status == 'success')
            {
                s.mapOptions.center = data.countryLatLng.split(',');
                s.markers = data.offices;
                $('#officesInfoWrap').html(data.officesHtml);
                s.Init();
                s.addMarkers();
            }
        }
    });
};

