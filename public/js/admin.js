document.addEventListener("DOMContentLoaded", function() {

  
  // Function to hide users and destinations sections and show flights section
  function showFlightsSection() {
    document.getElementById('flightsSection').style.display = 'block';
    document.getElementById('usersSection').style.display = 'none';
    document.getElementById('destinationsSection').style.display = 'none';
  }

  // Show flights section by default
  showFlightsSection();

  // JavaScript for toggling sections
  document.getElementById('flightsBtn').addEventListener('click', showFlightsSection);

  document.getElementById('usersBtn').addEventListener('click', function() {
    document.getElementById('flightsSection').style.display = 'none';
    document.getElementById('usersSection').style.display = 'block';
    document.getElementById('destinationsSection').style.display = 'none';
  });

  document.getElementById('destinationsBtn').addEventListener('click', function() {
    document.getElementById('flightsSection').style.display = 'none';
    document.getElementById('usersSection').style.display = 'none';
    document.getElementById('destinationsSection').style.display = 'block';
  });
});

// Get the modal element
var modal = document.getElementById('addFlightModal');

// Get the button that opens the modal
var addFlightButton = document.getElementById('addFlightButton');

// Get the cancel button inside the modal
var cancelButton = document.getElementById('cancelButton');

// When the user clicks the add flight button, show the modal
addFlightButton.onclick = function() {
    modal.style.display = 'block';
}

// When the user clicks on cancel, close the modal
cancelButton.onclick = function() {
    closeModal();
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        closeModal();
    }
}

// Function to close the modal
function closeModal() {
    modal.style.display = 'none';
}
