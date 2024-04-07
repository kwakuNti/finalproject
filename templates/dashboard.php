<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
include '../includes/destinationfunctions.php';
checkLogin();
checkUserRole();
// Check if the session flag for animation has been set
$animationPlayed = isset($_SESSION['animation_played']) && $_SESSION['animation_played'];

// Set the session flag to true if it hasn't been set already
if (!$animationPlayed) {
    $_SESSION['animation_played'] = true;
}
if (!hasProfilePicture($_SESSION['user_id'])) {
    ?>
    <script>
        setTimeout(function() {
            swal({
                title: 'Please upload a profile picture',
                text: 'You need to upload a profile picture to continue. Your Identity Is Important',
                icon: 'warning',
                buttons: {
                    confirm: {
                        text: 'Go to Settings',
                        value: true,
                        visible: true,
                        className: 'btn-primary',
                        closeModal: true
                    }
                }
            }).then((result) => {
                if (result) {
                    window.location.href = '../templates/settings.php';
                }
            });
        }, 5000);
    </script>
    <?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins&display=swap">
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link rel="stylesheet" href="../public/css/dashboard.css" />
    <title>Take Flight</title>
</head>

<body>
<div class="intro" <?php if ($animationPlayed) echo 'style="display: none;"'; ?>>
        <h1 class="logo-header">
            <span class="logo">Cliff</span><span class="logo">Co.</span>
        </h1>
    </div>
    <script>
        let intro =document.querySelector('.intro');
        let logo = document.querySelector('.logo-header');
        let logoSpan = document.querySelectorAll('.logo');


        window.addEventListener('DOMContentLoaded',()=>{
            setTimeout(()=>{
                logoSpan.forEach((span,idx)=>{
                    setTimeout(()=>{
                        span.classList.add('active');
                    },(idx+1)*400)
                });

                setTimeout(()=>{
                    logoSpan.forEach((span,idx)=>{


                        setTimeout(()=>{
                            span.classList.remove('active');
                            span.classList.add('fade'); 
                        },(idx+1)*50)
                    })
                },2000)

                setTimeout(()=>{
                    intro.style.top='-100vh';
                },2300)
            })
        })

    </script>
    <nav>
    <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
            <li class="link"><a href="../templates/myflights.php">My Flights</a></li>
            <!-- <li class="link"><a href="../templates/profile.php">Profile</a></li> -->
            <li class="link"><a href="../templates/settings.php">Settings</a>
                <ul class="sub-menu">
                    <li><a href="../templates/profile.php">Profile</a></li>
                </ul>
            </li>
            <li class="link"><a href="../templates/flight.php">Book a flight</a>
                <ul class="sub-menu">
                <li class="link"><a href="#find-flight">Find a Flight</a></li> 
                </ul>
            </li>
            <li class="link"><a href="../templates/destination.php">Destinations</a></li>
        </ul>
        <button class="btn" id="logoutButton">Log out</button>
    </nav>
    <header class="section__container header__container">
    <h1 class="section__header">
            <?php
            // Get the current hour of the day
            $currentHour = date('G');

            // Define greeting based on the time of day
            if ($currentHour >= 5 && $currentHour < 12) {
                echo 'Good morning, ';
            } elseif ($currentHour >= 12 && $currentHour < 18) {
                echo 'Good afternoon, ';
            } else {
                echo 'Good evening, ';
            }

            // Output the user's full name
            echo getUserFullName($_SESSION['user_id']);
            ?>
        </h1>        <img src="../assets/images/asset1.jpg" alt="header" />
    </header>
    <section id="find-flight" class="section__container booking__container">
    <h2 class="section__header">Find Your Flight</h2>
    <form class="booking__form">
    <div class="form__group">
        <div class="input__icon"><i class="ri-airplane-takeoff-line"></i></div>
        <select name="departure" id="departure">
            <option value="">Select departure</option>
            <?php
            $destinations = getDestinations();

            if (!empty($destinations)) {
                foreach ($destinations as $destination) {
                    // Assuming each $destination is an associative array with 'destination_id' and 'name' keys
                    echo "<option value=\"{$destination['destination_id']}\">{$destination['name']}</option>";
                }
            } else {
                echo "<option value=\"\">No destinations available</option>";
            }
            ?>
        </select>
    </div>
    <div class="form__group">
        <div class="input__icon"><i class="ri-airplane-landing-line"></i></div>
        <select name="destination" id="destination">
            <option value="">Select destination</option>
            <?php
            if (!empty($destinations)) {
                foreach ($destinations as $destination) {
                    // Assuming each $destination is an associative array with 'destination_id' and 'name' keys
                    echo "<option value=\"{$destination['destination_id']}\">{$destination['name']}</option>";
                }
            } else {
                echo "<option value=\"\">No destinations available</option>";
            }
            ?>
        </select>
    </div>
    <div class="form__group">
        <div class="input__icon"><i class="ri-ticket-line"></i></div>
        <input type="text" placeholder="Booking code (optional)" name="bookingCode" id="bookingCode">
    </div>
    <button type="submit" class="btn" id="searchButton">Search</button>
</form>

</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('searchButton').addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get form data
            var bookingCode = document.getElementById('bookingCode').value;
            var departure = document.getElementById('departure').value;
            var destination = document.getElementById('destination').value;

            // Create an XMLHttpRequest object
            var xhr = new XMLHttpRequest();

            // Configure the request
            xhr.open('POST', '../actions/search.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Define the callback function
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    // Parse the JSON response
                    var response = JSON.parse(xhr.responseText);

                    // Check if the search was successful
                    if (response.success) {
                        // Check if there are any flights
                        if (response.flights.length > 0) {
                            // Construct the flight details table
                            var flightDetailsTable = '<table class="flight-details-table">';
                            flightDetailsTable += '<thead><tr><th>Flight Code</th><th>Departure</th><th>Destination</th><th>Departure Time</th><th>Arrival Time</th><th>Book</th></tr></thead><tbody>';

                            for (var i = 0; i < response.flights.length; i++) {
                                var flight = response.flights[i];
                                flightDetailsTable += '<tr>';
                                flightDetailsTable += '<td>' + flight.flight_code + '</td>';
                                flightDetailsTable += '<td>' + flight.origin_destination_name + '</td>';
                                flightDetailsTable += '<td>' + flight.destination_destination_name + '</td>';
                                flightDetailsTable += '<td>' + flight.departure_datetime + '</td>';
                                flightDetailsTable += '<td>' + flight.arrival_datetime + '</td>';
                                flightDetailsTable += '<td><button class="book-flight-btn" data-flight-id="' + flight.id + '">Book Flight</button></td>';
                                flightDetailsTable += '</tr>';
                            }

                            flightDetailsTable += '</tbody></table>';

                            // Display SweetAlert pop-up with the flight details table
                            Swal.fire({
                                title: 'Flight Details',
                                html: flightDetailsTable,
                                icon: 'info',
                                showCancelButton: true,
                                confirmButtonText: 'Proceed to Booking',
                                cancelButtonText: 'Cancel',
                                showLoaderOnConfirm: true,
                                customClass: {
                                    popup: 'custom-popup-class', // Add custom class to control pop-up width
                                },
                                preConfirm: () => {
                                    // Handle the "Book Flight" button clicks
                                    var bookFlightButtons = document.querySelectorAll('.book-flight-btn');
                                    bookFlightButtons.forEach(function (button) {
                                        button.addEventListener('click', function () {
                                            var flightId = this.dataset.flightId;
                                            // Redirect to the flight booking page with the selected flight ID
                                            window.location.href = '../templates/flight.php?flight_id=' + flightId;
                                        });
                                    });
                                }
                            });
                        } else {
                            // Display error message if no flights were found
                            Swal.fire('No Flights Found', response.message, 'error');
                        }
                    } else {
                        // Display error message if there was a server error
                        Swal.fire('Error', response.message, 'error');
                    }
                } else {
                    // Display error message if there was a server error
                    Swal.fire('Error', 'An error occurred while processing your request.', 'error');
                }
            };

            // Send the request with form data
            xhr.send('bookingCode=' + bookingCode + '&departure=' + departure + '&destination=' + destination);
        });
    });

   
