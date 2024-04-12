<!DOCTYPE html>
<html>
<head>
    <title>Distance Calculation</title>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <form id="distance-form">
        <label for="origin">Origin:</label>
        <input type="text" id="origin" name="origin" required>
        <br>
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required>
        <br>
        <button type="submit">Calculate Distance</button>
    </form>
    <div id="result"></div>
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=apikey"></script>
    <script>
        const form = document.getElementById('distance-form');
        const resultDiv = document.getElementById('result');
        const mapDiv = document.getElementById('map');
        let map, directionsService, directionsRenderer;

        function initMap() {
            map = new google.maps.Map(mapDiv, {
                zoom: 7,
                center: { lat: 0, lng: 0 },
            });

            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer({
                map: map,
                suppressMarkers: true,
                polylineOptions: {
                    strokeColor: '#4285F4', // Set the color of the polyline to a darker blue
                    strokeWeight: 10, // Increase the thickness of the polyline
                },
            });
        }

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;

            // Calculate distance by plane
            calculateAirDistance(origin, destination);
        });

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
  path: 'M256,0C156.698,0,76.802,79.891,76.802,179.197c0,71.83,36.458,133.055,91.026,164.095l72.425,119.701c2.737,4.521,7.839,7.305,13.422,7.305c5.585,0,10.688-2.784,13.425-7.305l72.426-119.701c54.568-31.04,91.026-92.265,91.026-164.095C435.198,79.891,355.302,0,256,0z M256,276.196c-53.091,0-96.198-43.107-96.198-96.198c0-53.091,43.107-96.197,96.198-96.197c53.091,0,96.197,43.106,96.197,96.197C352.197,233.089,309.091,276.196,256,276.196z',
  fillColor: '#FFFFFF', // White fill
  fillOpacity: 1,
  scale: 0.1, // Scale down the icon size (adjust as needed)
  strokeColor: 'black', // Optional black outline
  strokeWeight: 1, // Optional outline thickness
  anchor: new google.maps.Point(256, 256), // Center the icon
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
