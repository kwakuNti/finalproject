<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../config/core.php';
include '../config/connection.php';
include '../includes/Userfunctions.php';




if (isset($_SESSION['user_id'])) {
       ?>
    <div class="container mb-5">
        <!-- <h1 class="text-center text-light mt-4 mb-4">E-TICKETS</h1> -->

        <?php
        if (isset($_POST['print_but'])) {
            $ticket_id = $_POST['booking_id'];
            $stmt = mysqli_stmt_init($conn);
            $sql = 'SELECT * FROM Bookings WHERE booking_id=?';
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header('Location: ticket.php?error=sqlerror');
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, 'i', $ticket_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $sql_p = 'SELECT * FROM Users WHERE user_id=?';
                    $stmt_p = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($stmt_p, $sql_p)) {
                        header('Location: ticket.php?error=sqlerror');
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt_p, 'i', $row['user_id']);
                        mysqli_stmt_execute($stmt_p);
                        $result_p = mysqli_stmt_get_result($stmt_p);
                        if ($row_p = mysqli_fetch_assoc($result_p)) {
                            $sql_f = 'SELECT * FROM flights WHERE flight_id=?';
                            $stmt_f = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt_f, $sql_f)) {
                                header('Location: ticket.php?error=sqlerror');
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt_f, 'i', $row['flight_id']);
                                mysqli_stmt_execute($stmt_f);
                                $result_f = mysqli_stmt_get_result($stmt_f);
                                if ($row_f = mysqli_fetch_assoc($result_f)) {
                                    $date_time_dep = $row_f['departure_time'];
                                    $date_dep = substr($date_time_dep, 0, 10);
                                    $time_dep = substr($date_time_dep, 10, 6);
                                    $date_time_arr = $row_f['arrival_time'];
                                    $date_arr = substr($date_time_arr, 0, 10);
                                    $time_arr = substr($date_time_arr, 10, 6);
                                    if ($row['class'] === 'Economy') {
                                        $class_txt = 'ECONOMY';
                                    } else if ($row['class'] === 'Business') {
                                        $class_txt = 'BUSINESS';
                                    } else if ($row['class'] === 'First') {
                                        $class_txt = 'FIRST';
                                    }
                                    echo '
                        <div class="row mb-5">                                                         
                        <div class="col-9 out">
                            <div class="row ">                                                     
                                <div class="col">
                                    <h2 class="text-secondary mb-0 brand">
                                        Online Flight Booking</h2> 
                                </div>
                                <div class="col">
                                    <h2 class="mb-0">' . $class_txt . ' CLASS</h2>
                                </div>
                            </div>
                            <hr>
                            <div class="row mb-3">  
                                <div class="col-4">
                                    <p class="head">Airline</p>
                                    <p class="txt">' . $row_f['airline'] . '</p>
                                </div>            
                                <div class="col-4">
                                    <p class="head">from</p>
                                    <p class="txt">' . $row_f['origin'] . '</p>
                                </div>
                                <div class="col-4">
                                    <p class="head">to</p>
                                    <p class="txt">' . $row_f['destination'] . '</p>                
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-8">
                                    <p class="head">Passenger</p>
                                    <p class=" h5 text-uppercase">
                                    ' . $row_p['first_name'] .' ' . $row_p['last_name'] . '
                                    </p>
                                </div>
                                <div class="col-4">
                                    <p class="head">board time</p>
                                    <p class="txt">12:45</p>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <p class="head">departure</p>
                                    <p class="txt mb-1">' . $date_dep . '</p>
                                    <p class="h1 font-weight-bold mb-3">' . $time_dep . '</p>  
                                </div>
                                <div class="col-3">
                                    <p class="head">arrival</p>
                                    <p class="txt mb-1">' . $date_arr . '</p>
                                    <p class="h1 font-weight-bold mb-3">' . $time_arr . '</p>  
                                </div>
                                <div class="col-3">
                                    <p class="head">gate</p>
                                    <p class="txt">A22</p>
                                </div>
                                <div class="col-3">
                                    <p class="head">seat</p>
                                    <p class="txt">' . $row['seat_no'] . '</p>
                                </div> 
                            </div>
                        </div>
                        <div class="col-3 bord pl-0" style="background-color:#376b8d;
                            padding:20px;  border-top-right-radius: 25px; border-bottom-right-radius: 25px;">
                            <div class="row">
                                <div class="col">
                                <h2 class="text-light text-center brand">
                                    Online Flight Booking</h2>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <img src="assets/images/airtic.png" class="mx-auto d-block"
                                    height="180px" width="200px" alt="">
                                </div>
                            </div>
                            <div class="row">
                            <h3 class="text-light2 text-center mt-2 mb-0">
                            &nbsp Thank you for choosing us. </br> </br>
                                Please be at the gate at boarding time</h3>
                            </div>
                        </div>
                        </div>
                      ';
                                }
                            }
                        }
                    }
                }
            }
        }   ?>

    </div>
    </main>
<?php } ?>
<script>
    window.print();
</script>