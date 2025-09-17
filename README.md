# 🏠 Home Tutor Consultancy Platform

A Laravel-based platform that connects students and parents with verified, qualified home tutors. The system ensures **safety, affordability, transparency, and personalized learning** while enabling hybrid (offline + online) support.

---

## 📌 Overview

The platform addresses the challenges faced by families in small towns who struggle to access quality tutoring. It ensures **verified tutors, progress tracking, and secure payments** while supporting **exam preparation (Boards, JEE, NEET, CUET)**.

---

## 🚀 Features

### 👩‍🎓 Student & Parent Side
- 🔍 **Tutor Discovery & Booking** – Search by subject, class, location, and pricing.
- 📅 **Scheduling** – Book, reschedule, or cancel sessions.
- ✅ **Verified Tutors** – Profiles with verification badges, reviews & ratings.
- 💳 **Payments & Subscriptions** – Hourly, monthly, or package-based.
- 📊 **Progress Tracking** – Attendance, reports, and parent dashboard.
- 📚 **Hybrid Learning** – Digital resources (notes, PDFs, recorded lessons).

### 👨‍🏫 Tutor Side
- 📝 **Onboarding & Verification** – KYC, police verification, qualification check.
- 🧑‍💻 **Profile Management** – Subjects, classes, availability, pricing.
- 📅 **Session Management** – Calendar, attendance tracking, student notes.
- 💰 **Earnings Dashboard** – Payments, dues, and bonuses.

### 🛠️ Admin Side
- 👥 **Tutor Management** – Approve/verify tutors, monitor performance.
- 👩‍👦 **Student Management** – Track progress, resolve mismatches.
- 📈 **Reports & Analytics** – Revenue, growth, and performance metrics.

---

## 🧑‍💻 Tech Stack

- **Backend:** Laravel 10 (PHP)
- **Frontend:** Blade / TailwindCSS (extendable to Vue/React)
- **Database:** MySQL / PostgreSQL
- **Authentication:** Laravel Breeze / Fortify
- **Payments:** Razorpay / Stripe / UPI
- **Deployment:** Laravel Forge / Docker / VPS

---

## 📂 Project Structure

```

home-tutor-platform/
├── app/         # Controllers, Models, Middleware
├── database/    # Migrations & Seeders
├── resources/   # Blade templates
├── routes/      # Web & API routes
├── public/      # Public assets
└── README.md    # Project documentation

````

---

## ⚙️ Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/your-org/home-tutor-platform.git
   cd home-tutor-platform
````

2. **Install Dependencies**

   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Setup Environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database**

   * Update `.env` with DB credentials.
   * Run migrations:

     ```bash
     php artisan migrate --seed
     ```

5. **Serve the App**

   ```bash
   php artisan serve
   ```

---

## 📊 Success Metrics (KPIs)

* 🎯 Active students & tutors onboarded
* 📈 % improvement in student performance
* ⭐ Parent satisfaction (NPS)
* 👨‍🏫 Tutor retention rate
* 💵 Monthly recurring revenue (MRR)


## 🤝 Contributing

We welcome contributions!

1. Fork the repo
2. Create a feature branch (`feature/my-feature`)
3. Commit changes (`git commit -m "Add new feature"`)
4. Push to branch
5. Open a Pull Request

---

## 📜 License

This project is licensed under the **MIT License**.
See [LICENSE](LICENSE) for details.

---

```
