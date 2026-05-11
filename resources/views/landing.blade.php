<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sistem Pengaduan Mahasiswa - Politeknik Caltex Riau</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

    :root {

        --primary: #044389; 

        --border-blue: #9eb5d1;

    }

    html {
        scroll-behavior: smooth;
    }

    *,

    *::before,

    *::after {

        box-sizing: border-box;

        margin: 0;

        padding: 0;

    }

    body {

        font-family: 'Poppins', sans-serif;

        background: #ffffff;

        color: #222;

        font-size: 14px;

    }

    nav {

        background: var(--primary);

        padding: 0 40px;

        height: 70px;

        display: flex;

        align-items: center;

        justify-content: space-between;

    }

    .nav-brand {

        display: inline-flex;

        align-items: center;

        background-color: #ffffff;

        padding: 8px 20px;

        border-radius: 50px;

        text-decoration: none;

    }

    .nav-brand img {

        height: 22px;

        display: block;

    }

    .nav-links {

        display: flex;

        align-items: center;

        gap: 30px;

        list-style: none;

    }

    .nav-links a {

        color: #fff;

        text-decoration: none;

        font-size: 13px;

        font-weight: 500;

        transition: color 0.25s ease;

    }

    .nav-links a:hover {

        color: #dbeafe;

    }

    nav {

        position: sticky;

        top: 0;

        z-index: 99;

        transition: background 0.3s ease, box-shadow 0.3s ease;

    }

    nav.scrolled {

        background: rgba(4, 67, 137, 0.95);

        box-shadow: 0 12px 30px rgba(0,0,0,0.12);

    }

    .btn-login {

        background: #fff;

        color: var(--primary) !important;

        font-size: 13px;

        font-weight: 600;

        padding: 6px 24px;

        border-radius: 20px;

        text-decoration: none;

        transition: transform 0.3s ease, box-shadow 0.3s ease;

    }

    .btn-login:hover {

        transform: translateY(-2px);

        box-shadow: 0 12px 22px rgba(4, 67, 137, 0.2);

    }

    .hero-wrapper {

        background: #fff;

        position: relative;

        overflow: hidden;

    }

    .hero-wrapper::before {

        content: '';

        position: absolute;

        width: 420px;

        height: 420px;

        background: radial-gradient(circle, rgba(4, 67, 137, 0.18), transparent 60%);

        top: -80px;

        right: -110px;

        pointer-events: none;

    }

    .hero-inner {

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 60px;

        padding: 60px 40px;

        max-width: 1000px;

        margin: 0 auto;

    }

    .hero-img {

        width: 400px;

        flex-shrink: 0;

        animation: float 6s ease-in-out infinite;

    }

    .hero-img img {

        width: 100%;

        display: block;

        border-radius: 30px;

        box-shadow: 0 22px 40px rgba(4, 67, 137, 0.12);

    }

    @keyframes float {

        0%, 100% { transform: translateY(0); }

        50% { transform: translateY(-14px); }

    }

    .hero-text {

        max-width: 400px;

    }

    .hero-text h1 {

        font-size: 32px;

        font-weight: 700;

        color: #333;

        line-height: 1.4;

        margin-bottom: 24px;

    }

    .btn-oval {

        display: inline-block;

        background: var(--primary);

        color: #fff;

        font-size: 13px;

        padding: 12px 30px;

        border-radius: 50px;

        text-decoration: none;

        font-weight: 500;

        transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;

    }

    .btn-oval:hover {

        transform: translateY(-3px);

        box-shadow: 0 18px 34px rgba(4, 67, 137, 0.2);

        background: #0b356d;

    }

    .nav-links a.active {

        color: #e2ecff;

        position: relative;

    }

    .nav-links a.active::after {

        content: '';

        position: absolute;

        left: 0;

        bottom: -8px;

        width: 100%;

        height: 2px;

        background: #fff;

        border-radius: 999px;

    }

    .sec-label {

        text-align: center;

        padding: 40px 0 20px;

    }

    .sec-label span {

        display: inline-block;

        background: var(--primary);

        color: #fff;

        font-size: 13px;

        font-weight: 600;

        padding: 10px 40px;

        border-radius: 50px;

    }

    #about {

        background: #ffffff;

        padding-bottom: 40px;

    }

    .card {

        background: #fff;

        border-radius: 20px;

        border: 1px solid var(--border-blue);

        padding: 40px 50px;

        max-width: 800px;

        margin: 0 auto;

    }

    .card p {

        font-size: 13.5px;

        line-height: 1.8;

        color: #333;

        text-align: center;

        margin-bottom: 16px;

    }

    .card p:last-child {

        margin-bottom: 0;

    }

    #tujuan {

        background: #ffffff;

        padding-bottom: 60px;

    }

    .tujuan-card {

        background: #fff;

        border-radius: 20px;

        border: 1px solid var(--border-blue);

        padding: 40px 50px;

        max-width: 800px;

        margin: 0 auto;

        display: flex;

        gap: 40px;

        align-items: center;

    }

    .tujuan-body {

        flex: 1;

    }

    .tujuan-body h3 {

        font-size: 15px;

        font-weight: 700;

        color: #222;

        margin-bottom: 16px;

        text-align: center;

    }

    .tujuan-body p {

        font-size: 13.5px;

        line-height: 1.8;

        color: #333;

        margin-bottom: 14px;

    }

    .tujuan-body p:last-child {

        margin-bottom: 0;

    }

    .tujuan-img {

        flex-shrink: 0;

        width: 250px;

    }

    .tujuan-img img {

        width: 100%;

        display: block;

    }

    footer {

        background: var(--primary);

        color: #fff;

        padding: 40px 80px;

        display: flex;

        justify-content: space-between;

        align-items: flex-start;

        flex-wrap: wrap;

        gap: 20px;

        border-radius: 80px 80px 0 0;

    }

    .f-left {

        font-size: 13px;

        line-height: 1.6;

    }

    .f-row {

        display: flex;

        align-items: flex-start;

        gap: 12px;

        margin-bottom: 12px;

    }

    .f-row i {

        margin-top: 4px;

        font-size: 16px;

    }

    .f-right {

        font-size: 13px;

    }

    .f-right .f-title {

        display: block;

        font-weight: 700;

        color: #fff;

        margin-bottom: 14px;

        font-size: 13px;

    }

    .socials {

        display: flex;

        gap: 10px;

    }

    .s-btn {

        width: 32px;

        height: 32px;

        border-radius: 50%;

        background: transparent;

        display: flex;

        align-items: center;

        justify-content: center;

        color: #fff;

        text-decoration: none;

    }

    .s-btn i {

        font-size: 18px;

    }

    /* Panduan Section */
    #panduan {
        background: #f8fafc;
        padding: 80px 40px 100px;
    }

    .panduan-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .panduan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .panduan-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px 30px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        opacity: 0;
        transform: translateY(20px);
    }

    .panduan-card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .panduan-card:hover {
        border-color: var(--primary);
        box-shadow: 0 10px 30px rgba(4, 67, 137, 0.1);
        transform: translateY(-5px);
    }

    .panduan-icon {
        font-size: 48px;
        color: var(--primary);
        margin-bottom: 20px;
        display: block;
    }

    .panduan-title {
        font-size: 16px;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .panduan-desc {
        font-size: 13px;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 768px) {
        #panduan {
            padding: 60px 20px 80px;
        }

        .panduan-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .panduan-card {
            padding: 30px 20px;
        }

        .panduan-icon {
            font-size: 36px;
        }

        .panduan-title {
            font-size: 14px;
        }

        .panduan-desc {
            font-size: 12px;
        }

        .hero-inner {

            flex-direction: column;

            text-align: center;

        }

        .hero-text {

            max-width: 100%;

        }

        .tujuan-card {

            flex-direction: column;

            text-align: center;

        }

        .tujuan-img {

            width: 80%;

            margin: 0 auto;

        }

        footer {

            flex-direction: column;

            border-radius: 40px 40px 0 0;

            padding: 30px 40px;

        }

    }

    </style>

