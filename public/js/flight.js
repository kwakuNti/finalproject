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
            url: '../includes/get_prices.php',
            method: 'POST',
            data: {
                to: to,
                class: selectedClass
            },
            success: function(prices) {
                console.log("Prices:", prices);
                // Update UI with fetched prices
                $('#basePrice').text(prices.base_price);
                // Calculate tax and total price based on base price
                var tax = prices.base_price * 0.1;
                var totalPrice = prices.base_price + tax;
                $('#tax').text(tax);
                $('#totalPrice').text(totalPrice);
            },
            error: function(xhr, status, error) {
                console.error("Error fetching prices:", error);
            }
        });

        // Populate form details in the appropriate section
// Populate form details in the appropriate section
$('#quoteFrom').text(prices.from_destination_name); // Use from destination name
$('#quoteTo').text(prices.to_destination_name); // Use to destination name
$('#quoteDeparture').text(departureDate);
$('#quoteArrival').text(arrivalDate);


        // Show the trip details container
        $('.trip-detail-container').show();
    });
});
