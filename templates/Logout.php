<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
checkLogin();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../public/css/logout.css" />
    <link rel="icon" href="../assets/images/brand.png" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon_io/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon_io/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/favicon_io/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="../assets/favicon_io/android-chrome-512x512.png">
    <title>Log Out</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="../actions/logout_action.php" class="sign-in-form" method="post">
                    <h2 class="title">Log Out</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="<?php echo getUserFullName($_SESSION['user_id']); ?>"
                            readonly />
                    </div>
                    <input type="submit" value="Logout" class="btn solid" />
                    <p class="social-text">Want to know more ? reach us at our websites</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </form>

            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Mistake ?</h3>
                    <p>
                        Are you sure you want to log out? Your satisfaction is our priority, and we're here to assist
                        you. If you have any questions or concerns.
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Go back
                    </button>
                </div>
                <img src="img/log.svg" class="image" alt="" />
            </div>
        </div>
    </div>
   
</body>
<script src="../public/js/logout.js"></script>
</html>