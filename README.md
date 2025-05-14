<p align="center">
  <img src="https://mohe.gov.af/sites/default/files/2021-09/my-mohe-logo_e_1_0.png" alt="Jamiat Logo" width="100">
</p>

<h1 align="center">Jamiat Scholar Registration & Exam Management System</h1>

<p align="center">
  A Laravel 10 application for managing scholar registration, exam enrollment, and distribution across exam halls, developed for the Jamiat Directorate.
</p>

<p align="center">
  <a href="https://github.com/MOHE-Systems/jamiat_system">
    <img alt="GitHub Repo" src="https://img.shields.io/badge/source-MOHE--Systems-blue?style=flat-square&logo=github">
  </a>
  <a href="https://laravel.com">
    <img alt="Laravel" src="https://img.shields.io/badge/Laravel-10-red?style=flat-square&logo=laravel">
  </a>
  <a href="https://getbootstrap.com">
    <img alt="Bootstrap" src="https://img.shields.io/badge/Bootstrap-5-blueviolet?style=flat-square&logo=bootstrap">
  </a>
  <a href="https://www.mysql.com/">
    <img alt="MySQL" src="https://img.shields.io/badge/Database-MySQL-orange?style=flat-square&logo=mysql">
  </a>
</p>

---

## 🧾 Overview

The **Jamiat Scholar Registration & Exam Management System** is an internal application designed to manage scholar registrations, exam enrollments, and distribute applicants to exam halls based on their capacity. This system streamlines the entire exam process, from enrollment to result management, making it easy for the Jamiat Directorate to handle large volumes of applicants efficiently.

---

## 📌 Key Features

### ✅ Scholar Registration & Management
- Register scholars for exams
- Assign scholars to specific Madars (schools)
- Generate unique scholar enrollment numbers for exams
- Maintain detailed records for each scholar, including enrollment history

### 📝 Exam Enrollment & Hall Distribution
- Create and manage exams
- Assign scholars to exam halls based on hall capacities
- Dynamic distribution of scholars to exam halls
- Generate and download exam enrollment forms with unique identifiers

### 📊 Exam Results & Reporting
- Track and record exam results
- Generate reports based on exams, schools, and scholar data
- Import/export applicant records through Excel (CSV, XLSX)

### 🏫 Madars (Schools) Management
- Register and maintain records for Madars (schools)
- Link scholars to their respective Madars for easy management

---

## 🧪 TODO

Planned features under active development:

- 📊 **Advanced Report Generation** – Generate complex reports based on various filters (e.g., exam results, scholar performance, Madars).
- 💻 **Online Exam Enrollment** – Web portal for scholars to self-register for exams.
- 🧑‍🏫 **Performance Analytics** – Track scholar performance across different exams and years.
  
---

## 🔐 Access Control

The system uses **role-permission-based authorization** to manage access:

- Admin
- Exam Coordinator
- Madars (School) Manager
- Scholar (view-only in future)

---

## 🛠 Tech Stack

- **Framework:** Laravel 10+
- **Frontend:** Blade, Bootstrap 5, jQuery
- **Database:** MySQL
- **Auth:** Custom login with permission control
- **File Handling:** Excel (via Laravel Excel package)

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL

### Installation

```bash
git clone https://github.com/MOHE-Systems/jamiat_system.git
cd jamiat_system

# Install PHP dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Edit .env and configure your DB credentials

# Import the provided SQL dump
mysql -u root -p jamiat_db < database/jamiat_system.sql

# Serve the app
php artisan serve
