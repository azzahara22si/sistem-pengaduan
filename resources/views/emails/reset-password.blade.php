<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background-color: #04396c; padding: 30px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 600; letter-spacing: 1px; }
        .content { padding: 40px 30px; color: #333333; line-height: 1.6; }
        .content p { margin-bottom: 20px; font-size: 15px; }
        .btn-container { text-align: center; margin: 35px 0; }
        .btn { display: inline-block; background-color: #04396c; color: #ffffff; padding: 14px 30px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 15px; letter-spacing: 0.5px; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #64748b; border-top: 1px solid #e2e8f0; }
        .footer p { margin: 5px 0; }
        .fallback { font-size: 12px; color: #64748b; word-break: break-all; background: #f8fafc; padding: 15px; border-radius: 6px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sistem Pengaduan PCR</h1>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $user->name ?? 'Mahasiswa' }}</strong>,</p>
            <p>Kami menerima permintaan untuk mereset password akun Anda di Sistem Pengaduan Mahasiswa Politeknik Caltex Riau.</p>
            
            <div class="btn-container">
                <a href="{{ $url }}" class="btn" style="color: #ffffff !important; background-color: #04396c; display: inline-block; padding: 14px 30px; text-decoration: none; border-radius: 50px; font-weight: bold; font-size: 15px;">Reset Password Sekarang</a>
            </div>
            
            <p>Tautan reset password ini akan kedaluwarsa dalam waktu 60 menit.</p>
            <p>Jika Anda tidak pernah merasa meminta reset password, abaikan saja email ini. Akun Anda akan tetap aman.</p>
            
            <p>Salam hangat,<br><strong>Admin Sistem Pengaduan</strong></p>

            <div class="fallback">
                Jika Anda kesulitan mengklik tombol "Reset Password Sekarang", silakan salin dan tempel (copy-paste) URL berikut ke browser Anda:<br><br>
                <a href="{{ $url }}" style="color: #04396c;">{{ $url }}</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Politeknik Caltex Riau. Hak Cipta Dilindungi.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
