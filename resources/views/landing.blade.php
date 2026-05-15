<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Mahasiswa - Politeknik Caltex Riau</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    :root {
        --primary: #044389; 
        --primary-dark: #03366f;
        --border-blue: #9eb5d1;
        --text-main: #1e293b;
        --text-muted: #475569;
        --bg-light: #f8fafc;
        --shadow-sm: 0 4px 6px -1px rgba(4, 67, 137, 0.05);
        --shadow-md: 0 10px 15px -3px rgba(4, 67, 137, 0.08);
        --shadow-lg: 0 20px 25px -5px rgba(4, 67, 137, 0.1);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    html { scroll-behavior: smooth; }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Poppins', sans-serif;
        background: #ffffff;
        color: var(--text-main);
        font-size: 15px;
        line-height: 1.7;
        overflow-x: hidden;
    }

    /* Navigation */
    nav {
        background: var(--primary);
        padding: 0 5%;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: var(--transition);
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }

    nav.scrolled {
        background: rgba(4, 67, 137, 0.95);
        backdrop-filter: blur(10px);
        height: 65px;
    }

    .nav-brand {
        background: #ffffff;
        padding: 8px 20px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        transition: var(--transition);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .nav-brand img { height: 22px; display: block; }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 30px;
        list-style: none;
    }

    .nav-links a {
        color: rgba(255, 255, 255, 0.85);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: var(--transition);
        position: relative;
    }

    .nav-links a:not(.btn-login)::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 0;
        height: 2px;
        background: #ffffff;
        transition: var(--transition);
        border-radius: 2px;
    }

    .nav-links a:hover { color: #ffffff; }
    .nav-links a:not(.btn-login):hover::after,
    .nav-links a.active::after { width: 100%; }

    .btn-login {
        background: #ffffff;
        color: var(--primary) !important;
        padding: 8px 24px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .mobile-toggle {
        display: none;
        background: none;
        border: none;
        color: #ffffff;
        font-size: 24px;
        cursor: pointer;
        z-index: 1001;
    }

    /* Hero */
    .hero-wrapper {
        padding: 60px 5% 100px;
        background: linear-gradient(135deg, #ffffff 0%, var(--bg-light) 100%);
        overflow: hidden;
    }

    .hero-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
    }

    .hero-text { flex: 1; max-width: 600px; z-index: 10; }
    .hero-text h1 {
        font-size: clamp(28px, 5vw, 48px);
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
        margin-bottom: 20px;
    }
    .hero-text h1 span { color: var(--primary); }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(4, 67, 137, 0.08);
        color: var(--primary);
        font-size: 13px;
        font-weight: 600;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 20px;
        border: 1px solid rgba(4, 67, 137, 0.15);
    }

    .hero-desc { font-size: 16px; color: var(--text-muted); margin-bottom: 30px; }

    .hero-buttons { display: flex; gap: 15px; margin-bottom: 40px; flex-wrap: wrap; }
    .btn-oval {
        background: var(--primary); color: #fff; padding: 14px 36px; border-radius: 50px;
        font-weight: 600; text-decoration: none; transition: var(--transition);
        box-shadow: var(--shadow-md); display: inline-flex; align-items: center; gap: 10px;
    }
    .btn-outline {
        padding: 14px 32px; border-radius: 50px; border: 2px solid rgba(4, 67, 137, 0.15);
        color: var(--text-main); font-weight: 600; text-decoration: none;
        transition: var(--transition); display: inline-flex; align-items: center; gap: 10px;
    }

    .hero-stats {
        display: flex; gap: 25px; padding-top: 25px; border-top: 1px solid rgba(0,0,0,0.06); flex-wrap: wrap;
    }
    .stat-item { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
    .stat-item i {
        color: var(--primary); background: rgba(4, 67, 137, 0.1);
        width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    }

    .hero-img { flex: 1; max-width: 500px; animation: float 6s infinite ease-in-out; }
    .hero-img img { width: 100%; border-radius: 30px; box-shadow: var(--shadow-lg); border: 6px solid #fff; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    /* Sections */
    section { padding: 80px 5%; }
    .sec-label { text-align: center; margin-bottom: 50px; }
    .sec-label span {
        background: rgba(4, 67, 137, 0.08); color: var(--primary);
        font-size: 13px; font-weight: 700; padding: 8px 24px; border-radius: 50px;
        text-transform: uppercase; letter-spacing: 1px;
    }

    .card, .tujuan-card {
        background: #fff; border-radius: 24px; padding: 40px 5%; margin: 0 auto;
        box-shadow: var(--shadow-md); border: 1px solid rgba(4, 67, 137, 0.08);
    }
    .card { max-width: 900px; }
    .tujuan-card { max-width: 1000px; display: flex; align-items: center; gap: 40px; }
    .tujuan-img { width: 350px; flex-shrink: 0; }
    .tujuan-img img { width: 100%; border-radius: 20px; box-shadow: var(--shadow-md); }

    .panduan-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px; max-width: 1200px; margin: 0 auto;
    }
    .panduan-card {
        background: var(--bg-light); border-radius: 24px; padding: 40px 30px;
        transition: var(--transition); opacity: 0; transform: translateY(20px);
    }
    .panduan-card.visible { opacity: 1; transform: translateY(0); }
    .panduan-card:hover { background: #fff; box-shadow: var(--shadow-lg); transform: translateY(-5px); }
    .panduan-icon {
        font-size: 28px; color: var(--primary); width: 60px; height: 60px;
        background: rgba(4, 67, 137, 0.1); border-radius: 15px;
        display: flex; align-items: center; justify-content: center; margin-bottom: 20px;
    }

    /* Statistics */
    #statistik { background: var(--bg-light); }
    .chart-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1100px; margin: 0 auto; }
    .chart-card { background: #fff; padding: 25px; border-radius: 24px; box-shadow: var(--shadow-sm); text-align: center; }
    .chart-wrapper { position: relative; height: 300px; width: 100%; }

    /* Footer */
    footer {
        background: var(--primary); color: #fff; padding: 60px 5% 40px;
        display: flex; justify-content: space-between; flex-wrap: wrap; gap: 40px;
    }
    .f-left { max-width: 450px; }
    .f-row { display: flex; gap: 15px; margin-bottom: 15px; font-size: 14px; text-align: left; }
    .socials { display: flex; gap: 12px; }
    .s-btn {
        width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center; color: #fff;
        text-decoration: none; border: 1px solid rgba(255,255,255,0.1); transition: var(--transition);
    }
    .s-btn:hover { background: #fff; color: var(--primary); transform: translateY(-3px); }

    /* Responsive */
    @media (max-width: 1024px) {
        .hero-inner { flex-direction: column; text-align: center; gap: 50px; }
        .hero-img { width: 100%; max-width: 450px; }
        .hero-buttons, .hero-stats { justify-content: center; }
        .tujuan-card { flex-direction: column; text-align: center; }
        .tujuan-img { width: 100%; max-width: 400px; }
    }

    @media (max-width: 768px) {
        .mobile-toggle { display: block; }
        .nav-links {
            position: fixed; top: 70px; left: -100%; width: 100%; height: calc(100vh - 70px);
            background: var(--primary); flex-direction: column; padding: 40px 5%; gap: 20px;
            transition: var(--transition); z-index: 999;
        }
        .nav-links.active { left: 0; }
        .nav-links li { width: 100%; text-align: center; }
        .nav-links a { display: block; font-size: 18px; padding: 10px 0; }
        .btn-login { width: 100%; margin-top: 20px; }
        
        section { padding: 60px 5%; }
        .card, .tujuan-card { padding: 30px 20px; }
        footer { flex-direction: column; text-align: center; }
        .f-left { max-width: 100%; }
        .f-row { justify-content: center; flex-direction: column; align-items: center; gap: 5px; }
        .socials { justify-content: center; }
    }

    @media (max-width: 480px) {
        .hero-buttons { flex-direction: column; }
        .btn-oval, .btn-outline { width: 100%; justify-content: center; }
        .hero-stats { flex-direction: column; align-items: center; gap: 15px; }
        .chart-wrapper { height: 240px; }
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
            <li><a href="#tujuan">Tujuan & Manfaat</a></li>
            <li><a href="#panduan">Panduan</a></li>
            <li><a href="#statistik">Statistik</a></li>
            <li><a href="#kontak">Kontak</a></li>
            <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
        </ul>
        <button class="mobile-toggle" id="mobileToggle">
            <i class="fa-solid fa-bars"></i>
        </button>
    </nav>

    <div class="hero-wrapper" id="hero">
        <div class="hero-inner fade-up">
            <div class="hero-text">
                <div class="hero-badge"><i class="fa-solid fa-shield-halved"></i> Aman, Cepat & Terpercaya</div>
                <h1>Suarakan Aspirasimu untuk<br><span>Kampus yang Lebih Baik</span></h1>
                <p class="hero-desc">Sistem Pengaduan Mahasiswa Politeknik Caltex Riau hadir sebagai wadah resmi untuk menyampaikan keluhan, saran, dan aspirasi secara transparan dan mudah dipantau.</p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn-oval">Buat Pengaduan <i class="fa-solid fa-paper-plane"></i></a>
                    <a href="#panduan" class="btn-outline">Lihat Panduan</a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item"><i class="fa-solid fa-bolt"></i><span>Respon Cepat</span></div>
                    <div class="stat-item"><i class="fa-solid fa-arrows-rotate"></i><span>Terpantau Real-time</span></div>
                </div>
            </div>
            <div class="hero-img">
                <img src="{{ asset('images/landing1.png') }}" alt="Ilustrasi Pengaduan">
            </div>
        </div>
    </div>

    <section id="panduan">
        <div class="sec-label"><span>Tata Cara Menulis Laporan</span></div>
        <div class="panduan-grid">
            <div class="panduan-card"><i class="fa-solid fa-comments panduan-icon"></i><h3 class="panduan-title">Bahasa Sopan & Jelas</h3><p class="panduan-desc">Sampaikan pengaduan menggunakan bahasa yang baik, mudah dipahami, dan sopan.</p></div>
            <div class="panduan-card"><i class="fa-solid fa-list-check panduan-icon"></i><h3 class="panduan-title">Detail Permasalahan</h3><p class="panduan-desc">Tuliskan kronologi kejadian secara lengkap agar laporan lebih mudah diproses.</p></div>
            <div class="panduan-card"><i class="fa-solid fa-image panduan-icon"></i><h3 class="panduan-title">Bukti Pendukung</h3><p class="panduan-desc">Tambahkan foto atau dokumen pendukung agar laporan lebih valid dan kuat.</p></div>
        </div>
    </section>

    <section id="about">
        <div class="sec-label"><span>About</span></div>
        <div class="card fade-up">
            <p>Sistem Pengaduan Mahasiswa Berbasis Web Politeknik Caltex Riau merupakan platform digital yang dirancang untuk memfasilitasi mahasiswa dalam menyampaikan berbagai keluhan secara transparan.</p>
            <p>Melalui sistem ini, mahasiswa dapat mengajukan pengaduan secara langsung kepada unit layanan yang berwenang dan memantau perkembangannya secara real-time.</p>
        </div>
    </section>

    <section id="tujuan">
        <div class="sec-label"><span>Tujuan & Manfaat</span></div>
        <div class="tujuan-card fade-up">
            <div class="tujuan-body">
                <h3>Sampaikan aspirasi tanpa batas!</h3>
                <p>Sistem ini hadir untuk membantu mahasiswa menyampaikan keluhan, saran, dan masukan dengan lebih cepat dan transparan.</p>
                <p>PCR berkomitmen menghadirkan layanan akademik yang responsif, efisien, dan berorientasi pada kebutuhan mahasiswa.</p>
            </div>
            <div class="tujuan-img"><img src="{{ asset('images/landing2.png') }}" alt="Ilustrasi Tujuan"></div>
        </div>
    </section>

    <section id="statistik">
        <div class="sec-label"><span>Statistik Pengaduan</span></div>
        <div class="chart-container fade-up">
            <div class="chart-card">
                <h3>Distribusi Status</h3>
                <div class="chart-wrapper">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h3>Aduan per Unit</h3>
                <div class="chart-wrapper">
                    <canvas id="unitChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <footer id="kontak">
        <div class="f-left">
            <div class="f-row"><i class="fa-solid fa-location-dot"></i><span>Jl. Umban Sari No.1, Rumbai, Pekanbaru, Riau 28265</span></div>
            <div class="f-row"><i class="fa-solid fa-phone"></i><span>076153938 / 0811 758 0101</span></div>
        </div>
        <div class="f-right">
            <span class="f-title">MEDIA SOSIAL</span>
            <div class="socials">
                <a href="#" class="s-btn"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="s-btn"><i class="fa-brands fa-youtube"></i></a>
                <a href="#" class="s-btn"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nav = document.querySelector('nav');
            const mobileToggle = document.getElementById('mobileToggle');
            const navLinks = document.querySelector('.nav-links');

            window.addEventListener('scroll', () => {
                nav.classList.toggle('scrolled', window.scrollY > 20);
            });

            if (mobileToggle) {
                mobileToggle.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                    const icon = mobileToggle.querySelector('i');
                    icon.classList.toggle('fa-bars');
                    icon.classList.toggle('fa-xmark');
                });
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.fade-up, .panduan-card').forEach(el => observer.observe(el));

            // Charts
            const stats = {!! json_encode($stats) !!};
            const units = {!! json_encode($unitReports) !!};

            new Chart(document.getElementById('statusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Menunggu', 'Proses', 'Selesai'],
                    datasets: [{
                        data: [stats.menunggu, stats.proses, stats.selesai],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                        borderRadius: 5
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            new Chart(document.getElementById('unitChart'), {
                type: 'bar',
                data: {
                    labels: units.map(u => u.nama_unit),
                    datasets: [{
                        label: 'Aduan',
                        data: units.map(u => u.report_count),
                        backgroundColor: '#3b82f6',
                        borderRadius: 5
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });
        });
    </script>
</body>
</html>