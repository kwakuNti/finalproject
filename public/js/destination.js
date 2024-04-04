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