<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
checkLogin();

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
                    <li><span>4,073</span>Flights</li>
                    <li><span>322</span>Following</li>
                    <li><span>200,543</span>Attraction</li>
                </ul>

                <div class="content">
                    <p>
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
                        erat volutpat. Morbi imperdiet, mauris ac auctor dictum, nisl
                        ligula egestas nulla.
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
                    <img src="img/img_1.avif" alt="Photo" />
                    <img src="img/img_2.avif" alt="Photo" />
                    <img src="img/img_3.avif" alt="Photo" />
                    <img src="img/img_4.avif" alt="Photo" />
                    <img src="img/img_5.avif" alt="Photo" />
                    <img src="img/img_6.avif" alt="Photo" />
                </div>
            </div>
        </div>
    </div>
</body>

</html>