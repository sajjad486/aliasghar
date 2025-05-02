<?php
include("data.php"); 
session_start();

// بررسی جامع لاگین ادمین
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("HTTP/1.1 403 Forbidden");
    header("Location: admin_login.php");
    exit();
}
// حذف کاربر
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM signup WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        $_SESSION['message'] = "کاربر با موفقیت حذف شد";
    } else {
        $_SESSION['error'] = "خطا در حذف کاربر";
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
// حذف اخبار
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM news WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        $_SESSION['message'] = "اخبار با موفقیت حذف شد";
    } else {
        $_SESSION['error'] = "خطا در حذف اخبار";
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
// حذف تصویر نگارخانه
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM negarkhane WHERE id = $id";
    if (mysqli_query($link, $sql)) {
        $_SESSION['message'] = "تصویر با موفقیت حذف شد";
    } else {
        $_SESSION['error'] = "خطا در حذف تصویر";
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// دریافت لیست کاربران
$users = [];
$sql = "SELECT * FROM signup ORDER BY id DESC";
$result = mysqli_query($link, $sql);
if ($result) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// ثبت خبر جدید
if(isset($_POST['submit_news'])) {
    $date = mysqli_real_escape_string($link, $_POST['date']);
    $subject = mysqli_real_escape_string($link, $_POST['subject']);
    $text = mysqli_real_escape_string($link, $_POST['text']);
    $image_name = '';

if(isset($_POST['submit_image'])) {
    $matn = mysqli_real_escape_string($link, $_POST['matn']);
    $matn1 = mysqli_real_escape_string($link, $_POST['matn1']);
    
    // بررسی و آپلود تصویر
    if(isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        $file_type = $_FILES['pic']['type'];
        $file_extension = strtolower(pathinfo($_FILES['pic']['name'], PATHINFO_EXTENSION));
        
        // بررسی نوع فایل و پسوند آن
        if(in_array($file_type, $allowed_types) && in_array($file_extension, ['jpeg', 'jpg', 'png', 'gif'])) {
            // ایجاد نام منحصربفرد برای فایل
            $pic_name = uniqid() . '_' . basename($_FILES['pic']['name']);
            $target_dir = "uploads/";
            
            // ایجاد پوشه آپلود اگر وجود ندارد
            if(!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            
            $target_path = $target_dir . $pic_name;
            
            // بررسی اندازه فایل (مثلاً حداکثر 5MB)
            if($_FILES['pic']['size'] > 5000000) {
                $_SESSION['error'] = "حجم فایل نباید بیشتر از 5 مگابایت باشد";
            } elseif(move_uploaded_file($_FILES['pic']['tmp_name'], $target_path)) {
                // ثبت در دیتابیس
                $sql = "INSERT INTO negarkhane (matn, matn1, pic) 
                        VALUES (?, ?, ?)";
                
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "sss", $matn, $matn1, $pic_name);
                
                if(mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = "تصویر با موفقیت ثبت شد";
                } else {
                    $_SESSION['error'] = "خطا در ثبت خبر: " . mysqli_error($link);
                }
                mysqli_stmt_close($stmt);
            } else {
                $_SESSION['error'] = "خطا در آپلود تصویر";
            }
        } else {
            $_SESSION['error'] = "فقط تصاویر با فرمت JPG, JPEG, PNG یا GIF مجاز هستند";
        }
    } else {
        $error_msg = $_FILES['pic']['error'] == 4 ? "لطفاً یک تصویر انتخاب کنید" : "خطا در آپلود فایل";
        $_SESSION['error'] = $error_msg;
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
}
// ثبت تصویر نگار خانه جدید
if(isset($_POST['submit_image'])) {
    $matn = mysqli_real_escape_string($link, $_POST['matn']);
    $matn1 = mysqli_real_escape_string($link, $_POST['matn1']);
    $pic_name = '';

    // بررسی و آپلود تصویر
    if(isset($_FILES['pic']) && $_FILES['pic']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png','image/jpg'];
        $file_type = $_FILES['image']['type'];
        
        if(in_array($file_type, $allowed_types)) {
            $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $target_path = "uploads/" . $pic_name;
            
            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                // ثبت خبر در دیتابیس
                $sql = "INSERT INTO negarkhane (matn, matn1, pic) 
                        VALUES ('$matn', '$matn1', '$pic_name')";
                
                if(mysqli_query($link, $sql)) {
                    $_SESSION['message'] = "تصویر با موفقیت ثبت شد";
                } else {
                    $_SESSION['error'] = "خطا در ثبت خبر";
                }
            } else {
                $_SESSION['error'] = "خطا در آپلود تصویر";
            }
        } else {
            $_SESSION['error'] = "فقط تصاویر با فرمت Jpeg,JPG, PNG یا GIF مجاز هستند";
        }
    } else {
        $_SESSION['error'] = "لطفاً یک تصویر انتخاب کنید";
    }
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; padding-top: 20px; }
        .card { margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .table th { background-color: #f1f1f1; }
    </style>
</head>
<body>
<div class="container">
    <!-- پیام‌های سیستم -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- هدر پنل -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4">پنل مدیریت</h1>
        <a href="logout1.php" class="btn btn-outline-danger">خروج از سیستم</a>
    </div>

    <!-- لیست کاربران -->
    <div class="card">
        <div class="card-header bg-light">
            <h2 class="h5 mb-0">لیست ثبت‌نام‌ها</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>نام کامل</th>
                            <th>کد ملی</th>
                            <th>تلفن‌ها</th>
                            <th>تاریخ ثبت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($user['name'] . ' ' . $user['family']) ?></td>
                            <td><?= htmlspecialchars($user['codemeli']) ?></td>
                            <td>
                                <small>پدر: <?= htmlspecialchars($user['tellpedar']) ?></small><br>
                                <small>فرزند: <?= htmlspecialchars($user['tellfarzand']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="view/view_user.php?id=<?= $user['id'] ?>" class="btn btn-info">نمایش</a>
                                    <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-warning">ویرایش</a>
                                    <a href="?delete_id=<?= $user['id'] ?>" class="btn btn-danger" 
                                       onclick="return confirm('آیا از حذف این کاربر مطمئن هستید؟')">حذف</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <br><br>

            <?php
            // دریافت لیست اخبار ها
    $News = [];
    $sql = "SELECT * FROM news ORDER BY id DESC";
    $result = mysqli_query($link, $sql);
    if ($result) {
    $Newss = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
            ?>
            <div class="card-header bg-light">
            <h2 class="h5 mb-0">لیست اخبار ها</h2>
        </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>تاریخ خبر</th>
                            <th>موضوع خبر </th>
                            <th>تصویر خبر</th>
                            <th>متن خبر </th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($Newss as $index => $News): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($News['date']) ?></td>
                            <td><?= htmlspecialchars($News['subject']) ?></td>
                            <td><img src="<?= htmlspecialchars($News['image']) ?>"></td>
                            <td><?= htmlspecialchars($News['text']) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="view/view_News.php?id=<?= $News['id'] ?>" class="btn btn-info">نمایش</a>
                                    <a href="edit_user.php?id=<?= $News['id'] ?>" class="btn btn-warning">ویرایش</a>
                                    <a href="?delete_id=<?= $News['id'] ?>" class="btn btn-danger" 
                                       onclick="return confirm('آیا از حذف این اخبار مطمئن هستید؟')">حذف</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <br><br>
            <?php
            // دریافت لیست نگار خانه
        $gallery = [];
        $sql = "SELECT * FROM negarkhane ORDER BY id DESC";
        $result = mysqli_query($link, $sql);
            if ($result) {
             $gallerys = mysqli_fetch_all($result, MYSQLI_ASSOC);
         }
            ?>
            <div class="card-header bg-light">
            <h2 class="h5 mb-0">لیست عکس های نگارخانه</h2>
        </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>موضوع عکس</th>
                            <th>متن نگارخانه</th>
                            <th>تصویر نگارخانه</th>
                            <th></th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gallerys as $index => $gallery): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($gallery['matn']) ?></td>
                            <td><?= htmlspecialchars($gallery['matn1']) ?></td>
                            <td><?= htmlspecialchars($gallery['pic']) ?></td>
                            <td></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="view/view_gallery.php?id=<?= $gallery['id'] ?>" class="btn btn-info">نمایش</a>
                                    <a href="edit_user.php?id=<?= $gallery['id'] ?>" class="btn btn-warning">ویرایش</a>
                                    <a href="?delete_id=<?= $gallery['id'] ?>" class="btn btn-danger" 
                                       onclick="return confirm('آیا از حذف این تصویر مطمئن هستید؟')">حذف</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- فرم ثبت خبر -->
    <div class="card">
        <div class="card-header bg-light">
            <h2 class="h5 mb-0">ثبت خبر جدید</h2>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="date" class="form-label">تاریخ خبر</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label for="subject" class="form-label">موضوع خبر</label>
                        <input type="text" name="subject" id="subject" class="form-control" required>
                    </div>
                    
                    <div class="col-12">
                        <label for="image" class="form-label">تصویر خبر</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">فرمت‌های مجاز: JPG, PNG, GIF</small>
                    </div>
                    
                    <div class="col-12">
                        <label for="text" class="form-label">متن خبر</label>
                        <textarea name="text" id="text" rows="5" class="form-control" required></textarea>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" name="submit_news" class="btn btn-primary">
                            ثبت خبر
                        </button>
                    </div>
                </div>
            </form>
            <br><br>
            <form action="" method="post" enctype="multipart/form-data">
    <div class="card-header bg-light">
        <h2 class="h5 mb-0">ثبت عکس های نگارخانه</h2>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label for="matn" class="form-label">موضوع عکس:</label>
            <input type="text" name="matn" id="matn" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="matn1" class="form-label">متن عکس:</label>
            <input type="text" name="matn1" id="matn1" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="pic" class="form-label">آپلود عکس:</label>
            <input type="file" name="pic" id="pic" class="form-control" accept="image/jpeg, image/png, image/jpg, image/gif" required>
        </div>
        
        <div class="col-12">
            <button type="submit" name="submit_image" class="btn btn-primary">
                ثبت عکس
            </button>
        </div>
    </div>
</form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html