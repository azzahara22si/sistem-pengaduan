<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Politeknik Caltex Riau</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .auth-card {
            background-color: #04396c;
            width: 100%;
            max-width: 480px;
            padding: 50px 50px;
            border-radius: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            text-align: center;
            color: white;
            margin: 20px;
        }

        .logo-pill {
            background: white;
            padding: 10px 35px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 35px;
        }

        .logo-pill img {
            height: 25px;
            display: block;
        }

        .auth-card h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .auth-card p {
            font-size: 13px;
            margin-bottom: 40px;
            font-weight: 500;
            letter-spacing: 1px;
            opacity: 0.9;
            line-height: 1.7;
        }

        .input-group {
            background: white;
            border-radius: 50px;
            display: flex;
            align-items: center;
            padding: 12px 25px;
            margin-bottom: 10px;
        }

        .input-group i {
            color: #888;
            margin-right: 15px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        .input-group input {
            border: none;
            outline: none;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            color: #333;
            background: transparent;
            font-size: 14px;
        }

        .input-group input::placeholder {
            color: #aaa;
        }

        .auth-btn {
            background: white;
            color: #04396c;
            border: none;
            padding: 12px 0;
            width: 100%;
            max-width: 220px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .auth-btn:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        .auth-link {
            display: block;
            margin-top: 25px;
            color: #a4cef7;
            text-decoration: none;
            font-size: 13px;
        }

        .message {
            background: rgba(74, 222, 128, 0.15);
            color: #d1fae5;
            padding: 12px 18px;
            border-radius: 18px;
            margin-bottom: 20px;
            font-size: 13px;
            text-align: left;
        }

        .error-msg {
            color: #ff8e8e;
            font-size: 11px;
            margin-bottom: 15px;
            text-align: left;
            padding-left: 20px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="logo-pill">
            <img src="{{ asset('images/logo.png') }}" alt="Politeknik Caltex Riau">
        </div>

        <h2>Lupa Password</h2>
        <p>Masukkan email Anda dan kami akan mengirimkan tautan untuk mereset password ke email tersebut.</p>

        @if (session('status'))
            <div class="message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')
                <div class="error-msg">{{ $message }}</div>
            @enderror

            <button type="submit" class="auth-btn">Kirim Tautan Reset</button>
        </form>

        <a href="{{ route('login') }}" class="auth-link">Kembali ke Login</a>
    </div>
</body>
</html>
