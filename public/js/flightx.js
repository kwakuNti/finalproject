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
    $('.get-quotes-btn').click(function(event) {
        event.preventDefault(); // Prevent form submission
        var from = $('#fromDestination').val();
        var to = $('#toDestination').val();
        var departureDate = $('#departureDate').val();
        var arrivalDate = $('#arrivalDate').val();
        var selectedClass = $('#classSelection').val();

        console.log("From: " + from);
        console.log("To: " + to);
        console.log("Departure Date: " + departureDate);
        console.log("Arrival Date: " + arrivalDate);
        console.log("Selected class:", selectedClass);

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

        // Populate form details in the appropriate section
		$('#quoteFrom').text(response.from_destination_name);
		$('#quoteTo').text(response.to_destination_name);
		$('#quoteDeparture').text(departureDate);
        $('#quoteArrival').text(arrivalDate);
		$('#basePrice').text(response.base_price);
		$('#tax').text(response.tax);
		$('#totalPrice').text(response.total_price);


        // Show the trip details container
        // $('.trip-detail-container').show();
    });
});
