@if (config('app.app_google_maps_key'))
    <script>
        window.initMap = function() {
            let mapContainer = document.getElementById("map");
            if (mapContainer === null) return;
            let title = mapContainer.getAttribute("data-title");
            let latitude = mapContainer.getAttribute("data-latitude");
            let longitude = mapContainer.getAttribute("data-longitude");
            const latLng = {
                lat: parseFloat(latitude),
                lng: parseFloat(longitude),
            };
            const mapOptions = {
                zoom: 15,
                center: latLng,
            };
            const map = new google.maps.Map(mapContainer, mapOptions);
            new google.maps.Marker({
                position: latLng,
                map: map,
                title: title,
            });
        };
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.app_google_maps_key') }}&callback=initMap" async
        defer></script>
@endif
