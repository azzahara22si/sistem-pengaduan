<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Politeknik Caltex Riau</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #ffffff;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .login-card {
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

        .login-card h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .login-card p {
            font-size: 13px;
            margin-bottom: 40px;
            font-weight: 500;
            letter-spacing: 1px;
            opacity: 0.9;
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

        .forgot-link {
            display: block;
            text-align: right;
            color: #2e6091;
            font-size: 12px;
            text-decoration: none;
            margin-bottom: 30px;
            padding-right: 10px;
            font-weight: 500;
        }

        .login-btn {
            background: white;
            color: #04396c;
            border: none;
            padding: 12px 0;
            width: 100%;
            max-width: 180px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .login-btn:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
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

    <div class="login-card">
        <div class="logo-pill">
            <img src="{{ asset('images/logo.png') }}" alt="Politeknik Caltex Riau">
        </div>

        <h2>Login</h2>
        <p>WELCOME BACK!</p>

        @if (session('status'))
            <div style="color: #4ade80; font-size: 12px; margin-bottom: 20px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')
                <div class="error-msg">{{ $message }}</div>
            @enderror

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fa-solid fa-eye-slash toggle-password" style="margin-right: 0; margin-left: 10px; font-size: 16px; cursor: pointer; color: #888;"></i>
            </div>
            @error('password')
                <div class="error-msg">{{ $message }}</div>
            @enderror

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
