$(document).ready(function () {
    $('#oneWayButton').click(function () {
        $(this).addClass('active');
        $('#roundTripButton').removeClass('active');
        $('#oneWayForm').show();
        $('#roundTripForm').hide();
        $('#oneWayTripDetails').show();
        $('#roundTripDetails').hide();
    });

    $('#roundTripButton').click(function () {
        $(this).addClass('active');
        $('#oneWayButton').removeClass('active');
        $('#oneWayForm').hide();
        $('#roundTripForm').show();
        $('#oneWayTripDetails').hide();
        $('#roundTripDetails').show();
    });

    // Go back button functionality
    $('.btn').click(function() {
        window.location.href = '../templates/dashboard.php';
    });
});

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
