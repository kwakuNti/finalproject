<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
checkLogin();
if ($_SESSION['role_id'] !== '2') {
    // Redirect the user to the dashboard.php
    header("Location: ../templates/dashboard.php");
    exit;
}
// Fetch the count of flights booked by the user
$flightsBookedCount = getFlightsBookedCount($_SESSION['user_id']);

// Fetch the count of flights taken by the user
$flightsTakenCount = getFlightsTakenCount($_SESSION['user_id']);
$userImages = getUserFlightImages($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile Page</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="../public/css/profile.css" />
</head>

<body>
    <div class="header__wrapper">
        <header></header>
        <div class="cols__container">
            <div class="left__col">
                <div class="img__container">
                    <img src="<?php echo getUserProfileImage($_SESSION['user_id']); ?>" alt="Anna Smith" />
                    <span></span>
                </div>
                <h2><?php echo getUserFullName($_SESSION['user_id']); ?></h2>
                <p><?php echo  getUserEmail($_SESSION['user_id']); ?></p>
                <p><?php echo  getUserCountry($_SESSION['user_id']); ?></p>

                <ul class="about">
                <li><span><?php echo $flightsBookedCount; ?></span>Flights</li>
                    <li><span><?php echo $flightsTakenCount; ?></span>Flights Taken</li>
                    <!-- Replace 'Following' with 'Flights Taken' -->
                    <li><span>0</span>Friends and Family</li>
                </ul>

                <div class="content">
                    <p>
                    <div class="content">
    <textarea id="aboutTextarea" rows="5" cols="40" placeholder="Enter your interests or about"></textarea><br>
    <button onclick="saveAbout()">Save</button>
</div>
                    </p>

                    <ul>
                        <li><i class="fab fa-twitter"></i></li>
                        <i class="fab fa-pinterest"></i>
                        <i class="fab fa-facebook"></i>
                        <i class="fab fa-dribbble"></i>
                    </ul>
                </div>
            </div>
            <div class="right__col">
                <nav>
                    <ul>
                        <li><a href="">photos</a></li>

                    </ul>
                    <button onclick="goBack()">Go Back</button>

<script>
    function goBack() {
        window.location.href = "../templates/dashboard.php";
    }
</script>
                </nav>

                <div class="photos">
                    <?php if (!empty($userImages)): ?>
                        <?php foreach($userImages as $image): ?>
                            <img src="<?php echo $image; ?>" alt="Photo" />
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No photos available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    // Function to save about information to localStorage
    function saveAbout() {
        var about = document.getElementById('aboutTextarea').value;
        localStorage.setItem('userAbout', about);
        swal("About information saved!", {
            icon: "success",
        });
    }

    // Function to check if about information exists in localStorage and populate the textarea
    function loadAbout() {
        var storedAbout = localStorage.getItem('userAbout');
        if (storedAbout) {
            document.getElementById('aboutTextarea').value = storedAbout;
        }
    }

    // Load about information when the page is loaded
    window.onload = loadAbout;
</script>
</html>