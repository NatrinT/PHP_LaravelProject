// public/js/script.js

document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab-menu");
    const tabs2 = document.querySelectorAll(".type-hotel");
    const selectTypeRoom = document.getElementById("selectTypeRoom");
    const dropdownContainer = document.getElementById("dropdownContainer");
    const roomInput = document.getElementById("roomInput");

    // จัดการ tab menu
    tabs.forEach((item) => {
        item.addEventListener("click", () => {
            tabs.forEach((tab) => tab.classList.remove("active"));
            item.classList.add("active");
        });
    });

    tabs2.forEach((item) => {
        item.addEventListener("click", () => {
            tabs2.forEach((tab) => tab.classList.remove("active"));
            item.classList.add("active");
        });
    });

    // toggle dropdown ตอนคลิก input
    selectTypeRoom.addEventListener("click", () => {
        dropdownContainer.style.display =
            dropdownContainer.style.display === "none" ? "block" : "none";
    });

    // เลือก option -> ใส่ค่า + ปิด dropdown
    dropdownContainer.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation(); // 🔴 กันไม่ให้ event bubble ไปที่ selectTypeRoom
            roomInput.value = item.textContent + " Room";
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
});

flatpickr("#dateRangePicker", {
    mode: "range",
    dateFormat: "d/m/Y",
    locale: "th",
    minDate: "today", // ป้องกันการเลือกวันที่ผ่านมาแล้ว
});
