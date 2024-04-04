<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <title>Sign in & Sign up Form</title>

    <link rel="stylesheet" href="../public/css/Login.css" />
    <link rel="stylesheet" href="../public/css/notification.css">


</head>


<body>
    <main>
        <div class="box">
            <div class="inner-box">
                <div class="forms-wrap">
                    <form action="../actions/login_action.php" method="post" autocomplete=" off" class="sign-in-form">
                        <div class="logo">
                            <img src="../assets/images/logo-no-background.png" alt="CliffCo" />
                            <h4>CliffCo</h4>
                        </div>

                        <div class="heading">
                            <h2>Welcome Back</h2>
                            <h6>Not registred yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" required
                                    placeholder="Email or Emirates Skywards Number" name="email" />
                                <label>Email</label>
                            </div>

                            <div class=" input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off"
                                    required="password" name="password" />
                                <label>Password</label>
                            </div>

                            <button type="submit" value="Sign In" class="sign-btn" name="login_submit"> Sign in</button> 

                            <p class="text">
                                Forgotten your password or you login datails?
                                <a href="#">Get help</a> signing in
                            </p>
                        </div>
                    </form>

                    <form action="../actions/register_action.php" method="post" autocomplete=" off"
                        class="sign-up-form">


                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle">Sign in</a>
                        </div>

                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                                    name="first_name" />
                                <label>First Name</label>
                            </div>
                            <div class="input-wrap">
                                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                                    name="last_name" />
                                <label>Last Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" class="input-field" autocomplete="off" required name="email" />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" minlength="4" class="input-field" autocomplete="off" required
                                    name="password" />
                                <label>Password</label>
                            </div>

                            <div class="input-wrap">
                                <input type="date" class="input-field" autocomplete="off" required name="dob" />
                                <label> dd/mm/yyyy</label>
                            </div>

                            <div class="input-wrap">
                                <input type="tel" class="input-field" autocomplete="off" required
                                    name="mobile_number" />
                                <label>Mobile Number</label>
                            </div>

                            <div class="input-wrap">
                                <input type="text" class="input-field" autocomplete="off" required name="country" />
                                <label>Country</label>
                            </div>

                            <input type="submit" value="Sign Up" class="sign-btn" name="register_submit" />

                            <p class="text">
                                By signing up, I agree to the
                                <a href="#">Terms of Services</a> and
                                <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </form>

                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="../assets/images/image1.png" class="image img-1 show" alt="" />
                        <img src="../assets/images/image2.png" class="image img-2" alt="" />
                        <img src="../assets/images/image3.png" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Book Flights</h2>
                                <h2>Save Time Stay Online</h2>
                                <h2>No Hussle.</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php
                    if (isset($_GET['msg']) && $_GET['msg'] === "Incorrect password") {
                        echo "swal('Warning', 'Incorrect password', 'warning');";
                    }
                    if (isset($_GET['msg']) && $_GET['msg'] === "success") {
                      echo "swal('Success', 'success', 'success');";
                  }
                    if (isset($_GET['msg']) && $_GET['msg'] === "User not registered") {
                        echo "swal('Warning', 'User not registered', 'warning');";
                    }
                    if (isset($_GET['msg']) && $_GET['msg'] === "Invalid password") {
                        echo "swal('Warning', 'Invalid password', 'warning');";
                    }
                    ?>

    });
    </script>
    <!-- Toast notification -->
    <div class="toast">
        <div class="toast-content">
            <i class="fas fa-solid fa-check check"></i>
            <div class="message">
                <span class="text text-1"></span>
                <span class="text text-2"></span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>
    <!-- End of Toast notification -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('msg');
    if (message) {
        swal("Notice", message, "info");
    }
});
</script>

    <script src="../public/js/Login.js"></script>
</body>

</html>