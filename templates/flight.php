<?php
include '../config/core.php';
include '../includes/destinationfunctions.php';
checkLogin();

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
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<body>
    <nav>
        <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
            <li class="link"><a href="../templates/calender.php">Your Schedule</a></li>
            <!-- <li class="link"><a href="../templates/profile.php">Profile</a></li> -->
            <li class="link"><a href="../templates/settings.php">Settings</a>
                <ul class="sub-menu">
                    <li><a href="../templates/profile.php">Profile</a></li>
                </ul>
            </li>

            <li class="link"><a href="../templates/destination.php">Destinations</a></li>
        </ul>
        <button class="btn">Go back</button>
    </nav>
    <div class="container">
        <h3 class="getquotetext">Get Quote</h3>

        <div class="blocks">
            <div class="left">
                <div class="triptype">
                    <button type="button" id="oneWayButton" class="one-way-button active">One-Way</button>
                    <button type="button" id="roundTripButton" class="one-way-button">Round-Trip</button>
                </div>
                <form id="oneWayForm" style="display: block;">
                    <div class="destination">
                        <p>From</p>
                        <div class="select">
                            <?php
                            echo generateDestinationOptions($conn, 'fromDestination', 'Select From Destination');
                            ?>
                        </div>
                    </div>
                    <div class="destination">
                        <p>To</p>
                        <div class="select">
                            <?php
                            echo generateDestinationOptions($conn, 'toDestination', 'Select To Destination');
                            ?>
                        </div>
                    </div>
                    <div class="date-input-container">
                        <p>Departure Date</p>
                        <i class="fas fa-calendar-alt date-icon"></i>
                        <input type="date" class="date-input-field" type="text" id="departureDate" placeholder="mm/dd/yyyy">
                    </div>
                    <div class="date-input-container">
                        <p>Arrival Date</p>
                        <i class="fas fa-calendar-alt date-icon"></i>
                        <input type="date" class="date-input-field" type="text" id="arrivalDate" placeholder="mm/dd/yyyy">
                    </div>
                    <div class="select">
                        <p>Passengers</p>
                        <div class="selectBtn" data-type="passengerCount"><i class="fas fa-user"></i>Passengers</div>
                        <div class="selectDropdown">
                            <div class="option" data-type="1"><i class="fas fa-user"></i>1</div>
                            <div class="option" data-type="2"><i class="fas fa-user"></i>2</div>
                            <div class="option" data-type="3"><i class="fas fa-user"></i>3</div>
                        </div>

                    </div>

                    <div class="select">
                        <p>Class</p>
                        <div class="selectBtn" data-type="classSelection"><i class="fas fa-user"></i>Choose Class</div>
                        <div class="selectDropdown">
                            <div class="option" data-type="business">Business Class</div>
                            <div class="option" data-type="economy">Economy</div>
                            <div class="option" data-type="first">First Class</div>
                        </div>
                    </div>
                </form>

                <form id="roundTripForm" style="display: none;">
                    <div class="destination">
                        <p>Destination</p>
                        <div class="select">
                            <?php
                            echo generateDestinationOptions($conn, 'Destination', 'Select Destination');
                            ?>

                        </div>
                    </div>
                    <div class="date-input-container">
                        <p>Departure Date</p>
                        <i class="fas fa-calendar-alt date-icon"></i>
                        <input type="date" class="date-input-field" type="text" id="roundTripDepartureDate" placeholder="mm/dd/yyyy">
                    </div>
                    <div class="date-input-container">
                        <p>Arrival Date</p>
                        <i class="fas fa-calendar-alt date-icon"></i>
                        <input type="date" class="date-input-field" type="text" id="roundTripArrivalDate" placeholder="mm/dd/yyyy">
                    </div>
                    <div class="select">
                        <p>Passengers</p>
                        <div class="selectBtn" data-type="roundTripPassengerCount"><i class="fas fa-user"></i>Passengers</div>
                        <div class="selectDropdown">
                            <div class="option" data-type="1"><i class="fas fa-user"></i>1</div>
                            <div class="option" data-type="2"><i class="fas fa-user"></i>2</div>
                            <div class="option" data-type="3"><i class="fas fa-user"></i>3</div>
                        </div>

                    </div>

                    <div class="select">
                        <p>Class</p>
                        <div class="selectBtn" data-type="classSelection"><i class="fas fa-user"></i>Choose Class</div>
                        <div class="selectDropdown">
                            <div class="option" data-type="business">Business Class</div>
                            <div class="option" data-type="economy">Economy</div>
                            <div class="option" data-type="first">First Class</div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="right">
                <div class="trip-detail-container">
                    <!-- Trip details container -->
                    <div id="oneWayTripDetails" style="display: block;">
                        <h3 class="trip-detail-title">One-Way</h3>
                        <table>
                            <tr>
                                <td>From</td>
                                <td id="selectedFromDestination">Thunder Bay</td>
                            </tr>
                            <tr>
                                <td>To</td>
                                <td id="selectedToDestination">Longlac</td>
                            </tr>
                            <tr>
                                <td>Stops</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Departure</td>
                                <td>2021-08-28 18:00:00 ET</td>
                            </tr>
                            <tr>
                                <td>Arrival</td>
                                <td>2021-08-28 17:00:00 ET</td>
                            </tr>
                        </table>
                    </div>

                    <div id="roundTripDetails" style="display: none;">
                        <h3 class="trip-detail-title">Round-Trip</h3>
                        <table>
                            <tr>
                                <td>Destination</td>
                                <td>Thunder Bay</td>
                            </tr>

                            <tr>
                                <td>Stops</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>Departure</td>
                                <td>2021-08-28 18:00:00 ET</td>
                            </tr>
                            <tr>
                                <td>Arrival</td>
                                <td>2021-08-28 17:00:00 ET</td>
                            </tr>
                        </table>
                    </div>
                    <hr>
                    <div class="price-container">
                        <h3 class="trip-detail-title">Price</h3>
                        <table>
                            <tr>
                                <td>Base Price</td>
                                <td>CA $300</td>
                            </tr>
                            <tr>
                                <td>Tax</td>
                                <td>CA $30</td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td>CA $330</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="buttons">

            <button type="submit" form="oneWayForm">Get Quote</button>
            <button type="submit" form="roundTripForm">Book Tickets</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="../public/js/flight.js"></script>

  
</body>
<script>
    $(document).ready(function() {
    $('#getQuoteButton').click(function() {
        var fromDestination = $('#selectedFromDestination').text();
        var toDestination = $('#selectedToDestination').text();
        var departureDate = $('#departureDate').val();
        var passengers = $('#passengers').val(); // Assuming the ID for passengers input is "passengers"
        var travelClass = $('#travelClass').val(); // Assuming the ID for class select is "travelClass"

        // Send AJAX request to server to calculate quote
        $.ajax({
            url: 'calculateQuote.php',
            type: 'POST',
            data: {
                from: fromDestination,
                to: toDestination,
                departure: departureDate,
                passengers: passengers,
                class: travelClass,
            },
            success: function(response) {
                var data = JSON.parse(response);
                // Update trip details on the right side
                updateTripDetails(data);
            }
        });
    });
});

function updateTripDetails(data) {
    $('#selectedFromDestination').text(data.from);
    $('#selectedToDestination').text(data.to);
    $('#passengerCount').text(data.passengers);
    $('#selectedClass').text(data.class);
    $('#basePrice').text(data.basePrice);
    $('#tax').text(data.tax);
    $('#totalPrice').text(data.totalPrice);
}

</script>
</html>