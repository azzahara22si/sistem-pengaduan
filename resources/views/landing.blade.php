<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengaduan Mahasiswa - Politeknik Caltex Riau</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #efefef;
            color: #222;
            font-size: 14px;
        }

        /* ── NAVBAR ── */
        nav {
            background: #1a3a5c;
            padding: 0 30px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-brand img {
            height: 32px;
            display: block;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
            list-style: none;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-login {
            background: #fff;
            color: #1a3a5c;
            font-size: 13px;
            font-weight: bold;
            padding: 5px 18px;
            border-radius: 4px;
            text-decoration: none;
        }

        /* ── HERO ── */
        .hero-wrapper {
            background: #fff;
        }

        .hero-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px;
            padding: 50px 30px;
            max-width: 900px;
            margin: 0 auto;
        }

        .hero-img {
            width: 200px;
            flex-shrink: 0;
        }

        .hero-img img {
            width: 100%;
            display: block;
        }

        .hero-text h1 {
            font-size: 22px;
            font-weight: bold;
            color: #1a3a5c;
            line-height: 1.4;
            margin-bottom: 22px;
        }

        .btn-oval {
            display: inline-block;
            background: #1a3a5c;
            color: #fff;
            font-size: 13px;
            padding: 10px 28px;
            border-radius: 50px;
            text-decoration: none;
        }

        /* ── SECTION LABEL ── */
        .sec-label {
            text-align: center;
            padding: 26px 0 18px;
        }

        .sec-label span {
            display: inline-block;
            background: #1a3a5c;
            color: #fff;
            font-size: 13px;
            font-weight: bold;
            padding: 9px 38px;
            border-radius: 50px;
        }

        /* ── ABOUT ── */
        #about {
            background: #efefef;
            padding-bottom: 30px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 26px 30px;
            max-width: 760px;
            margin: 0 auto;
        }

        .card p {
            font-size: 13.5px;
            line-height: 1.85;
            color: #333;
            text-align: center;
            margin-bottom: 14px;
        }

        .card p:last-child { margin-bottom: 0; }

        /* ── TUJUAN ── */
        #tujuan {
            background: #efefef;
            padding-bottom: 40px;
        }

        .tujuan-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 26px 30px;
            max-width: 760px;
            margin: 0 auto;
            display: flex;
            gap: 24px;
            align-items: flex-start;
        }

        .tujuan-body { flex: 1; }

        .tujuan-body h3 {
            font-size: 14.5px;
            font-weight: bold;
            color: #1a3a5c;
            margin-bottom: 14px;
        }

        .tujuan-body p {
            font-size: 13.5px;
            line-height: 1.85;
            color: #333;
            margin-bottom: 13px;
        }

        .tujuan-body p:last-child { margin-bottom: 0; }

        .tujuan-img {
            flex-shrink: 0;
            width: 140px;
            padding-top: 6px;
        }

        .tujuan-img img {
            width: 100%;
            display: block;
        }

        /* ── FOOTER ── */
        footer {
            background: #1a3a5c;
            color: #ccc;
            padding: 26px 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
        }

        .f-left { font-size: 13px; line-height: 2; }

        .f-row {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 6px;
        }

        .f-right { font-size: 13px; }

        .f-right .f-title {
            display: block;
            font-weight: bold;
            color: #fff;
            margin-bottom: 10px;
            font-size: 12px;
            letter-spacing: 0.04em;
        }

        .socials { display: flex; gap: 7px; }

        .s-btn {
            width: 27px;
            height: 27px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 9px;
            font-weight: bold;
            text-decoration: none;
        }

        .s-btn:hover { background: rgba(255,255,255,0.3); }

        @media (max-width: 640px) {
            .hero-inner { flex-direction: column; text-align: center; }
            .tujuan-card { flex-direction: column; }
            .tujuan-img { width: 100%; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="#hero">
        <img src="{{ asset('images/logo.png') }}" alt="Politeknik Caltex Riau" style="height:32px;">
    </a>
    <ul class="nav-links">
        <li><a href="#hero">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#tujuan">Tujuan &amp; Manfaat</a></li>
        <li><a href="#kontak">Kontak</a></li>
        <li><a href="{{ route('login') }}" class="btn-login">Login</a></li>
    </ul>
</nav>

<!-- HERO -->
<div class="hero-wrapper" id="hero">
    <div class="hero-inner">
        <div class="hero-img">
            <img src="{{ asset('images/landing1.png') }}" alt="Ilustrasi Pengaduan">
        </div>
        <div class="hero-text">
            <h1>Sistem Pengaduan<br>Mahasiswa Berbasis Web</h1>
            <a href="#about" class="btn-oval">Selengkapnya &rarr;</a>
        </div>
    </div>
</div>

<!-- ABOUT -->
<section id="about">
    <div class="sec-label"><span>About</span></div>
    <div class="card">
        <p>Sistem Pengaduan Mahasiswa Berbasis Web Politeknik Caltex Riau merupakan platform digital yang dirancang untuk memfasilitasi mahasiswa dalam menyampaikan berbagai keluhan, saran, atau masukan terkait layanan akademik dan non-akademik secara lebih cepat, transparan, dan terdokumentasi.</p>
        <p>Melalui sistem ini, mahasiswa dapat mengajukan pengaduan secara langsung kepada unit layanan yang berwenang tanpa harus melalui proses manual seperti perantara dosen wali atau forum evaluasi akhir semester. Setiap pengaduan yang dikirim akan otomatis tercatat dalam sistem, diteruskan ke pihak terkait, dan dapat dipantau perkembangannya secara real-time oleh mahasiswa.</p>
    </div>
</section>

<!-- TUJUAN & MANFAAT -->
<section id="tujuan">
    <div class="sec-label"><span>Tujuan &amp; Manfaat</span></div>
    <div class="tujuan-card">
        <div class="tujuan-body">
            <h3>Sampaikan aspirasi tanpa batas!</h3>
            <p>Sistem Pengaduan Mahasiswa Berbasis Web Politeknik Caltex Riau hadir untuk membantu mahasiswa menyampaikan keluhan, saran, dan masukan dengan lebih cepat, transparan, dan mudah dipantau.</p>
            <p>Dengan dukungan konsep CRM-IDIC (Identify, Differentiate, Interact, Customize), setiap aduan akan diteruskan ke unit terkait secara otomatis dan terdokumentasi dengan aman. Tidak ada lagi laporan yang hilang atau respons yang terlambat — semuanya terkelola dalam satu sistem terpadu.</p>
            <p>Melalui sistem ini, PCR berkomitmen menghadirkan layanan akademik yang responsif, efisien, dan berorientasi pada kebutuhan mahasiswa.</p>
        </div>
        <div class="tujuan-img">
            <img src="{{ asset('images/landing2.png') }}" alt="Ilustrasi Tujuan">
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer id="kontak">
    <div class="f-left">
        <div class="f-row">
            <span>📍</span>
            <span>Jl. Umbansari No.1, Umbansari, Kec. Rumbai,<br>Kota Pekanbaru, Riau 28265</span>
        </div>
        <div class="f-row">
            <span>📞</span>
            <span>076153938 / 081 758 0101</span>
        </div>
    </div>
    <div class="f-right">
        <span class="f-title">MEDIA SOSIAL</span>
        <div class="socials">
            <a href="#" class="s-btn" title="Instagram">Ig</a>
            <a href="#" class="s-btn" title="Twitter">Tw</a>
            <a href="#" class="s-btn" title="YouTube">Yt</a>
            <a href="#" class="s-btn" title="Google+">G+</a>
        </div>
    </div>
</footer>

</body>
</html>