<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
include '../includes/destinationfunctions.php';
checkLogin();

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
            <li class="link"><a href="../templates/calender.php">Your Schedule</a></li>
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
        <?php
        include '../templates/time.php'
        ?>
        <h1 class="section__header">Welcome, <?php echo getUserFullName($_SESSION['user_id']); ?></h1>
        <img src="../assets/images/asset1.jpg" alt="header" />
    </header>
    <section id="find-flight" class="section__container booking__container">
    <h2 class="section__header">Find Your Flight</h2>
    <form class="booking__form">
        <div class="form__group">
            <div class="input__icon"><i class="ri-airplane-takeoff-line"></i></div>
            <select name="departure" id="departure">
            <?php

        $destinations = getDestinations();

        if (!empty($destinations)) {
            // Iterate over the destinations to generate options
            foreach ($destinations as $destination) {
                echo "<option value=\"$destination\">$destination</option>";
            }
        } else {
            echo "<option value=\"\">No destinations available</option>";
        }
        ?>
            </select>
        </div>
        <div class="form__group">
            <div class="input__icon"><i class="ri-airplane-landing-line"></i></div>
            <select name="arrival" id="arrival">
            <?php
        if (!empty($destinations)) {
            foreach ($destinations as $destination) {
                echo "<option value=\"$destination\">$destination</option>";
            }
        } else {
            echo "<option value=\"\">No destinations available</option>";
        }
        ?>
            </select>
        </div>
        <div class="form__group">
            <div class="input__icon"><i class="ri-ticket-line"></i></div>
            <input type="text" placeholder="Booking code (optional)">
        </div>
        <button type="submit" class="btn">Search</button>
    </form>
</section>



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
    

    
<script src="../public/js/dashboard.js"></script>
<script src="../public/js/alert.js"></script>


</body>

</html>