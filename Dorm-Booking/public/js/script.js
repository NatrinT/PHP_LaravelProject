// public/js/script.js
flatpickr("#dateRangePicker", {
    mode: "range",
    dateFormat: "d/m/Y",
    locale: "th",
    minDate: "today",
});

document.addEventListener("scroll", function () {
    const navbar = document.querySelector(".navbar-style");
    if (window.scrollY > 50) {
        // ถ้าเลื่อนเกิน 50px
        navbar.classList.add("navbar-scrolled");
    } else {
        navbar.classList.remove("navbar-scrolled");
    }
});
