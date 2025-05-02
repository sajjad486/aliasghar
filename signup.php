<?php
include("data.php"); 
session_start();

// بررسی وجود پوشه آپلود و ایجاد آن
$upload_dir = "uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// تابع اعتبارسنجی ورودی‌ها
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// تابع آپلود فایل اصلاح شده
function upload_file($file, $target_dir) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // بررسی وجود فایل
    if (file_exists($target_file)) {
        return false;
    }

    // بررسی حجم فایل (حداکثر 500KB)
    if ($file["size"] > 500000) {
        return false;
    }

    // فرمت های مجاز
    $allowed_types = ['jpg', 'png', 'jpeg', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        return false;
    }

    // جابجایی فایل آپلود شده
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return false;
    }
}

// بررسی و ثبت داده‌ها (ثبت نام)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['signup_submitted'])) {
    // دریافت و اعتبارسنجی داده‌ها
    $name = validate_input($_POST['name']);
    $family = validate_input($_POST['family']);
    $namep = validate_input($_POST['namep']);
    $tell = validate_input($_POST['tell']);
    $tellp = validate_input($_POST['tellp']);
    $meli = validate_input($_POST['meli']);
    $username = validate_input($_POST['username']);
    $password = $_POST['password'];
    $date_miladi = $_POST['date_miladi'];
    $ostan = validate_input($_POST['ostan']);
    $shahr = validate_input($_POST['shahr']);
    $address = validate_input($_POST['address']);
    $pelak = validate_input($_POST['pelak']);

    // آرایه برای ذخیره خطاها
    $errors = [];

    // اعتبارسنجی شماره تلفن پدر
    if (!preg_match('/^09\d{9}$/', $tell)) {
        $errors[] = "شماره تلفن پدر نامعتبر است. شماره تلفن باید با 09 شروع شود و 11 رقم باشد.";
    }

    // اعتبارسنجی شماره تلفن فرزند
    if (!preg_match('/^09\d{9}$/', $tellp)) {
        $errors[] = "شماره تلفن فرزند نامعتبر است. شماره تلفن باید با 09 شروع شود و 11 رقم باشد.";
    }

    // اعتبارسنجی کد ملی
    if (!preg_match('/^\d{10}$/', $meli)) {
        $errors[] = "کد ملی نامعتبر است. کد ملی باید 10 رقم باشد.";
    }

    // بررسی تکراری بودن شماره تلفن پدر
    $check_tell = mysqli_query($link, "SELECT id FROM signup WHERE tellpedar = '$tell'");
    if (mysqli_num_rows($check_tell) > 0) {
        $errors[] = "شماره تماس پدر قبلاً ثبت شده است.";
    }

    // بررسی تکراری بودن شماره تلفن فرزند
    $check_tellp = mysqli_query($link, "SELECT id FROM signup WHERE tellfarzand = '$tellp'");
    if (mysqli_num_rows($check_tellp) > 0) {
        $errors[] = "شماره تماس فرزند قبلاً ثبت شده است.";
    }

    // بررسی تکراری بودن کد ملی
    $check_meli = mysqli_query($link, "SELECT id FROM signup WHERE codemeli = '$meli'");
    if (mysqli_num_rows($check_meli) > 0) {
        $errors[] = "کد ملی قبلاً ثبت شده است.";
    }

    // بررسی تکراری بودن نام کاربری
    $check_username = mysqli_query($link, "SELECT id FROM signup WHERE username = '$username'");
    if (mysqli_num_rows($check_username) > 0) {
        $errors[] = "نام کاربری قبلاً ثبت شده است.";
    }

    // آپلود فایل‌ها
    $passport_file = upload_file($_FILES["passport"], $upload_dir);
    $pic_file = upload_file($_FILES["pic"], $upload_dir);
    $emza_file = upload_file($_FILES["emza"], $upload_dir);

    if (!$passport_file) {
        $errors[] = "مشکلی در آپلود عکس شناسنامه پیش آمد.";
    }
    if (!$pic_file) {
        $errors[] = "مشکلی در آپلود عکس 3*4 پیش آمد.";
    }
    if (!$emza_file) {
        $errors[] = "مشکلی در آپلود فایل امضا پیش آمد.";
    }

    if (empty($errors)) {
        // هش کردن رمز عبور
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO signup(name, family, namepedar, tellpedar, tellfarzand, codemeli, date, sadere, username, password, ostan, shahr, address, pelak, passport_file, pic_file, emza_file)
                VALUES ('$name', '$family', '$namep', '$tell', '$tellp', '$meli', '$date_miladi', '".$_POST["sadere"]."', '$username', '$hashed_password', '$ostan', '$shahr', '$address', '$pelak', '$passport_file', '$pic_file', '$emza_file')";

        if (mysqli_query($link, $sql)) {
            $_SESSION['signup_submitted'] = true;
            header("Location: signup.php?signup_success=1");
            exit();
        } else {
            die("خطا در ثبت اطلاعات: " . mysqli_error($link));
        }
    } else {
        // نمایش خطاها
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        }
    }
}

