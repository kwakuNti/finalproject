<?php
include '../config/core.php';
include '../includes/destinationfunctions.php';
checkLogin();
if ($_SESSION['role_id'] !== '2') {
    // Redirect the user to the dashboard.php
    header("Location: ../templates/admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Flight</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="../public/css/flight.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</head>
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('msg');
            if (message) {
                swal("Notice", message, "info");
            }
        });
    </script>

<body>
    <nav>
        <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
            <li class="link"><a href="../templates/myflights.php">Your Schedule</a></li>
            <!-- <li class="link"><a href="../templates/profile.php">Profile</a></li> -->
            <li class="link"><a href="../templates/settings.php">Settings</a>
                <ul class="sub-menu">
                    <li><a href="../templates/profile.php">Profile</a></li>
                </ul>
            </li>

            <li class="link"><a href="../templates/destination.php">Destinations</a></li>
        </ul>
        <button class="btn" id="goBackBtn">Go back</button>
    </nav>
    <div class="container">
        <h3 class="getquotetext">Get Quote</h3>

        <div class="blocks">
            <div class="left">
            <div class="triptype">
    <button type="button" id="oneWayButton" class="one-way-button " onclick="redirectToOneWay()">One-Way</button>
    <button type="button" id="roundTripButton" class="one-way-button active" >Round-Trip</button>
</div>
<script>
    function redirectToOneWay() {
        window.location.href = "../templates/flight.php";
    }
</script>
                

                <form id="roundTrip"   method="post" action="../actions/round_trip.php" >
                    <div class="destination">
                        <p>Destination</p>
                        <div class="select">
                        <?php
                            echo generateDestinationOptions($conn, 'toDestination', 'Select To Destination');
                            ?>

                        </div>
                    </div>
                    <div class="date-input-container">
                        <p>Departure Date</p>
                        <i class="fas fa-calendar-alt date-icon"></i>
                        <input type="date" class="date-input-field" type="text" id="departureDate" name="departureDate" placeholder="mm/dd/yyyy">
                    </div>
                    <div class="date-input-container">
                        <p>Arrival Date</p>
                        <i class="fas fa-calendar-alt date-icon"></i>
                        <input type="date" class="date-input-field" type="text" id="arrivalDate" name="arrivalDate" placeholder="mm/dd/yyyy">
                    </div>
                    <div class="select">
                        <p>Passengers</p>
                        <div class="selectBtn" data-type="roundTripPassengerCount"><i class="fas fa-user"></i>Passengers</div>
                        <div class="selectDropdown">
                            <div class="option" data-type="1"><i class="fas fa-user"></i>1</div>
                            <div class="option" data-type="2"><i class="fas fa-user"></i>2</div>
                            <div class="option" data-type="3"><i class="fas fa-user"></i>3</div>
                        </div>
                        <input type="hidden" name="passengers" id="passengers" value="1"> <!-- Hidden input for passengers -->

                    </div>

                    <div class="select">
                        <p>Class</p>
                        <div class="selectBtn" data-type="classSelection"><i class="fas fa-user"></i>Choose Class</div>
                        <div class="selectDropdown">
                            <div class="option" data-type="business">Business Class</div>
                            <div class="option" data-type="economy">Economy</div>
                            <div class="option" data-type="first">First Class</div>
                        </div>
                        <input type="hidden" name="classSelection" id="classSelection" value="Business"> <!-- Hidden input for class selection -->

                    </div>





                </form>
            </div>

            <div class="right">
                <div class="trip-detail-container">
                    <!-- Trip details container -->
                   
                    <div id="roundTripDetails" >
                        <h3 class="trip-detail-title">Round-Trip</h3>
                        <table>
                            <tr>
                                <td>Destination</td>
                                <td><span id="quoteTo"></span></td>
                            </tr>


                            <tr>
                                <td>Departure</td>
                                <td><span id="quoteDeparture"></span></td>
                            </tr>
                            <tr>
                                <td>Arrival</td>
                                <td><span id="quoteArrival"></span></td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <div class="price-container">
                        <h3 class="trip-detail-title">Price</h3>
                        <table>
                            <tr>
                                <td>Base Price</td>
                                <td><span id="basePrice"></span></td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td><span id="tax"></span></td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td><span id="totalPrice"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">

            <button type="submit" class="get-quotes-btn">Get Quote</button>
            <button type="submit" form="roundTrip" class="book-flights-btn">Book Tickets</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../public/js/flightx.js"></script>

    <script>
  // Get the button element
  const goBackBtn = document.getElementById('goBackBtn');

  // Add click event listener
  goBackBtn.addEventListener('click', function() {
    // Redirect to the dashboard page
    window.location.href = '../templates/dashboard.php';
  });
</script>
   
</body>

</html>