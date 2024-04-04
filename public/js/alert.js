
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(() => {
        Swal.fire({
            title: 'Please upload a profile picture',
            text: 'You need to upload a profile picture to continue.',
            icon: 'warning',
            showCancelButton: false,
            confirmButtonText: 'Go to Settings',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../templates/settings.php';
            }
        });
    }, 1000);
});
