<?php
include("data.php"); 
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$user = null;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM signup WHERE id = $id";
    $result = mysqli_query($link, $sql);
    $user = mysqli_fetch_assoc($result);
    
    if (!$user) {
        $_SESSION['message'] = "کاربر مورد نظر یافت نشد";
        header("Location: admin.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($link, $_POST['name']);
    $family = mysqli_real_escape_string($link, $_POST['family']);
    $namepedar = mysqli_real_escape_string($link, $_POST['namepedar']);
    $codemeli = mysqli_real_escape_string($link, $_POST['codemeli']);
    $tellpedar = mysqli_real_escape_string($link, $_POST['tellpedar']);
    $tellfarzand = mysqli_real_escape_string($link, $_POST['tellfarzand']);
    
    $sql = "UPDATE signup SET 
            name = '$name',
            family = '$family',
            namepedar = '$namepedar',
            codemeli = '$codemeli',
            tellpedar = '$tellpedar',
            tellfarzand = '$tellfarzand'
            WHERE id = $id";
    
    if (mysqli_query($link, $sql)) {
        $_SESSION['message'] = "اطلاعات کاربر با موفقیت به‌روزرسانی شد";
        header("Location: admin.php");
        exit();
    } else {
        $error = "خطا در به‌روزرسانی اطلاعات: " . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش کاربر</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="tel"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #4CAF50;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ویرایش کاربر</h1>
        
        <?php if (isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($user): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            
            <div class="form-group">
                <label for="name">نام:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="family">نام خانوادگی:</label>
                <input type="text" id="family" name="family" value="<?php echo htmlspecialchars($user['family']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="namepedar">نام پدر:</label>
                <input type="text" id="namepedar" name="namepedar" value="<?php echo htmlspecialchars($user['namepedar']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="codemeli">کد ملی:</label>
                <input type="text" id="codemeli" name="codemeli" value="<?php echo htmlspecialchars($user['codemeli']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tellpedar">تلفن پدر:</label>
                <input type="tel" id="tellpedar" name="tellpedar" value="<?php echo htmlspecialchars($user['tellpedar']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tellfarzand">تلفن فرزند:</label>
                <input type="tel" id="tellfarzand" name="tellfarzand" value="<?php echo htmlspecialchars($user['tellfarzand']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">تاریخ تولد:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($user['date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">صادره:</label>
                <input type="text" id="sadere" name="sadere" value="<?php echo htmlspecialchars($user['sadere']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">استان:</label>
                <input type="text" id="ostan" name="ostan" value="<?php echo htmlspecialchars($user['ostan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">شهرستان:</label>
                <input type="text" id="shahr" name="shahr" value="<?php echo htmlspecialchars($user['shahr']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">آدرس:</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">پلاک:</label>
                <input type="number" id="pelak" name="pelak" value="<?php echo htmlspecialchars($user['pelak']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">تاریخ ثبت:</label>
                <input type="date" id="created_at" name="created_at" value="<?php echo htmlspecialchars($user['created_at']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">عکس شناسنامه:</label>
                <input type="file" id="passport_file" name="passport_file" value="<?php echo htmlspecialchars($user['passport_file']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">عکس 3*4:</label>
                <input type="file" id="pic_file" name="pic_file" value="<?php echo htmlspecialchars($user['pic_file']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tellfarzand">امضای پدر:</label>
                <input type="file" id="emza_file" name="emza_file" value="<?php echo htmlspecialchars($user['emza_file']); ?>" required>
            </div>
            
            <div class="form-group">
                <button  type="submit" name="update_user" class="btn btn-primary">ذخیره تغییرات</button>
                <a href="admin.php" class="btn btn-secondary">انصراف</a>
            </div>
        </form>
        <?php else: ?>
            <div class="message error">مشکلی در دریافت اطلاعات کاربر پیش آمده است</div>
            <a href="admin.php" class="btn btn-secondary">بازگشت به لیست کاربران</a>
        <?php endif; ?>
    </div>
</body>
</html>