// رفع حالت رفرش (ثبت نام)
if (isset($_GET['signup_success']) && $_GET['signup_success'] == 1) {
    echo "<div class='success'>ثبت نام با موفقیت انجام شد.</div>";
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    unset($_SESSION['signup_submitted']);
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام</title>
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
            direction: rtl;
        }
        
        .continor {
            background-color: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .continor:hover {
            transform: translateY(-5px);
        }
        
        .form-title {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 2rem;
        }
        
        form {
            text-align: right;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }
        
        table td {
            padding: 0.8rem;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .input {
            width: calc(100% - 10px);
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border 0.3s ease;
            box-sizing: border-box;
        }
        
        .input:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .submit-btn {
            display: inline-block;
            background-color: var(--success-color);
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
        
        .submit-btn:hover {
            background-color: var(--success-color);
        }
        
        .error {
            color: var(--danger-color);
            background-color: rgba(231, 76, 60, 0.1);
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
        }
        
        .success {
            color: var(--success-color);
            background-color: rgba(46, 204, 113, 0.1);
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
        }
        
        p {
            font-size: 0.9rem;
            margin-top: 1rem;
            text-align: center;
        }
        
        p a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        p a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }
        
        a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        a:hover {
            color: var(--primary-color);
            text-decoration: underline;
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
    </style>
</head>
<body>
    <div class="continor">
        <h2 class="form-title" id="signup">ثبت نام</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>
                        <label for="name">نام:</label>
                        <input type="text" class="input" placeholder="نام" name="name" id="name" required />
                    </td>
                    <td>
                        <label for="family">نام خانوادگی:</label>
                        <input type="text" class="input" placeholder="نام خانوادگی" name="family" id="family" required />
                    </td>
                    <td>
                        <label for="namep">نام پدر:</label>
                        <input type="text" class="input" placeholder="نام پدر" name="namep" id="namep" required />
                    </td>
                    <td>
                        <label for="meli">کد ملی:</label>
                        <input type="number" class="input" placeholder="کد ملی" name="meli" id="meli" required />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="tellp">شماره تماس فرزند:</label>
                        <input type="number" class="input" placeholder="شماره تماس فرزند" name="tellp" id="tellp" required />
                    </td>
                    <td>
                        <label for="tell">شماره تماس پدر:</label>
                        <input type="number" class="input" placeholder="شماره تماس پدر" name="tell" id="tell" required />
                    </td>
                    <td>
                        <label for="sadere">شماره شناسنامه:</label>
                        <input type="number" class="input" placeholder="شماره شناسنامه" name="sadere" id="sadere" required />
                    </td>
                    <td>
                        <label for="ostan">صادره از (شهر):</label>
                        <input type="text" class="input" placeholder="صادره از (شهر)" name="ostan" id="ostan" required />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="ostan">استان محل سکونت:</label>
                        <input type="text" class="input" placeholder="استان محل سکونت" name="ostan" id="ostan" required />
                    </td>
                    <td>
                        <label for="shahr">شهرستان/روستا محل سکونت:</label>
                        <input type="text" class="input" placeholder="شهرستان/روستا محل سکونت" name="shahr" id="shahr" required />
                    </td>
                    <td>
                        <label for="address">آدرس محل سکونت:</label>
                        <input type="text" class="input" placeholder="آدرس محل سکونت" name="address" id="address" required />
                    </td>
                    <td>
                        <label for="pelak">پلاک:</label>
                        <input type="number" class="input" placeholder="پلاک" name="pelak" id="pelak" required />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="date">تاریخ تولد:</label>
                        <input type="text" class="input" placeholder="1404/01/31" name="date" id="date" required />
                        <input type="hidden" id="date_miladi" name="date_miladi">
                    </td>
                    <td>
                        <label for="passport">عکس از شناسنامه:</label>
                        <input type="file" class="input" name="passport" id="passport" required accept="image/*" />
                    </td>
                    <td>
                        <label for="pic">عکس 3*4:</label>
                        <input type="file" class="input" name="pic" id="pic" required accept="image/*" />
                    </td>
                    <td>
                        <label for="emza">فایل امضا پدر برای رضایت:</label>
                        <input type="file" class="input" name="emza" id="emza" required accept="image/*" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="username">نام کاربری:</label>
                        <input type="text" class="input" placeholder="نام کاربری" name="username" id="username" required />
                    </td>
                    <td>
                        <label for="password">رمز عبور:</label>
                        <input type="password" class="input" placeholder="رمز عبور" name="password" id="password" required />
                    </td>
                </tr>
            </table>
            <button class="submit-btn" type="submit">ثبت نام</button><br><br>
        </form>
        <div class="login-footer">
            <a href="login.php">ورود کاربران دارای حساب</a>
            <span class="divider">|</span>
            <a href="index.php">بازگشت به صفحه اصلی</a>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- کتابخانه تاریخ شمسی -->
    <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#date').persianDatepicker({
                format: 'YYYY/MM/DD',
                autoClose: true,
                onSelect: function(unix) {
                    // تبدیل تاریخ شمسی به میلادی با Moment.js
                    var miladi = moment.unix(unix).format('YYYY-MM-DD');
                    $('#date_miladi').val(miladi);
                }
            });
        });
    </script>

    <!-- Moment.js برای تبدیل تاریخ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-jalaali/0.10.0/moment-jalaali.js"></script>
</body>
</html>