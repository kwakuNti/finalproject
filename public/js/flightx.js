const select = document.querySelectorAll('.selectBtn');
const option = document.querySelectorAll('.option');
let index = 1;

select.forEach(a => {
	a.addEventListener('click', b => {
		const next = b.target.nextElementSibling;
		next.classList.toggle('toggle');
		next.style.zIndex = index++;
	})
})
option.forEach(a => {
	a.addEventListener('click', b => { 
		b.target.parentElement.classList.remove('toggle');
		const parent = b.target.closest('.select').children[0];

		parent.setAttribute('data-type', b.target.innerHTML);

		parent.innerHTML = b.target.innerHTML;
	})
});
$( function() {
    $( "#sourcedatepicker" ).datepicker();
	$( "#destinationdatepicker" ).datepicker();
} );





$(document).ready(function() {
    $('.get-quotes-btn, .book-ticket-btn').click(function(event) {
        event.preventDefault(); // Prevent form submission

        // Get form inputs
        var from = $('#toDestination').val();
        var to = $('#toDestination').val();
        var departureDate = $('#departureDate').val();
        var arrivalDate = $('#arrivalDate').val();
        var selectedClass = $('#classSelection').val();

        // Check for empty fields
        if (!from || !to || !departureDate || !arrivalDate || !selectedClass) {
            Swal.fire({
                title: 'Error',
                text: 'Please fill in all fields.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Exit function if any field is empty
        }

        // Convert date strings to Date objects for comparison
        var departureDateObj = new Date(departureDate);
        var arrivalDateObj = new Date(arrivalDate);
        var today = new Date();

        // Check if departure date is before today
        if (departureDateObj < today) {
            Swal.fire({
                title: 'Error',
                text: 'Departure date cannot be before today.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Exit function if departure date is invalid
        }

        // Check if arrival date is before departure date
        if (arrivalDateObj < departureDateObj) {
            Swal.fire({
                title: 'Error',
                text: 'Arrival date cannot be before departure date.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            return; // Exit function if arrival date is invalid
        }

        // Fetch and display prices
        $.ajax({
            url: '../includes/get_pricesx.php',
            method: 'POST',
            data: {
                from: from,
                to: to,
                class: selectedClass
            },
            success: function(response) {
                console.log("Response:", response);
                $('#quoteFrom').text(response.from_destination_name);
                $('#quoteTo').text(response.to_destination_name);
                $('#quoteDeparture').text(departureDate);
                $('#quoteArrival').text(arrivalDate);
                $('#basePrice').text(parseFloat(response.base_price).toFixed(2));
                $('#tax').text(parseFloat(response.tax).toFixed(2));
                $('#totalPrice').text(response.total_price.toFixed(2));
                
                // Show the trip details container, if it's initially hidden
                $('.trip-detail-container').show();
            },
            error: function(xhr, status, error) {
                console.error("Error fetching prices:", error);
            }
        });
    });
});
