$(document).ready(function () {
    $('#oneWayButton').click(function () {
        console.log("One-way button clicked");
        $(this).addClass('active');
        $('#roundTripButton').removeClass('active');
        $('#oneWayForm').show();
        $('#roundTripForm').hide();
        $('#oneWayTripDetails').show();
        $('#roundTripDetails').hide();
    });

    $('#roundTripButton').click(function () {
        console.log("Round-trip button clicked");
        $(this).addClass('active');
        $('#oneWayButton').removeClass('active');
        $('#oneWayForm').hide();
        $('#roundTripForm').show();
        $('#oneWayTripDetails').hide();
        $('#roundTripDetails').show();
    });

    // Go back button functionality
    $('.btn').click(function() {
        console.log("Go back button clicked");
        window.location.href = '../templates/dashboard.php';
    });

    // Form submission based on active form
    $('.book-flights-btn').click(function(event) {
        event.preventDefault(); // Prevent form submission
        var formAction;
        if ($('#oneWayButton').hasClass('active')) {
            console.log("Submitting one-way form");
            formAction = 'oneway.php';
            $('#oneWayForm').attr('action', formAction);
            $('#oneWayForm').submit();
        } else if ($('#roundTripButton').hasClass('active')) {
            console.log("Submitting round-trip form");
            formAction = 'roundtrip.php';
            $('#roundTripForm').attr('action', formAction);
            $('#roundTripForm').submit();
        } else {
            console.log("Error: No form is active.");
        }
        return false; // Stop event propagation
    });

    // Get Quotes button functionality
    $('.get-quotes-btn').click(function(event) {
        event.preventDefault(); // Prevent form submission
        var from = $('#fromDestination').val();
        var to = $('#toDestination').val();
        var departureDate = $('#departureDate').val();
        var arrivalDate = $('#arrivalDate').val();
        
        console.log("From: " + from);
        console.log("To: " + to);
        console.log("Departure Date: " + departureDate);
        console.log("Arrival Date: " + arrivalDate);

        // Populate form details in the appropriate section
        if ($('#oneWayButton').hasClass('active')) {
            $('#oneWayTripDetails #quoteFrom').text(from);
            $('#oneWayTripDetails #quoteTo').text(to);
            $('#oneWayTripDetails #quoteDeparture').text(departureDate);
            $('#oneWayTripDetails #quoteArrival').text(arrivalDate);
        } else if ($('#roundTripButton').hasClass('active')) {
            $('#roundTripDetails #destination').text(to);
            $('#roundTripDetails #quoteDeparture').text(departureDate);
            $('#roundTripDetails #quoteArrival').text(arrivalDate);
        }

        // Show the form details container
        $('.trip-detail-container').show();
    });

    // Debugging for select and option elements
    const select = document.querySelectorAll('.selectBtn');
    const option = document.querySelectorAll('.option');
    let index = 1;

    select.forEach(a => {
        a.addEventListener('click', b => {
            console.log("Select button clicked");
            const next = b.target.nextElementSibling;
            next.classList.toggle('toggle');
            next.style.zIndex = index++;
        })
    })
    option.forEach(a => {
        a.addEventListener('click', b => { 
            console.log("Option selected");
            b.target.parentElement.classList.remove('toggle');
            const parent = b.target.closest('.select').children[0];

            // Retrieve the data-type and data-name attributes of the selected option
            const dataType = b.target.getAttribute('data-type');
            const dataName = b.target.getAttribute('data-name');

            // Set the data-type and data-name attributes of the parent element
            parent.setAttribute('data-type', dataType);
            parent.setAttribute('data-name', dataName);

            // Update the innerHTML of the parent element with the data-name attribute
            parent.innerHTML = dataName;

            // If the parent element has an id of 'fromDestination' or 'toDestination',
            // update the corresponding input field value
            if (parent.id === 'fromDestination') {
                $('#fromDestination').val(dataName);
            } else if (parent.id === 'toDestination') {
                $('#toDestination').val(dataName);
            }
        })
    });

    // Datepicker debugging
    $( function() {
        console.log("Initializing datepicker");
        $( "#sourcedatepicker" ).datepicker();
        $( "#destinationdatepicker" ).datepicker();
    });

});
