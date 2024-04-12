<?php
include '../config/core.php';
include '../includes/Userfunctions.php';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <title>Settings</title>
    <link rel="stylesheet" href="../public/css/settings.css">
    <link rel="stylesheet" href="../public/css/notification.css">
    <link rel="icon" href="../assets/images/brand.png" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon_io/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon_io/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/favicon_io/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="../assets/favicon_io/android-chrome-512x512.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    <nav>
        <div class="nav__logo">CliffCo Airways</div>
        <ul class="nav__links">
            <li class="link"><a href="../templates/myflights.php">Your Schedule</a></li>
            <li class="link"><a href="../templates/profile.php">Profile</a>
            <li class="link"><a href="../templates/dashboard.php">Go Back</a>

            </li>

            <li class="link"><a href="../templates/destination.php">Destinations</a></li>
        </ul>
        <button class="btn" id="goBackBtn">Go back</button>
    </nav>
    <div class="container light-style flex-grow-1 container-p-y">
        <form action="../actions/updateprofile.php" method="post" enctype="multipart/form-data">
            <h4 class="font-weight-bold py-3 mb-4">
                Account settings
            </h4>
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-social-links">Social links</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Connections</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-notifications">Notifications</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <img src="<?php echo getUserProfileImage($_SESSION['user_id']); ?>" alt class="d-block ui-w-80">
                                    <div class="media-body ml-4">
                                        <label class="btn btn-outline-primary">
                                            Select Photo And Click Upload
                                            <input type="file" name="profile_picture" class="account-settings-fileinput">
                                        </label> &nbsp;
                                        <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                                        <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K
                                        </div>
                                    </div>
        </form>
    </div>
    <hr class="border-light m-0">
    <div class="card-body">
        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" class="form-control mb-1" value="<?php echo getUserFullName($_SESSION['user_id']); ?>" readonly>
        </div>
        <div class="form-group">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" value="<?php echo getUserFullName($_SESSION['user_id']); ?>" readonly>
        </div>
        <div class="form-group">
    <label class="form-label">E-mail</label>
    <input type="text" class="form-control mb-1" value="<?php echo getUserEmail($_SESSION['user_id']); ?>" readonly>
    <?php
    // Check if activation hash is null, indicating email is verified
    $stmt = $conn->prepare("SELECT account_activation_hash FROM Users WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($activation_hash);
    $stmt->fetch();
    $stmt->close();

    if ($activation_hash === null) { // Email is verified
        ?>
            <div class="alert alert-success mt-3">
                Email verified
            </div>
    <?php } else { // Email is not verified ?>
            <div class="alert alert-warning mt-3">
                Your email is not confirmed.<br>
                <form action="../actions/account_activate.php" method="post">
                    <button type="submit" name="send_confirmation" class="btn btn-link p-0 m-0 text-primary">Send confirmation</button>
                </form>
            </div>
    <?php } ?>
</div>

        <style>
            .btn-link {
                background-color: transparent;
                border: none;
                padding: 0;
                margin: 0;
                text-decoration: underline;
                color: inherit;
                cursor: pointer;
            }

            .btn-link:hover {
                background-color: transparent;
                text-decoration: none;
            }
        </style>

        <div class="form-group">
            <label class="form-label">Country</label>
            <input type="text" class="form-control" value="<?php echo getUserCountry($_SESSION['user_id']); ?>" readonly>
        </div>
    </div>
    </div>
    <div class="tab-pane fade" id="account-change-password">
        <form method="post" action="../actions/change_password.php">
            <div class="card-body pb-2">
                <div class="form-group">
                    <label class="form-label">Current password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">New password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Repeat new password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="submit" name="change_password" class="btn btn-primary">Change password</button>
            </div>

    </div>
    <div class="tab-pane fade" id="account-info">
        <div class="card-body pb-2">
            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea id="bioInput" class="form-control" rows="5"></textarea>
                <button id="saveBioBtn" class="btn btn-primary">Save Bio</button>

            </div>
            <div class="form-group">
                <label class="form-label">Birthday</label>
                <input type="text" class="form-control" value="<?php echo getUserBirthday($_SESSION['user_id']); ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" value="<?php echo getUserCountry($_SESSION['user_id']); ?>" readonly>
            </div>
        </div>
        <hr class="border-light m-0">
        <div class="card-body pb-2">
            <h6 class="mb-4">Contacts</h6>
            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" value="<?php echo getUserPhoneNumber($_SESSION['user_id']); ?>" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Website</label>
                <input type="text" class="form-control" value>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="account-social-links">
        <div class="card-body pb-2">
            <div class="form-group">
                <label class="form-label">Twitter</label>
                <input type="text" class="form-control" value="https://twitter.com/user">
            </div>
            <div class="form-group">
                <label class="form-label">Facebook</label>
                <input type="text" class="form-control" value="https://www.facebook.com/user">
            </div>
            <div class="form-group">
                <label class="form-label">Google+</label>
                <input type="text" class="form-control" value>
            </div>
            <div class="form-group">
                <label class="form-label">LinkedIn</label>
                <input type="text" class="form-control" value>
            </div>
            <div class="form-group">
                <label class="form-label">Instagram</label>
                <input type="text" class="form-control" value="https://www.instagram.com/user">
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="account-connections">
        <div class="card-body">
            <button type="button" class="btn btn-twitter">Connect to
                <strong>Twitter</strong></button>
        </div>
        <hr class="border-light m-0">
        <div class="card-body">
            <h5 class="mb-2">
                <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i class="ion ion-md-close"></i> Remove</a>
                <i class="ion ion-logo-google text-google"></i>
                You are connected to Google:
            </h5>
            <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
        </div>
        <hr class="border-light m-0">
        <div class="card-body">
            <button type="button" class="btn btn-facebook">Connect to
                <strong>Facebook</strong></button>
        </div>
        <hr class="border-light m-0">
        <div class="card-body">
            <button type="button" class="btn btn-instagram">Connect to
                <strong>Instagram</strong></button>
        </div>
    </div>
    <div class="tab-pane fade" id="account-notifications">
        <div class="card-body pb-2">
            <h6 class="mb-4">Activity</h6>
            <div class="form-group">
                <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked>
                    <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Email me when someone comments on my
                        article</span>
                </label>
            </div>
            <div class="form-group">
                <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked>
                    <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Email me when someone answers on my forum
                        thread</span>
                </label>
            </div>
            <div class="form-group">
                <label class="switcher">
                    <input type="checkbox" class="switcher-input">
                    <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Email me when someone follows me</span>
                </label>
            </div>
        </div>
        <hr class="border-light m-0">
        <div class="card-body pb-2">
            <h6 class="mb-4">Application</h6>
            <div class="form-group">
                <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked>
                    <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">News and announcements</span>
                </label>
            </div>
            <div class="form-group">
                <label class="switcher">
                    <input type="checkbox" class="switcher-input">
                    <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Weekly product updates</span>
                </label>
            </div>
            <div class="form-group">
                <label class="switcher">
                    <input type="checkbox" class="switcher-input" checked>
                    <span class="switcher-indicator">
                        <span class="switcher-yes"></span>
                        <span class="switcher-no"></span>
                    </span>
                    <span class="switcher-label">Weekly blog digest</span>
                </label>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <div class="text-right mt-3">
        <!-- <button type="submit" class="btn btn-primary">Save changes</button>&nbsp; -->
        <button type="button" class="btn btn-default">Cancel</button>
    </div>
    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('msg');
            if (message) {
                // Display message in the toast div
                document.querySelector(".toast .message .text-1").textContent = message;
                document.querySelector(".toast").classList.add("active");
                document.querySelector(".progress").classList.add("active");
                setTimeout(() => {
                    document.querySelector(".toast").classList.remove("active");
                    setTimeout(() => {
                        document.querySelector(".progress").classList.remove("active");
                    }, 300);
                }, 5000);
            }
        });

        const closeIcon = document.querySelector(".close");

        closeIcon.addEventListener("click", () => {
            document.querySelector(".toast").classList.remove("active");
            setTimeout(() => {
                document.querySelector(".progress").classList.remove("active");
            }, 300);
        });
    </script>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/settings.js"></script>
    <script src="../public/js/notification.js"></script>

    <script>
        // Get the button element
        const goBackBtn = document.getElementById('goBackBtn');

        // Add click event listener
        goBackBtn.addEventListener('click', function() {
            // Redirect to the dashboard page
            window.location.href = '../templates/dashboard.php';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the save bio button
            const saveBioBtn = document.getElementById('saveBioBtn');

            // Add click event listener to the save bio button
            saveBioBtn.addEventListener('click', function() {
                // Get the bio input value
                const bio = document.getElementById('bioInput').value;

                // Save the bio to local storage
                localStorage.setItem('userBio', bio);

                // Display a success message
                alert('Bio saved successfully!');
            });

            // Function to load saved bio from local storage
            function loadSavedBio() {
                const savedBio = localStorage.getItem('userBio');
                if (savedBio) {
                    // Set the bio input value to the saved bio
                    document.getElementById('bioInput').value = savedBio;
                }
            }

            // Call the loadSavedBio function when the page loads
            loadSavedBio();
        });
    </script>

</body>

</html>