<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فرم ساخت کاربر جدید</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Global Styles & Font from your original design */
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

        /* Re-using the card/panel style from your design */
        .form-container {
            width: 100%;
            max-width: 500px;
            background-color: var(--panel-background);
            padding: 2.5rem;
            /* A bit more padding for a spacious form */
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .form-container h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .form-container p {
            color: var(--text-secondary-color);
            margin-bottom: 2.5rem;
            text-align: center;
        }

        /* Input fields styles from your design */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            color: var(--text-secondary-color);
            transition: color 0.3s;
        }

        .input-group input {
            width: 100%;
            padding: 14px 20px 14px 45px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-family: 'Vazirmatn', sans-serif;
            font-size: 16px;
            transition: border-color 0.3s ease;
            background-color: #fdfdff;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .input-group input:focus+i {
            color: var(--primary-color);
        }

        /* NEW: Custom Checkbox for Admin toggle */
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            color: var(--text-color);
        }

        .checkbox-group input[type="checkbox"] {
            opacity: 0;
            position: absolute;
        }

        .custom-checkbox {
            width: 22px;
            height: 22px;
            border: 2px solid var(--border-color);
            border-radius: 6px;
            margin-left: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .custom-checkbox .fa-check {
            color: white;
            font-size: 12px;
            opacity: 0;
            transform: scale(0.5);
            transition: opacity 0.2s, transform 0.2s;
        }

        /* Style for when the checkbox is checked */
        .checkbox-group input[type="checkbox"]:checked+.custom-checkbox {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .checkbox-group input[type="checkbox"]:checked+.custom-checkbox .fa-check {
            opacity: 1;
            transform: scale(1);
        }

        /* Submit button style from your design */
        .submit-btn {
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

        .submit-btn:hover {
            background-color: var(--primary-hover-color);
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>ساخت کاربر جدید</h2>
        <p>اطلاعات زیر را برای ایجاد اکانت جدید تکمیل کنید.</p>

        @session('success')
            <span style="color:green; text-align:center">{{ $value }}</span>
        @endsession
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="tel" name="phone" placeholder="شماره تلفن" required>
                @error('phone')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>

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
                @error('password')
                    <span style="color:red">{{ $message }}</span>
                @enderror
            </div>

            <div class="checkbox-group">
                <label for="isAdmin">
                    <input type="checkbox" name="role" value="admin" id="isAdmin">
                    @error('role')
                        <span style="color:red">{{ $message }}</span>
                    @enderror
                    <span class="custom-checkbox">
                        <i class="fa-solid fa-check"></i>
                    </span>
                    این کاربر به عنوان ادمین تعریف شود
                </label>
            </div>

            <button type="submit" class="submit-btn">ساخت اکانت جدید</button>
        </form>
    </div>

</body>
</html>
