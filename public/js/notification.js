const toast = document.querySelector(".toast");
const closeIcon = document.querySelector(".close");
const progress = document.querySelector(".progress");
let timer1, timer2;

function showToast(type, message) {
    const text1 = document.querySelector(".text-1");
    const text2 = document.querySelector(".text-2");

    text1.textContent = type;
    text2.textContent = message;

    toast.classList.add("active");
    progress.classList.add("active");

    timer1 = setTimeout(() => {
        hideToast();
    }, 5000); // 1s = 1000 milliseconds

    timer2 = setTimeout(() => {
        progress.classList.remove("active");
    }, 5300);
}

function hideToast() {
    toast.classList.remove("active");
    setTimeout(() => {
        progress.classList.remove("active");
    }, 300);
    clearTimeout(timer1);
    clearTimeout(timer2);
}

closeIcon.addEventListener("click", () => {
    hideToast();
});