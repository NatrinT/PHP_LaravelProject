// public/js/script.js

document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab-menu");
    const typeHotels = document.querySelectorAll(".type-hotel"); // แก้ชื่อให้ตรง
    const selectTypeRoom = document.getElementById("selectTypeRoom");
    const dropdownContainer = document.getElementById("dropdownContainer");
    const roomInput = document.getElementById("roomInput");
    const dropdownItems = dropdownContainer.querySelectorAll(".dropdown-item");

    let selectedHotel = "หอพักดอร์มศรีนครินทร์"; // เก็บชื่อหอพักที่เลือก
    let roomType = "Standard"; // เก็บชื่อหอพักที่เลือก

    // จัดการ tab menu
    tabs.forEach((item) => {
        item.addEventListener("click", () => {
            tabs.forEach((tab) => tab.classList.remove("active"));
            item.classList.add("active");
        });
    });

    // เลือก type-hotel
    typeHotels.forEach((hotel) => {
        hotel.addEventListener("click", () => {
            typeHotels.forEach((h) => h.classList.remove("active"));
            hotel.classList.add("active");
            selectedHotel = hotel.textContent.trim();
            roomInput.value = roomType
                ? `${roomType} - ${selectedHotel}`
                : selectedHotel;
        });
    });

    // toggle dropdown เมื่อคลิก input
    selectTypeRoom.addEventListener("click", (e) => {
        e.stopPropagation(); // กัน event bubble
        dropdownContainer.style.display =
            dropdownContainer.style.display === "none" ? "block" : "none";
    });

    // เลือกรูปแบบห้อง -> ใส่ค่า + ปิด dropdown
    dropdownItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            roomType = item.textContent.trim();
            roomInput.value = selectedHotel
                ? `${roomType} - ${selectedHotel}`
                : roomType;
            dropdownContainer.style.display = "none";
        });
    });

    // คลิกข้างนอก -> ปิด dropdown
    document.addEventListener("click", (e) => {
        if (
            !selectTypeRoom.contains(e.target) &&
            !dropdownContainer.contains(e.target)
        ) {
            dropdownContainer.style.display = "none";
        }
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
});

// date picker
flatpickr("#dateRangePicker", {
    mode: "range",
    dateFormat: "d/m/Y",
    locale: "th",
    minDate: "today",
});
