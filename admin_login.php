<?php
include("data.php"); 
session_start();

// تنظیمات امنیتی
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');

// در حالت واقعی این اطلاعات باید از دیتابیس خوانده شوند
$admin_credentials = [
    'sajjad486' => [
        'password' => '1100701532', // در حالت واقعی باید هش شده باشد
        'role' => 'admin'
    ]
];

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // اعتبارسنجی CSRF توکن (در حالت واقعی باید پیاده‌سازی شود)
    
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // اعتبارسنجی ورودی‌ها
    if (empty($username) || empty($password)) {
        $error = "لطفا نام کاربری و رمز عبور را وارد نمایید";
    } elseif (!isset($admin_credentials[$username])) {
        // برای امنیت بیشتر، پیام یکسان نشان دهید
        $error = "نام کاربری یا رمز عبور نامعتبر است";
    } else {
        // در حالت واقعی باید از password_verify استفاده شود
        if ($password === $admin_credentials[$username]['password']) {
            // ایجاد سشن امن
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_role'] = $admin_credentials[$username]['role'];
            $_SESSION['last_activity'] = time();
            
            // جلوگیری از حملات Session Fixation
            session_regenerate_id(true);
            
            // هدایت به پنل مدیریت
            header("Location: admin.php");
            exit();
        } else {
            $error = "نام کاربری یا رمز عبور نامعتبر است";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'">
    <title>ورود مدیران | سیستم مدیریت</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        
        .login-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .login-container:hover {
            transform: translateY(-5px);
        }
        
        .login-header {
            margin-bottom: 2rem;
        }
        
        .login-header h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            text-align: right;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border 0.3s ease;
        }
        
        .form-group input:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        
        .btn:hover {
            background-color: var(--dark-color);
        }
        
        .error-message {
            color: var(--danger-color);
            background-color: rgba(231, 76, 60, 0.1);
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .login-footer {
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .login-footer a {
            color: var(--secondary-color);
            text-decoration: none;
            margin: 0 5px;
            transition: color 0.3s ease;
        }
        
        .login-footer a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        .divider {
            display: inline-block;
            color: #bdc3c7;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>ورود به پنل مدیریت</h2>
            <p>لطفا اطلاعات حساب مدیر را وارد نمایید</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="username">نام کاربری مدیر</label>
                <input type="text" id="username" name="username" required autocomplete="username" autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn">ورود به سیستم</button>
        </form>
        
        <div class="login-footer">
            <a href="login.php">ورود کاربران عادی</a>
            <span class="divider">|</span>
            <a href="index.php">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</body>
</html>