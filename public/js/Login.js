const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");
const images = document.querySelectorAll(".image");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

toggle_btn.forEach((btn) => {
  btn.addEventListener("click", () => {
    main.classList.toggle("sign-up-mode");
  });
});

function moveSlider() {
  let index = this.dataset.value;

  let currentImage = document.querySelector(`.img-${index}`);
  images.forEach((img) => img.classList.remove("show"));
  currentImage.classList.add("show");

  const textSlider = document.querySelector(".text-group");
  textSlider.style.transform = `translateY(${-(index - 1) * 2.2}rem)`;

  bullets.forEach((bull) => bull.classList.remove("active"));
  this.classList.add("active");
}

bullets.forEach((bullet) => {
  bullet.addEventListener("click", moveSlider);
});












const signInForm = document.querySelector(".sign-in-form");
const signUpForm = document.querySelector(".sign-up-form");
const toast = document.querySelector(".toast");
const closeIcon = document.querySelector(".close");
const progress = document.querySelector(".progress");

let timer1, timer2;

// Regular expression for email format
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Regular expression for password strength (at least 8 characters, at least one uppercase letter, one lowercase letter, one number, and one special character)
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$/;

function showToast(message, isSuccess) {
    toast.classList.add("active");
    progress.classList.add("active");
    toast.querySelector(".message .text-1").textContent = isSuccess ? "Success!" : "Error!";
    toast.querySelector(".message .text-2").textContent = message;

    timer1 = setTimeout(() => {
        toast.classList.remove("active");
    }, 5000); // 1s = 1000 milliseconds

    timer2 = setTimeout(() => {
        progress.classList.remove("active");
    }, 5300);
}

function clearToast() {
    toast.classList.remove("active");
    setTimeout(() => {
        progress.classList.remove("active");
    }, 300);
    clearTimeout(timer1);
    clearTimeout(timer2);
}

signInForm.addEventListener("submit", (e) => {
    e.preventDefault();
    // Perform validation
    const email = signInForm.querySelector('input[type="email"]').value.trim();
    const password = signInForm.querySelector('input[type="password"]').value.trim();

    if (!emailRegex.test(email)) {
        showToast("Please enter a valid email address.", false);
        return;
    }

    if (password === "") {
        showToast("Please enter your password.", false);
        return;
    }

    if (!passwordRegex.test(password)) {
        showToast("Invalid password format", false);
        return;
    }

    // If all validations pass, you can show success message
    showToast("Sign in successful!", true);
    signInForm.submit();

});

const restCountriesAPI = 'https://restcountries.com/v3.1/all';

signUpForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    // Perform validation
    const firstName = signUpForm.querySelector('input[name="first_name"]').value.trim();
    const lastName = signUpForm.querySelector('input[name="last_name"]').value.trim();
    const email = signUpForm.querySelector('input[type="email"]').value.trim();
    const password = signUpForm.querySelector('input[type="password"]').value.trim();
    const dob = new Date(signUpForm.querySelector('input[type="date"]').value.trim());
    const mobileNumber = signUpForm.querySelector('input[type="tel"]').value.trim();
    const country = signUpForm.querySelector('input[name="country"]').value.trim();
    const emailRegex = /^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/i;

    if (firstName === "" || lastName === "" || email === "" || password === "" || dob === "" || mobileNumber === "" || country === "") {
        showToast("Please fill in all fields.", false);
        return;
    }

    if (!emailRegex.test(email)) {
        showToast("Please enter a valid email address.", false);
        return;
    }

    if (!passwordRegex.test(password)) {
        showToast("Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.", false);
        return;
    }

    // Validate date of birth
    const currentDate = new Date();
    if (dob >= currentDate) {
        showToast("Date of birth cannot be in the future.", false);
        return;
    }

    // Validate phone number format
    // Assuming mobile number includes country code, for example: +1234567890
    const phoneRegex = /^(\+?\d{1,3}[- ]?)?(0?\d{10}|\(\d{3}\)[- ]?\d{3}[- ]?\d{4}|\+\d{1,3}[- ]?\d{3}[- ]?\d{3}[- ]?\d{4})$/;        if (!phoneRegex.test(mobileNumber)) {
        showToast("Please enter a valid phone number with country code.", false);
        return;
    }

    // Check if the country exists using an external API
    try {
        const response = await fetch(restCountriesAPI);
        if (!response.ok) {
            throw new Error('Failed to fetch country data');
        }
        const countries = await response.json();
        const countryExists = countries.some((c) => c.name.common.toLowerCase() === country.toLowerCase());
        if (!countryExists) {
            throw new Error('Country not found');
        }
        // If all validations pass and the country exists, you can submit the form
        signUpForm.submit();
        showToast("Sign up successful!", true);
    } catch (error) {
        showToast("Please enter a valid country.", false);
        return;
    }
});

closeIcon.addEventListener("click", clearToast);
