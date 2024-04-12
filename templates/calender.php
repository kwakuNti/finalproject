<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Schedule</title>
    <link rel="stylesheet" href="../public/css/calender.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/images/brand.png" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon_io/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon_io/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/favicon_io/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="../assets/favicon_io/android-chrome-512x512.png">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>

<body>
<nav>
        <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
            <li class="link"><a href="../templates/calender.php">Your Schedule</a></li>
            <li class="link"><a href="../templates/profile.php">Profile</a>
              
            </li>

            <li class="link"><a href="../templates/destination.php">Destinations</a></li>
        </ul>
        <button class="btn">Go back</button>
    </nav>
    <div class="wrapper">
        <header>
            <p class="current-date"></p>
            <div class="icons">
                <span id="prev" class="material-symbols-rounded">chevron_left</span>
                <span id="next" class="material-symbols-rounded">chevron_right</span>
            </div>
        </header>
        <div class="calendar">
            <ul class="weeks">
                <li>Sun</li>
                <li>Mon</li>
                <li>Tue</li>
                <li>Wed</li>
                <li>Thu</li>
                <li>Fri</li>
                <li>Sat</li>
            </ul>
            <ul class="days"></ul>
        </div>
    </div>
    <script src="../public/js/calender.js" defer></script>
</body>

</html>