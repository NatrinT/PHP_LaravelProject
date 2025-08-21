# 🏢 ระบบจองหอพัก (Dorm Booking System)

[![PHP](https://img.shields.io/badge/PHP-8+-purple?logo=php)](#)
[![Laravel](https://img.shields.io/badge/Laravel-10-red?logo=laravel)](#)
[![MySQL](https://img.shields.io/badge/Database-MySQL-orange?logo=mysql)](#)
[![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)](#)
[![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)](#)
[![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-yellow?logo=javascript)](#)
[![Blade](https://img.shields.io/badge/Blade-Templating-lightblue)](#)
[![License](https://img.shields.io/badge/License-MIT-lightgrey)](#)

> โครงการเพื่อรายวิชา **MTE-456 Web Development for Online Business** ภาคการศึกษา **1/2568**
> คณะเทคโนโลยีสารสนเทศ สถาบันเทคโนโลยีไทย-ญี่ปุ่น

---

## 🎯 วัตถุประสงค์

* อำนวยความสะดวกในการจัดการหอพัก (สมาชิก ห้องพัก สัญญา ใบแจ้งหนี้)
* ลดความผิดพลาดในการคำนวณค่าเช่า
* รองรับการชำระเงินออนไลน์
* รวมศูนย์ข้อมูลสัญญา การเงิน และประกาศ

## 📦 ขอบเขตระบบ

* **Member Portal**: สมัคร/เข้าสู่ระบบ, ดูสัญญา, ใบแจ้งหนี้, ชำระเงิน, ข่าวสาร
* **Admin Dashboard**: จัดการสมาชิก ห้องพัก สัญญา ใบแจ้งหนี้ การเงิน และประกาศ

## 👥 ผู้ใช้หลัก

* **Admin**: จัดการทุกอย่าง
* **Member**: ดูข้อมูล/ชำระเงิน/อ่านประกาศ
* **Staff**: สิทธิเฉพาะบางส่วน เช่น จัดการห้อง

## 🛠️ การติดตั้ง

```bash
# Clone โปรเจกต์
git clone https://github.com/NatrinT/PHP_LaravelProject.git
cd dorm-booking-system


# ติดตั้ง dependencies
composer install
npm install && npm run build


# ตั้งค่า environment
cp .env.example .env
php artisan key:generate


# รันระบบ
php artisan serve
```

* Backend + Frontend: http://localhost:8000

---

## 👨‍💻 ผู้จัดทำ

* 2213110022 นายภูดิศ โชติช่วง
* 2213110436 นายชิตวร คีรีเอกสถิต
* 2213110451 นายณตฤณ ทองวิชิต

---

## 📜 License

MIT