</head>

<body>

    <nav>

        <a href="#hero" class="nav-brand">

            <img src="{{ asset('images/logo.png') }}" alt="Politeknik Caltex Riau">

        </a>

        <ul class="nav-links">

            <li><a href="#hero">Home</a></li>

            <li><a href="#about">About</a></li>

            <li><a href="#tujuan">Tujuan &amp; Manfaat</a></li>

            <li><a href="#panduan">Panduan</a></li>

            <li><a href="#kontak">Kontak</a></li>

            <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>

        </ul>

    </nav>

    <div class="hero-wrapper" id="hero">

        <div class="hero-inner fade-up">

            <div class="hero-img">

                <img src="{{ asset('images/landing1.png') }}" alt="Ilustrasi Pengaduan">

            </div>

            <div class="hero-text">

                <h1>Sistem Pengaduan<br>Mahasiswa Berbasis Web</h1>

                <a href="#about" class="btn-oval">Selengkapnya &rarr;</a>

            </div>

        </div>

    </div>

    <section id="panduan">

        <div class="sec-label"><span>Tata Cara Menulis Laporan</span></div>

        <div class="panduan-container">

            <div class="panduan-grid">

                <div class="panduan-card">

                    <i class="fa-solid fa-comments panduan-icon"></i>

                    <h3 class="panduan-title">Gunakan Bahasa yang Sopan dan Jelas</h3>

                    <p class="panduan-desc">Sampaikan pengaduan menggunakan bahasa yang baik, mudah dipahami, dan tidak mengandung unsur penghinaan maupun provokasi.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-list-check panduan-icon"></i>

                    <h3 class="panduan-title">Jelaskan Permasalahan Secara Detail</h3>

                    <p class="panduan-desc">Tuliskan kronologi kejadian secara lengkap, seperti apa yang terjadi, kapan terjadi, dan bagaimana permasalahan tersebut berlangsung.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-map-pin panduan-icon"></i>

                    <h3 class="panduan-title">Sertakan Informasi Pendukung</h3>

                    <p class="panduan-desc">Tambahkan informasi seperti lokasi kejadian, unit terkait, atau pihak yang terlibat agar laporan lebih mudah diproses.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-bolt panduan-icon"></i>

                    <h3 class="panduan-title">Pilih Tingkat Urgensi dengan Tepat</h3>

                    <p class="panduan-desc">Gunakan tingkat urgensi sesuai kondisi sebenarnya agar sistem dapat membantu memprioritaskan penanganan laporan.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-check-circle panduan-icon"></i>

                    <h3 class="panduan-title">Pastikan Laporan Sesuai Fakta</h3>

                    <p class="panduan-desc">Pengaduan yang disampaikan harus berdasarkan kondisi nyata dan dapat dipertanggungjawabkan.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-ban panduan-icon"></i>

                    <h3 class="panduan-title">Hindari Laporan Duplikat atau Spam</h3>

                    <p class="panduan-desc">Pastikan Anda tidak mengirim laporan yang sama secara berulang agar proses pengelolaan pengaduan tetap efektif.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-eye panduan-icon"></i>

                    <h3 class="panduan-title">Pantau Status Pengaduan Berkala</h3>

                    <p class="panduan-desc">Setelah laporan dikirim, Anda dapat memantau perkembangan dan tanggapan melalui sistem pengaduan.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-image panduan-icon"></i>

                    <h3 class="panduan-title">Lampirkan Bukti Pendukung</h3>

                    <p class="panduan-desc">Tambahkan foto atau dokumen pendukung agar laporan lebih valid dan memudahkan proses verifikasi oleh pihak terkait.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-handshake panduan-icon"></i>

                    <h3 class="panduan-title">Bersama Tingkatkan Kualitas Layanan</h3>

                    <p class="panduan-desc">Setiap laporan yang disampaikan akan membantu menciptakan lingkungan kampus yang lebih nyaman, responsif, dan berkualitas.</p>

                </div>

            </div>

        </div>

    </section>

    <section id="about">

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-image panduan-icon"></i>

                    <h3 class="panduan-title">Lampirkan Bukti Pendukung</h3>

                    <p class="panduan-desc">Tambahkan foto atau dokumen pendukung agar laporan lebih valid dan memudahkan proses verifikasi oleh pihak terkait.</p>

                </div>

                <div class="panduan-card">

                    <i class="fa-solid fa-handshake panduan-icon"></i>

                    <h3 class="panduan-title">Bersama Tingkatkan Kualitas Layanan</h3>

                    <p class="panduan-desc">Setiap laporan yang disampaikan akan membantu menciptakan lingkungan kampus yang lebih nyaman, responsif, dan berkualitas.</p>

                </div>

            </div>

        </div>

    </section>

    <section id="about">

        <div class="sec-label"><span>About</span></div>

        <div class="card fade-up">

            <p>Sistem Pengaduan Mahasiswa Berbasis Web Politeknik Caltex Riau merupakan platform digital yang dirancang

                untuk memfasilitasi mahasiswa dalam menyampaikan berbagai keluhan, saran, atau masukan terkait layanan

                akademik dan non-akademik secara lebih cepat, transparan, dan terdokumentasi.</p>

            <p>Melalui sistem ini, mahasiswa dapat mengajukan pengaduan secara langsung kepada unit layanan yang

                berwenang tanpa harus melalui proses manual seperti perantara dosen wali atau forum evaluasi akhir

                semester. Setiap pengaduan yang dikirim akan otomatis tercatat dalam sistem, diteruskan ke pihak

                terkait, dan dapat dipantau perkembangannya secara real-time oleh mahasiswa.</p>

        </div>

    </section>

    <section id="tujuan">

        <div class="sec-label"><span>Tujuan &amp; Manfaat</span></div>

        <div class="tujuan-card fade-up">

            <div class="tujuan-body">

                <h3>Sampaikan aspirasi tanpa batas!</h3>

                <p>Sistem Pengaduan Mahasiswa Berbasis Web Politeknik Caltex Riau hadir untuk membantu mahasiswa

                    menyampaikan keluhan, saran, dan masukan dengan lebih cepat, transparan, dan mudah dipantau.</p>

                <p>Dengan dukungan konsep CRM-IDIC (Identify, Differentiate, Interact, Customize), setiap aduan akan

                    diteruskan ke unit terkait secara otomatis dan terdokumentasi dengan aman. Tidak ada lagi laporan

                    yang hilang atau respons yang terlambat — semuanya terkelola dalam satu sistem terpadu.</p>

                <p>Melalui sistem ini, PCR berkomitmen menghadirkan layanan akademik yang responsif, efisien, dan

                    berorientasi pada kebutuhan mahasiswa.</p>

            </div>

            <div class="tujuan-img">

                <img src="{{ asset('images/landing2.png') }}" alt="Ilustrasi Tujuan">

            </div>

        </div>

    </section>

    <footer id="kontak">

        <div class="f-left">

            <div class="f-row">

                <i class="fa-solid fa-location-dot"></i>

                <span>Jl. Umban Sari No.1, Umban Sari, Kec. Rumbai,<br>Kota Pekanbaru, Riau 28265</span>

            </div>

            <div class="f-row">

                <i class="fa-solid fa-phone"></i>

                <span>076153938 / 0811 758 0101</span>

            </div>

        </div>

        <div class="f-right">

            <span class="f-title">MEDIA SOSIAL</span>

            <div class="socials">

                <a href="{{ $socialLinks['instagram'] ?? '#' }}" class="s-btn" title="Instagram" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-instagram"></i></a>

                <a href="{{ $socialLinks['youtube'] ?? '#' }}" class="s-btn" title="YouTube" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-youtube"></i></a>

                <a href="{{ $socialLinks['twitter'] ?? '#' }}" class="s-btn" title="Twitter" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-twitter"></i></a>

                <a href="{{ $socialLinks['google'] ?? '#' }}" class="s-btn" title="Website PCR" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-google-plus-g"></i></a>

            </div>

        </div>

    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.querySelector('nav');
            const sections = document.querySelectorAll('section[id], #hero');
            const navLinks = document.querySelectorAll('.nav-links a[href^="#"]');

            window.addEventListener('scroll', function() {
                nav.classList.toggle('scrolled', window.scrollY > 20);
                updateActiveLink();
            });

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });

            document.querySelectorAll('.fade-up, .panduan-card').forEach(function(element) {
                observer.observe(element);
            });

            const updateActiveLink = function() {
                let currentId = '#hero';
                sections.forEach(function(section) {
                    const top = section.getBoundingClientRect().top;
                    if (top <= window.innerHeight * 0.3) {
                        currentId = section.id ? '#' + section.id : '#hero';
                    }
                });

                navLinks.forEach(function(link) {
                    link.classList.toggle('active', link.getAttribute('href') === currentId);
                });
            };

            updateActiveLink();
        });
    </script>

</body>

</html>