<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Global Styles & Font */
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;700&display=swap');

        :root {
            --primary-color: #4a90e2;
            --primary-hover-color: #357ABD;
            --background-color: #f4f7fc;
            --panel-background: #ffffff;
            --text-color: #333;
            --text-secondary-color: #777;
            --border-color: #e0e0e0;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Vazirmatn', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Main Login Container */
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            /* Adjusted max-width for login */
            min-height: 600px;
            background-color: var(--panel-background);
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* 1. Info Panel (Right) - توضیحات درمورد سایت */
        .info-panel {
            flex-basis: 50%;
            background-image: linear-gradient(rgba(74, 144, 226, 0.85), rgba(53, 122, 189, 0.95)), url('https://images.unsplash.com/photo-1557682250-33bd709cbe85?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: right;
        }

        .info-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .info-panel p {
            font-size: 1.1rem;
            line-height: 1.8;
            font-weight: 300;
        }

        /* 2. Login Panel (Left) - فرم ورود */
        .login-panel {
            flex-basis: 50%;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: right;
        }

        .login-form p {
            color: var(--text-secondary-color);
            margin-bottom: 2.5rem;
            text-align: right;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            /* Icon on the left for RTL */
            color: var(--text-secondary-color);
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px 14px 45px;
            /* Padding for icon */
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .login-btn {
            width: 100%;
            padding: 14px 20px;
            font-size: 18px;
            font-family: 'Vazirmatn', sans-serif;
            font-weight: 500;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1rem;
        }

        .login-btn:hover {
            background-color: var(--primary-hover-color);
        }

        .signup-link {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-secondary-color);
        }

        .signup-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .login-container {
                flex-direction: column;
                min-height: auto;
                margin: 2rem 0;
            }

            .info-panel {
                flex-basis: auto;
                min-height: 250px;
                text-align: center;
            }

            .login-panel {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>

    <div class="login-container">

        <div class="info-panel">
            <h1>به وبسایت ما خوش امدید</h1>
            <p>اینجا فضای کاربری شما برای مدیریت یکپارچه تمام فعالیت‌هاست. به سادگی کاربران را مدیریت کنید، آمارها را
                تحلیل کرده و بهره‌وری خود را افزایش دهید.</p>
        </div>

        <div class="login-panel">
            <div class="login-form">
                <h2>ورود به حساب کاربری</h2>
                <p>برای ادامه، نام کاربری و رمز عبور خود را وارد کنید.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="username" placeholder="نام کاربری" required>
                        @error('username')
                            <span style="color:red">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" name="password" placeholder="رمز عبور" required>
                    </div>

                    <button type="submit" class="login-btn">ورود</button>

                    <div class="signup-link">
                        <a href="#">رمز عبور خود را فراموش کرده‌اید؟</a>
                    </div>
                </form>
            </div>
        </div>

    </div>

</body>
</html>

