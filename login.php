<?php
include("data.php"); 

// فعال کردن گزارش خطا برای دیباگ
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// بررسی اتصال
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

// تنظیم کدگذاری برای پشتیبانی از فارسی
mysqli_set_charset($link, "utf8");

// بررسی ارسال فرم
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // مقداردهی اولیه متغیر خطا
    $error = "";
    
    // دریافت و اعتبارسنجی اطلاعات کاربری
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $error = "لطفا نام کاربری و رمز عبور خود را وارد کنید.";
    } else {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
        
        // جستجو در دیتابیس با استفاده از prepared statement
        $sql = "SELECT id, username, `password` FROM signup WHERE username = ?";
        
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                
                // اگر کاربر وجود داشت
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    mysqli_stmt_fetch($stmt);
                    
                    // بررسی رمز عبور
                    if ($password == $hashed_password) {
                        // ایجاد سشن
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        
                        // هدایت به صفحه اصلی
                        header("Location: index.php");
                        exit;
                    } else {
                        $error = "نام کاربری یا رمز عبور نامعتبر است";
                    }
                } else {
                    $error = "نام کاربری یا رمز عبور نامعتبر است";
                }
            } else {
                $error = "خطایی رخ داده است. لطفا دوباره تلاش کنید.";
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $error = "خطایی در آماده سازی کوئری رخ داده است.";
        }
    }
    
    // بستن اتصال
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline'">
    <title>ورود کاربران | سیستم مدیریت</title>
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
            <h2>ورود کاربران</h2>
            <p>لطفا اطلاعات حساب کاربری خود را وارد نمایید</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="username">نام کاربری</label>
                <input type="text" id="username" name="username" required autocomplete="username" autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">رمز عبور</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            
            <button type="submit" class="btn">ورود به سیستم</button>
        </form>
        
        <div class="login-footer">
            <a href="signup.php">ثبت نام کاربر جدید</a>
            <span class="divider">|</span>
            <a href="admin_login.php" style="color: var(--danger-color);">ورود مدیران</a>
            <span class="divider">|</span>
            <a href="index.php">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</body>
</html>