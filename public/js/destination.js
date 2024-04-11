const searchInput = document.getElementById("searchInput");
const countryCards = document.querySelectorAll(".country__card");
const header = document.querySelector("header");
const journeyContainer = document.querySelector(".journey__container");

searchInput.addEventListener("input", () => {
  if (searchInput.value.trim() !== "") {
    header.classList.add("search-active");
    journeyContainer.classList.add("show");
    filterCountries();
  } else {
    header.classList.remove("search-active");
    journeyContainer.classList.remove("show");
    resetCountryCards();
  }
});

// Function to filter the country cards based on the search input
function filterCountries() {
  const searchTerm = searchInput.value.toLowerCase();

  countryCards.forEach((card) => {
    const countryName = card
      .querySelector(".country__name span")
      .textContent.toLowerCase();

    if (countryName.includes(searchTerm)) {
      card.style.display = "block";
    } else {
      card.style.display = "none";
    }
  });
}

// Function to reset the display of all country cards
function resetCountryCards() {
  countryCards.forEach((card) => {
    card.style.display = "block";
  });
}


   // Get the button element
   const bookNowBtn = document.getElementById('bookNowBtn');

   // Add click event listener
   bookNowBtn.addEventListener('click', function() {
       // Prompt the user to choose between one-way and round-trip using SweetAlert
       Swal.fire({
           title: 'Choose your trip type',
           input: 'select',
           inputOptions: {
               'one-way': 'One-Way',
               'round-trip': 'Round-Trip'
           },
           inputPlaceholder: 'Select trip type',
           showCancelButton: true,
           cancelButtonText: 'Cancel',
           inputValidator: (value) => {
               if (!value) {
                   return 'You need to choose a trip type';
               }
           },
           customClass: {
            popup: 'custom-swal-popup'
        }
       }).then((result) => {
           // If user selects One-Way
           if (result.value === 'one-way') {
               // Redirect to flight.php for one-way flight
               window.location.href = '../templates/flight.php';
           }
           // If user selects Round-Trip
           else if (result.value === 'round-trip') {
               // Redirect to roundtrip.php for round-trip flight
               window.location.href = '../templates/roundtrip.php';
           }
       });
   });