// public/js/script.js

document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab-menu");

    tabs.forEach((item) => {
        item.addEventListener("click", () => {
            tabs.forEach((tab) => tab.classList.remove("active")); // ลบ active ออกจากทุกอัน
            item.classList.add("active"); // ใส่ active อันที่กด
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".type-hotel");

    tabs.forEach((item) => {
        item.addEventListener("click", () => {
            tabs.forEach((tab) => tab.classList.remove("active")); // ลบ active ออกจากทุกอัน
            item.classList.add("active"); // ใส่ active อันที่กด
        });
    });
});

flatpickr("#dateRangePicker", {
    mode: "range",
    dateFormat: "d/m/Y",
    locale: "th",
    minDate: "today", // ป้องกันการเลือกวันที่ผ่านมาแล้ว
});
