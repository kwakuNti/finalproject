<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
include '../includes/destinationfunctions.php';
include '../includes/adminfunctions.php';
checkLogin();
if ($_SESSION['role_id'] !== '1') {
    // Redirect the user to the dashboard.php
    header("Location: ../templates/dashboard.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" integrity="sha512-wnea99uKIC3TJF7v4eKk4Y+lMz2Mklv18+r4na2Gn1abDRPPOeef95xTzdwGD9e6zXJBteMIhZ1+68QC5byJZw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public/css/admin.css">
    <script src="../public/js/admin.js"></script>

    
</head>
<body class="bg-gray-200 flex justify-center items-center h-screen w-screen">
    <div class="container overflow-hidden rounded-2xl">
        <div class="flex flex-row bg-white items-center">
            <div class="app-bg-blue-1 px-10 py-5">
                <span class="text-lg text-white font-bold">Admin</span>
            </div>
            <div class="flex flex-row pl-5 items-center">
                <div class="h-9 w-9 bg-yellow-400 border-solid border-4 border-blue-600 rounded-xl"></div>
                <div class="flex flex-col pl-5">
                    <span class="font-semibold text-sm app-color-black"><?php echo getUserFullName($_SESSION['user_id']); ?></span>
                    <span class="font-semibold text-xs app-color-gray-1"><?php echo  getUserEmail($_SESSION['user_id']); ?></span>
                </div>
                <svg class="w-4 h-4 app-color-blue-3 ml-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                <div class="w-px bg-gray-100 h-10 ml-5"></div>
            </div>
            <div class="flex flex-row pl-5 items-center mr-auto">
                <div class="h-9 w-9 app-bg-blue-2 flex justify-center items-center rounded-xl">
                    <svg class="w-6 h-6 app-color-blue-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="flex flex-col pl-5">
                    <span class="font-semibold text-sm app-color-black">Today</span>
                    <span class="font-semibold text-sm app-color-blue-1">2 AUG 2018</span>
                </div>
                <svg class="h-4 w-4 app-color-blue-3 ml-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                <div class="w-px bg-gray-100 h-10 ml-5"></div>
                
            </div>
            <button id="addFlightButton"  class="app-color-blue-1 font-semibold text-md app-button-shadow w-40 py-2 rounded-3xl mr-5">Add Flight</button>

            <button id="logoutButton" class="app-color-blue-1 font-semibold text-md app-button-shadow w-40 py-2 rounded-3xl mr-5">Log Out</button>
            <svg class="w-6 h-6 app-color-blue-3 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>

      <script>
            document.addEventListener('DOMContentLoaded', function () {
    // Get the logout button element
    var logoutButton = document.getElementById('logoutButton');
    
    // Add click event listener to the logout button
    logoutButton.addEventListener('click', function () {
        // Redirect to logout.php
        window.location.href = 'logout.php';
    });
});



      </script>      

        </div>
        <div class="flex flex-col app-bg-white-1 px-12 pb-10">
            <div class="flex flex-row py-5">
                <span class="text-lg font-bold app-color-black">Home</span>
            </div>
            <div class="flex flex-row">
                <!-- Buttons for toggling sections -->
                <button id="flightsBtn" class="w-40 bg-white pl-5 py-3 mr-3 rounded-tl-2xl rounded-tr-2xl bg-white active">Flights</button>
                <button id="usersBtn" class="w-40 bg-white pl-5 py-3 mr-3 rounded-tl-2xl rounded-tr-2xl app-bg-blue-1">Users</button>
                <button id="destinationsBtn" class="w-40 bg-white pl-5 py-3 mr-3 rounded-tl-2xl rounded-tr-2xl app-bg-blue-3">Destinations</button>
            </div>
            <div id="flightsSection" class="bg-white p-10 relative">
    <!-- Flights section content -->
    <?php
    $flights = getAllFlights();
    if(mysqli_num_rows($flights) > 0) {
        echo '<table class="w-full">';
        echo '<thead>';
        echo '<tr>';
        echo '<th></th>';
        echo '<th></th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Flight Code</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Origin</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Destination</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Departure</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Arrival</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Duration</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Stops</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Economy Seats</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Business Seats</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">First Class Seats</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($row = mysqli_fetch_assoc($flights)) {
            echo '<tr>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['flight_code'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['origin'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['destination'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['departure_datetime'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['arrival_datetime'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['duration'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['stops'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['economy_seats'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['business_seats'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['first_seats'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No flights available.</p>';
    }
    ?>
</div>

            
            </div>
            <div id="usersSection" class="bg-white p-10 relative">
    <!-- Users section content -->
    <?php
    $users = getAllUsers();
    if(mysqli_num_rows($users) > 0) {
        echo '<table class="w-full">';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="text-left text-xs app-color-black pb-5">First Name</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Last Name</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Email</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Country</th>';
        echo '<th class="text-left text-xs app-color-black pb-5">Mobile Number</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        while($row = mysqli_fetch_assoc($users)) {
            echo '<tr>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['first_name'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['last_name'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['email'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['country'] . '</td>';
            echo '<td class="font-semibold text-sm app-color-black">' . $row['mobile_number'] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No users available.</p>';
    }
    ?>
</div>

            
       
            <div id="destinationsSection" class="bg-white p-10 relative">
                <!-- Destinations section content -->
                <div class="overflow-auto" style="max-height: 200px;">

                <table class="w-full">
        <thead>
            <tr>
                <th class="text-left text-xs app-color-black pb-5">Country/City</th>
                <th class="text-left text-xs app-color-black pb-5">Class</th>
                <th class="text-left text-xs app-color-black pb-5">Season</th>
                <th class="text-left text-xs app-color-black pb-5">Price</th>
            </tr>
        </thead>
        <tbody id="priceTable">
            <?php
            $destinations = getAllDestinations();
            while($row = mysqli_fetch_assoc($destinations)) {
                echo '<tr>';
                echo '<td class="font-semibold text-sm app-color-black">' . $row['name'] . '</td>';
                echo '<td>';
                echo '<select id="' . $row['name'] . '_class" onchange="updatePrice(\'' . $row['name'] . '\')">';
                echo '<option value="">Select Class</option>';
                echo '<option value="Economy">Economy</option>';
                echo '<option value="Business">Business</option>';
                echo '<option value="First">First</option>';
                echo '</select>';
                echo '</td>';
                echo '<td>';
                echo '<select id="' . $row['name'] . '_season" onchange="updatePrice(\'' . $row['name'] . '\')">';
                echo '<option value="">Select Season</option>';
                echo '<option value="Low">Low</option>';
                echo '<option value="High">High</option>';
                echo '</select>';
                echo '</td>';
                echo '<td id="' . $row['name'] . '_price"></td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
                </div>

    <script>
    function updatePrice(destination) {
        var classSelected = document.getElementById(destination + "_class").value;
        var season = document.getElementById(destination + "_season").value;
        
        if (classSelected && season) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText); // Log the response to the console
                    var response = JSON.parse(this.responseText);
                    if (response.price) {
                        document.getElementById(destination + "_price").innerHTML = response.price;
                    } else {
                        document.getElementById(destination + "_price").innerHTML = "Price not available";
                    }
                }
            };
            xhttp.open("GET", "../includes/get_price.php?destination=" + destination + "&class=" + classSelected + "&season=" + season, true);
            xhttp.send();
        }
    }
