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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.0.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="../public/css/destination.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>Destinations</title>
</head>

<body>
    <nav>
        <div class="nav__logo"><a href="../templates/dashboard.php">Back To Main</a></div>
        <ul class="nav__links">
            <input type="text" id="searchInput" placeholder="Search destinations" />
        </ul>
    </nav>
    <header style="background-image: url('../assets/images/header-background.jpg');">
        <div class="section__container">
            <div class="header__content">
                <h1>Ready?</h1>
            </div>
        </div>
    </header>

    <section class="journey__container">
        <div class="section__container">
            <h2 class="section__title">Start Your Journey</h2>
            <p class="section__subtitle">The most searched countries</p>
            <div class="journey__grid">
            <?php displayDestinations(); ?>

                <!-- <div class="country__card">
                    <img src="../assets/images/country-1.jpg" alt="country" />
                    <div class="country__name">
                        <i class="ri-map-pin-2-fill"></i>
                        <span>Santorini, Greece</span>
                    </div>
                </div>
                <div class="country__card">
                    <img src="../assets/images/country-2.jpg" alt="country" />
                    <div class="country__name">
                        <i class="ri-map-pin-2-fill"></i>
                        <span>Vernazza, Italy</span>
                    </div>
                </div>
                <div class="country__card">
                    <img src="../assets/images/country-3.jpg" alt="country" />
                    <div class="country__name">
                        <i class="ri-map-pin-2-fill"></i>
                        <span>San Francisco</span>
                    </div>
                </div>
                <div class="country__card">
                    <img src="../assets/images/country-4.jpg" alt="country" />
                    <div class="country__name">
                        <i class="ri-map-pin-2-fill"></i>
                        <span>navagio, Greece</span>
                    </div>
                </div>
                <div class="country__card">
                    <img src="../assets/images/country-5.jpg" alt="country" />
                    <div class="country__name">
                        <i class="ri-map-pin-2-fill"></i>
                        <span>Ao Nang, Thailand</span>
                    </div>
                </div>
                <div class="country__card">
                    <img src="../assets/images/country-6.jpg" alt="country" />
                    <div class="country__name">
                        <i class="ri-map-pin-2-fill"></i>
                        <span>Phi Phi Island, Thailand</span>
                    </div>
                </div> -->
            </div>
        </div>
    </section>

    <section class="display__container">
        <div class="section__container">
            <h2 class="section__title">Why Choose Us</h2>
            <p class="section__subtitle">
                The gladdest moment in human life, is a departure into unknown lands.
            </p>
            <div class="display__grid">
                <div class="display__card grid-1">
                    <img src="../assets/images/grid-1.jpg" alt="grid" />
                </div>
                <div class="display__card">
                    <i class="ri-earth-line"></i>
                    <h4>Passionate Travel</h4>
                    <p>Fuel your passion for adventure and discover new horizons</p>
                </div>
                <div class="display__card">
                    <img src="../assets/images/grid-2.jpg" alt="grid" />
                </div>
                <div class="display__card">
                    <img src="../assets/images/grid-3.jpg" alt="grid" />
                </div>
                <div class="display__card">
                    <i class="ri-road-map-line"></i>
                    <h4>Beautiful Places</h4>
                    <p>Uncover the world's most breathtakingly beautiful places</p>
                </div>
            </div>
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
                <!-- <h4>INFORMATION</h4>
                <p>Home</p>
                <p>About</p>
                <p>Offers</p>
                <p>Seats</p>
                <p>Destinations</p> -->
            </div>
            <div class="footer__col">
                <!-- <h4>CONTACT</h4>
                <p>Support</p>
                <p>Media</p>
                <p>Socials</p> -->
            </div>
        </div>
        <div class="section__container footer__bar">
            <p>Copyright © 2024 CliffCo. All rights reserved.</p>
            <!-- <div class="socials">
                <span><i class="ri-facebook-fill"></i></span>
                <span><i class="ri-twitter-fill"></i></span>
                <span><i class="ri-instagram-line"></i></span>
                <span><i class="ri-youtube-fill"></i></span>
            </div> -->
        </div>
    </footer>
    <!-- Destination Container -->
<div id="destinationContainer" class="destination-container">
    <div class="destination-content">
        <div class="destination-image"></div>
        <div class="destination-info">
            <h2 class="destination-name"></h2>
            <p class="destination-country"></p>
            <p class="destination-description"></p>
        <button id="closeBtn">Close</button>
        <button type="button" id="bookNowBtn">Book Now</button>

    </div>
</div>

<!-- JavaScript -->
<script>
    const destinationContainer = document.getElementById('destinationContainer');
    const destinationImage = document.querySelector('.destination-image');
    const destinationName = document.querySelector('.destination-name');
    const destinationCountry = document.querySelector('.destination-country');
    const destinationDescription = document.querySelector('.destination-description');
    const closeBtn = document.getElementById('closeBtn');

    // Function to show destination container with animation
    function showDestinationContainer(destination) {
        destinationImage.style.backgroundImage = `url(${destination.imageUrl})`;
        destinationName.textContent = destination.name;
        destinationCountry.textContent = destination.country;
        destinationDescription.textContent = destination.description;

        destinationContainer.classList.add('active');
    }

    // Function to hide destination container with animation
    function hideDestinationContainer() {
        destinationContainer.classList.remove('active');
    }

    // Close button event listener
    closeBtn.addEventListener('click', hideDestinationContainer);

    // Attach click event listeners to destination cards
    const destinationCards = document.querySelectorAll('.country__card');
    destinationCards.forEach(card => {
        card.addEventListener('click', () => {
            const destination = {
                imageUrl: card.querySelector('img').src,
                name: card.querySelector('.country__name span').textContent,
                country: card.querySelector('.country__name span').textContent,
                description: card.querySelector('.description').textContent
            };
            showDestinationContainer(destination);
        });
    });
</script>


<!-- CSS -->
<style>
    .destination-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
    }

    /* Hide the destination description by default */
.description {
    display: none;
}


    .destination-container.active {
        display: flex;
    }

    .destination-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        max-width: 600px;
        width: 100%;
        animation: slideIn 0.5s forwards;
    }

    @keyframes slideIn {
        0% {
            opacity: 0;
            transform: scale(0.5);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .destination-image {
        width: 100%;
        height: 300px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .destination-info {
        text-align: center;
    }

    #closeBtn {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #bookNowBtn{
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    
    /* Adjust z-index of SweetAlert modal */
    .custom-swal-popup {
        z-index: 10001  !important; /* Adjust as needed */
    }

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
 
</script>

    <script src="../public/js/destination.js"></script>
</body>

</html>