</script>


    <section class="section__container plan__container">
        <p class="subheader">TRAVEL SUPPORT</p>
        <h2 class="section__header">Plan your travel with confidence</h2>
        <p class="description">
            Find help with your bookings and travel plans, and seee what to expect
            along your journey.
        </p>
        <div class="plan__grid">
            <div class="plan__content">
                <span class="number">01</span>
                <h4>Travel Requirements for Dubai</h4>
                <p>
                    Stay informed and prepared for your trip to Dubai with essential
                    travel requirements, ensuring a smooth and hassle-free experience in
                    this vibrant and captivating city.
                </p>
                <span class="number">02</span>
                <h4>Multi-risk travel insurance</h4>
                <p>
                    Comprehensive protection for your peace of mind, covering a range of
                    potential travel risks and unexpected situations.
                </p>
                <span class="number">03</span>
                <h4>Travel Requirements by destinations</h4>
                <p>
                    Stay informed and plan your trip with ease, as we provide up-to-date
                    information on travel requirements specific to your desired
                    destinations.
                </p>
            </div>
            <div class="plan__image">
                <img src="../assets/images/asset2.jpg" alt="plan" />
                <img src="../assets/images/asset3.jpg" alt="plan" />
                <img src="../assets/images/assets4.jpg" alt="plan" />
            </div>
        </div>
    </section>

    <section class="memories">
        <div class="section__container memories__container">
            <div class="memories__header">
                <h2 class="section__header">
                    Travel to make memories all around the world
                </h2>
                <button class="view__all">View All</button>
            </div>
            <div class="memories__grid">
                <div class="memories__card">
                    <span><i class="ri-calendar-2-line"></i></span>
                    <h4>Book & relax</h4>
                    <p>
                        With "Book and Relax," you can sit back, unwind, and enjoy the
                        journey while we take care of everything else.
                    </p>
                </div>
                <div class="memories__card">
                    <span><i class="ri-shield-check-line"></i></span>
                    <h4>Smart Checklist</h4>
                    <p>
                        Introducing Smart Checklist with us, the innovative solution
                        revolutionizing the way you travel with our airline.
                    </p>
                </div>
                <div class="memories__card">
                    <span><i class="ri-bookmark-2-line"></i></span>
                    <h4>Save More</h4>
                    <p>
                        From discounted ticket prices to exclusive promotions and deals,
                        we prioritize affordability without compromising on quality.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section__container lounge__container">
        <div class="lounge__image">
            <img src="assets/lounge-1.jpg" alt="lounge" />
            <img src="assets/lounge-2.jpg" alt="lounge" />
        </div>
        <div class="lounge__content">
            <h2 class="section__header">Unaccompanied Minor Lounge</h2>
            <div class="lounge__grid">
                <div class="lounge__details">
                    <h4>Experience Tranquility</h4>
                    <p>
                        Serenity Haven offers a tranquil escape, featuring comfortable
                        seating, calming ambiance, and attentive service.
                    </p>
                </div>
                <div class="lounge__details">
                    <h4>Elevate Your Experience</h4>
                    <p>
                        Designed for discerning travelers, this exclusive lounge offers
                        premium amenities, assistance, and private workspaces.
                    </p>
                </div>
                <div class="lounge__details">
                    <h4>A Welcoming Space</h4>
                    <p>
                        Creating a family-friendly atmosphere, The Family Zone is the
                        perfect haven for parents and children.
                    </p>
                </div>
                <div class="lounge__details">
                    <h4>A Culinary Delight</h4>
                    <p>
                        Immerse yourself in a world of flavors, offering international
                        cuisines, gourmet dishes, and carefully curated beverages.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section__container travellers__container">
        <h2 class="section__header">Best travellers of the month</h2>
        <div class="travellers__grid">
            <div class="travellers__card">
                <img src="assets/traveller-1.jpg" alt="traveller" />
                <div class="travellers__card__content">
                    <img src="assets/client-1.jpg" alt="client" />
                    <h4>Emily Johnson</h4>
                    <p>Dubai</p>
                </div>
            </div>
            <div class="travellers__card">
                <img src="assets/traveller-2.jpg" alt="traveller" />
                <div class="travellers__card__content">
                    <img src="assets/client-2.jpg" alt="client" />
                    <h4>David Smith</h4>
                    <p>Paris</p>
                </div>
            </div>
            <div class="travellers__card">
                <img src="assets/traveller-3.jpg" alt="traveller" />
                <div class="travellers__card__content">
                    <img src="assets/client-3.jpg" alt="client" />
                    <h4>Olivia Brown</h4>
                    <p>Singapore</p>
                </div>
            </div>
            <div class="travellers__card">
                <img src="assets/traveller-4.jpg" alt="traveller" />
                <div class="travellers__card__content">
                    <img src="assets/client-4.jpg" alt="client" />
                    <h4>Daniel Taylor</h4>
                    <p>Malaysia</p>
                </div>
            </div>
        </div>
    </section>

    <section class="subscribe">
        <div class="section__container subscribe__container">
            <h2 class="section__header">Subscribe newsletter & get latest news</h2>
            <form class="subscribe__form">
                <input type="text" placeholder="Enter your email here" />
                <button class="btn">Subscribe</button>
            </form>
        </div>
    </section>

    <footer class="footer">
        <div class="section__container footer__container">
            <div class="footer__col">
                <h3>CliffCo</h3>
                <p>
                    Where Excellence Takes Flight. With a strong commitment to customer
                    satisfaction and a passion for air travel, Flivan Airlines offers
                    exceptional service and seamless journeys.
                </p>
                <p>
                    From friendly smiles to state-of-the-art aircraft, we connect the
                    world, ensuring safe, comfortable, and unforgettable experiences.
                </p>
            </div>
            <div class="footer__col">
                <h4>INFORMATION</h4>
                <p>Home</p>
                <p>About</p>
                <p>Offers</p>
                <p>Seats</p>
                <p>Destinations</p>
            </div>
            <div class="footer__col">
                <h4>CONTACT</h4>
                <p>Support</p>
                <p>Media</p>
                <p>Socials</p>
            </div>
        </div>
        <div class="section__container footer__bar">
            <p>Copyright © 2024 CliffCo. All rights reserved.</p>
            <div class="socials">
                <span><i class="ri-facebook-fill"></i></span>
                <span><i class="ri-twitter-fill"></i></span>
                <span><i class="ri-instagram-line"></i></span>
                <span><i class="ri-youtube-fill"></i></span>
            </div>
        </div>
    </footer>
    </style>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');
    if (message) {
        swal("Notice", message, "info");
    }
});
</script>

    
<script src="../public/js/dashboard.js"></script>
<script src="../public/js/alert.js"></script>


</body>

</html>