</script>



            </div>
            
            </div>
            </div>
    </div>
    <div class="modal" id="addFlightModal">
    <div class="bg-white p-6 rounded-lg">
        <h1 class="text-xl font-semibold mb-4">Add Flight</h1>
        <form id="addFlightForm" action="../actions/add_flight.php" method="POST">
            <div class="mb-4">
                <label for="flightCode" class="block text-sm font-medium text-gray-700">Flight Code</label>
                <input type="text" name="flightCode" id="flightCode" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            
            <div class="mb-4">
                <label for="originDestination" class="block text-sm font-medium text-gray-700">Origin Destination ID</label>
                <select name="originDestination" id="originDestination" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                    <option value="">Select Origin Destination</option>
                    <?php
                        populateDropdownOptions($conn);
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="destinationDestination" class="block text-sm font-medium text-gray-700">Destination Destination ID</label>
                <select name="destinationDestination" id="destinationDestination" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
                    <option value="">Select Destination Destination</option>
                    <?php
                        populateDropdownOptions($conn);
                    ?>
                </select>            </div>
                <div class="mb-4">
    <label for="departureDatetime" class="block text-sm font-medium text-gray-700">Departure Datetime</label>
    <input type="datetime-local" name="departureDatetime" id="departureDatetime" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
</div>

<div class="mb-4">
    <label for="arrivalDatetime" class="block text-sm font-medium text-gray-700">Arrival Datetime</label>
    <input type="datetime-local" name="arrivalDatetime" id="arrivalDatetime" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
</div>

            <div class="mb-4">
                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (in hours)</label>
                <input type="number" name="duration" id="duration" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            <div class="mb-4">
                <label for="stops" class="block text-sm font-medium text-gray-700">Stops</label>
                <input type="number" name="stops" id="stops" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            <div class="mb-4">
                <label for="economySeats" class="block text-sm font-medium text-gray-700">Economy Seats</label>
                <input type="number" name="economySeats" id="economySeats" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            <div class="mb-4">
                <label for="businessSeats" class="block text-sm font-medium text-gray-700">Business Seats</label>
                <input type="number" name="businessSeats" id="businessSeats" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>

            <div class="mb-4">
                <label for="firstSeats" class="block text-sm font-medium text-gray-700">First Seats</label>
                <input type="number" name="firstSeats" id="firstSeats" class="mt-1 p-2 border border-gray-300 rounded-md w-full" required>
            </div>
            <!-- Add other input fields for the remaining flight details -->
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Submit</button>
                <button type="button" id="cancelButton" class="ml-4 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400" >Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');
    if (message) {
    Swal.fire("Notice", message, "info");
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const message = urlParams.get('msg');
        if (message) {
            Swal.fire({
                title: 'Notice',
                text: message,
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }

        // Function to validate the flight form
        function validateFlightForm() {
            const flightCode = document.getElementById('flightCode').value;
            const duration = document.getElementById('duration').value;
            const stops = document.getElementById('stops').value;
            const economySeats = document.getElementById('economySeats').value;
            const businessSeats = document.getElementById('businessSeats').value;

            // Regular expression to check if flight code follows the format ABC123
            const flightCodePattern = /^[A-Z]{3}\d{3}$/;
            if (!flightCodePattern.test(flightCode)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Flight code should follow the format of three letters followed by three numbers (e.g., ABC123).',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            // Check if duration, stops, and seats are numbers
            if (isNaN(duration) || isNaN(stops) || isNaN(economySeats) || isNaN(businessSeats)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Duration, stops, and seats must be numbers.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            // Check if stops are not more than 5
            if (stops > 5) {
                Swal.fire({
                    title: 'Error',
                    text: 'Stops should not be more than 5.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            // Check if seats are not more than 20
            if (economySeats > 20 || businessSeats > 20 || firstSeats > 20) {
                Swal.fire({
                    title: 'Error',
                    text: 'Seats should not be more than 20.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            return true;
        }

        // Add event listener to the form submission
        document.getElementById('addFlightForm').addEventListener('submit', function (event) {
            if (!validateFlightForm()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    });
</script>


</body>
</html>