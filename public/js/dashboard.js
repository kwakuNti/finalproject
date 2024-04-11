
  document.addEventListener("DOMContentLoaded", function() {
    const logoutButton = document.getElementById('logoutButton');
    // Add click event listener to the logout button
    logoutButton.addEventListener('click', function() {
        // Redirect to the logout page
        window.location.href = "../templates/Logout.php";
    });
});