<!DOCTYPE html>
<html>

<head>
    <title>Distance</title>
    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
</head>

<body>
    <div id="result"></div>
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKN6GviC9AcmwO3983l6zQEAiiLV71DWA
"></script>
    <script>
        const resultDiv = document.getElementById('result');
        const mapDiv = document.getElementById('map');
        let map, directionsService, directionsRenderer;

        function initMap() {
            map = new google.maps.Map(mapDiv, {
                zoom: 7,
                center: {
                    lat: 0,
                    lng: 0
                },
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: '#4285F4', // Set the color of the polyline to a darker blue
                    strokeWeight: 7, // Increase the thickness of the polyline
                },
            });

            // Get origin and destination from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const origin = urlParams.get('origin');
            const destination = urlParams.get('destination');

            // Calculate distance and display route
            calculateAirDistance(origin, destination);
        }

        function calculateAirDistance(origin, destination) {
            const service = new google.maps.DistanceMatrixService();

            service.getDistanceMatrix({
                origins: [origin],
                destinations: [destination],
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                avoidHighways: false,
                avoidTolls: false,
            }, (response, status) => {
                console.log(response); // Log the response to the console

                if (status === google.maps.DistanceMatrixStatus.OK) {
                    const distance = response.rows[0].elements[0].distance.text;
                    resultDiv.innerHTML = `Distance by plane: ${distance}`;
                    displayPlaneRoute(origin, destination);
                } else if (status === google.maps.DistanceMatrixStatus.ZERO_RESULTS) {
                    resultDiv.innerHTML = 'No distance information available.';
                } else {
                    resultDiv.innerHTML = 'Error calculating distance by plane.';
                    console.error('Distance Matrix request failed due to:', status);
                }
            });
        }

        function displayPlaneRoute(origin, destination) {
            const directionsService = new google.maps.DirectionsService();
            directionsService.route({
                origin: origin,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING,
                provideRouteAlternatives: true,
            }, (response, status) => {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsRenderer.setDirections(response);
                    const planeIcon = {
                        path: "M22.5 7.5l-20 5 7.5 5 2.5 10 5-15 5 15 2.5-10 7.5-5-20-5z",
                        fillColor: "#FFFFFF", // White fill
                        fillOpacity: 1,
                        scale: 2.5, // Scale up the icon size (adjust as needed)
                        strokeColor: "black", // Optional black outline
                        strokeWeight: 0.5, // Optional outline thickness
                    };



                    const planeMarker = new google.maps.Marker({
                        position: response.routes[0].overview_path[Math.floor(response.routes[0].overview_path.length / 2)],
                        icon: planeIcon,
                        map: map,
                    });
                } else {
                    console.error('Directions request failed due to:', status);
                }
            });
        }

        initMap();
    </script>
</body>

</html>