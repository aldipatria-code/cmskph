# 📰 WartaKita - Citizen Journalism Portal

**WartaKita** adalah platform portal berita berbasis komunitas (_citizen journalism_) yang dirancang untuk menjadi SEO-friendly, interaktif, dan memiliki alur kerja redaksional yang solid. Proyek ini dibangun menggunakan **Laravel** dan **Filament** untuk memberikan pengalaman manajemen konten yang modern dan cepat.

---

## ✨ Fitur Utama

- **SEO Optimized**: Meta title, meta description, dan slug otomatis untuk setiap artikel.
- **Role-Based Access Control (RBAC)**: Menggunakan `spatie/laravel-permission` dengan 3 role utama:
    - **Administrator**: Mengelola user, verifikasi penulis, dan kontrol penuh website.
    - **Redaktur**: Mengelola kategori, tag, dan melakukan moderasi/review artikel (Approve/Reject).
    - **Penulis**: Masyarakat umum yang terverifikasi untuk berbagi cerita/berita.
- **Redactor Workflow**: Alur penulisan mulai dari `Draft` -> `Pending Review` -> `Published/Rejected`.
- **Citizen Interaction**: Sistem komentar pada setiap berita untuk meningkatkan keterlibatan pembaca.
- **Modern Dashboard**: Panel admin yang intuitif menggunakan Filament.
