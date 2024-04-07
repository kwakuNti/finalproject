<?php
include '../config/core.php';
include '../config/connection.php'; 
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    	<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>	
        <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
        <link rel="stylesheet" href="../public/css/myflights.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <title>Online Flight Booking</title>
        <link rel = "icon" href ="../assets/images/brand.png"  type = "image/x-icon">       
    </head>

    <body>
    <nav>
        <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
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


<main>
    <div class="container">
    <h1 class="text-center text-black mt-4 mb-4">FLIGHT STATUS</h1>
    <?php 
            $stmt = mysqli_stmt_init($conn);

            $sql = 'SELECT b.*, f.*, d1.name AS origin, d2.name AS destination, f.departure_datetime, f.arrival_datetime
            FROM Bookings b
            JOIN Flights f ON b.flight_id = f.flight_id
            JOIN Destinations d1 ON f.origin_destination_id = d1.destination_id
            JOIN Destinations d2 ON f.destination_destination_id = d2.destination_id
            WHERE b.user_id = ?';
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: myflights.php?error=sqlerror');
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $stmt = mysqli_stmt_init($conn);
            $sql = 'SELECT b.*, f.*, d1.name AS origin, d2.name AS destination, f.departure_datetime, f.arrival_datetime
            FROM Bookings b
            JOIN Flights f ON b.flight_id = f.flight_id
            JOIN Destinations d1 ON f.origin_destination_id = d1.destination_id
            JOIN Destinations d2 ON f.destination_destination_id = d2.destination_id
            WHERE b.user_id = ?';
    
    
    
                $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)) {
                header('Location: ../templates/myflights.php?error=sqlerror');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, 'i', $_SESSION['user_id']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {

                    $source = $row['origin'];
                    $date_time_dep = $row['departure_datetime'];
                    $date_dep = substr($date_time_dep, 0, 10);
                    $time_dep = substr($date_time_dep, 11, 5);
                    $date_time_arr = $row['arrival_datetime'];
                    $date_arr = substr($date_time_arr, 0, 10);
                    $time_arr = substr($date_time_arr, 11, 5);
                

                    $currentDateTime = date('Y-m-d H:i:s');
                    if ($currentDateTime < $date_time_dep) {
                        $status = "Not yet Departed";
                        $alert = 'info'; // Use SweetAlert's info type for "Not yet Departed"
                    } elseif ($currentDateTime >= $date_time_dep && $currentDateTime <= $date_time_arr) {
                        $status = "Departed";
                        $alert = 'success'; // Use SweetAlert's success type for "Departed"
                    } elseif ($currentDateTime > $date_time_arr) {
                        $status = "Arrived";
                        $alert = 'success'; // Use SweetAlert's success type for "Arrived"
                    } else {
                        $status = "Delayed";
                        $alert = 'error'; // Use SweetAlert's error type for "Delayed"
                    }
                    
                    // Include SweetAlert script to show the alert
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>';
                    echo 'swal("' . $status . '", "This flight is ' . $status . '", "' . $alert . '");';
                    echo '</script>';
                    
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>';
                    echo 'swal("' . $status . '", "This flight is ' . $status . '", "' . $alert . '");';
                    echo '</script>';
                    

                    
                    echo '
    <div class="row out mb-5 ">
        <div class="col-md-4 order-lg-3 order-md-1"> ';
if ($status === 'Arrived') {
    echo '
        <div class="row">
            <div class="col-1 p-0 m-0">
            <i class="fa fa-circle mt-4 text-primary"
                    style="float: right;"></i>
            </div>
            <div class="col-10 p-0 m-0 mt-3" style="float: right;">
                <hr class="bg-primary">
            </div>
            <div class="col-1 p-0 m-0">
                <i class="fa fa-2x fa-fighter-jet mt-3 text-primary"
                    ></i>
            </div>
        </div>
    ';
 } else {
    echo '
                                    <div class="row">
                                        <div class="col-1 p-0 m-0">
                                            <i class="fa fa-2x fa-fighter-jet mt-3 text-success"
                                                style="float: right;"></i>
                                        </div>
                                        <div class="col-10 p-0 m-0 mt-3" style="float: right;">
                                            <hr style="background-color: lightgrey;">
                                        </div>
                                        <div class="col-1 p-0 m-0">
                                            <i class="fa fa-circle mt-4"
                                                style="color: lightgrey;"></i>
                                        </div>
                                    </div>
                                    ';
                                }
                                    echo '
                                </div>
                        
                                <div class="col-md-3 col-6 order-md-2 pl-0 text-center
                                    order-lg-2 card-dep">
                                    <p class="city">'. $row['origin'].'</p>
                                    <p class="stat">Scheduled Departure:</p>
                                    <p class="date">'.$date_dep.'</p>
                                    <p class="time">'.$time_dep.'</p>
                                </div>
                                <div class="col-md-3 col-6 order-md-4 pr-0 text-center
                                    order-lg-4 card-arr"
                                    style="float: right;">
                                    <p class="city">'.$row['destination'].'</p>
                                    <p class="stat">Scheduled Arrival:</p>
                                    <p class="date">'.$date_arr.'</p>
                                    <p class="time">'.$time_arr.'</p>
                                </div>
                                <div class="col-lg-2 order-md-12">
                                    <div class="alert '.$alert.' mt-5 text-center"
                                        role="alert">
                                        '.$status.'
                                    </div>
                                </div>
                            </div> ';
                              }

                        }
                    }
                }
                
            
    ?>
</div>
</main>
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

