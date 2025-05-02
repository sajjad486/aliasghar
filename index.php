<?php include("header.php"); ?>
<!-- Sub Header -->
<div class="sub-header">
  <div class="container" style="font-size: 20px;padding: 10px;">
    <?php
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
      echo '<div style="text-align: left;">';
      echo '<a href="logout.php" style="color: #f44336;">خروج</a>';
      echo '<span> / </span>';
      echo '</div>';
    } else {
      echo '<a href="login.php" style="text-align: right;">ورود</a>';
      echo '<a href="#" style="text-align: right;">/</a>';
      echo '<a href="signup.php" style="text-align: right;">ثبت نام</a>';
    }
    ?>
  </div>
</div>

<header class="header-area header-sticky">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">
          <div class="partishen">
            <ul class="nav">
              <li class="scroll-to-section"><a href="#top" class="active">خانه</a></li>
              <li><a href="#meetings">اخبار</a></li>
              <li class="scroll-to-section"><a href="#courses">نگارخانه</a></li>
              <li class="has-sub">
                <a href="javascript:void(0)">مسئولان</a>
                <ul class="sub-menu">
                  <li><a href="#">هیئت امنا</a></li>
                  <li><a href="#">فرهنگی</a></li>
                  <li><a href="#">تبلیغات</a></li>
                  <li><a href="#">ورزشی</a></li>
                </ul>
              </li>
              <li class="scroll-to-section"><a href="#apply">درباره</a></li>
              <li class="scroll-to-section"><a href="#contact">ارتباط با</a></li>
            </ul>
          </div>
          <a class='menu-trigger'>
            <span>Menu</span>
          </a>
        </nav>
      </div>
    </div>
  </div>
</header>

<!-- ***** Main Banner Area Start ***** -->
<section class="section main-banner" id="top" data-section="section1">
  <video autoplay muted loop id="bg-video">
    <source src="assets/images/aliasghar-video.mp4" type="video/mp4" />
  </video>

  <div class="video-overlay header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="caption">
            <h6>بسم الله الرحمن الرحیم</h6>
            <h2>هیئت حضرت علی اصغر</h2>
            <p>
              صبح های جمعه برنامه قرائت قرآن و مدیحه سرایی.سخنرانی و اهدائ جوایز و اردو های سیاحتی و زیارتی
            </p>
            <div class="main-button-red">
              <div><a href="signup.php">عضویت در هیئت</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ***** Main Banner Area End ***** -->

<section class="services" dir="ltr">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="owl-service-item owl-carousel">

          <div class="item">
            <div class="icon">
              <img src="assets/images/service-icon-01.png" alt="">
            </div>
            <div class="down-content">
              <h4>اردو های تفریحی</h4>
              <p>اردوهای تفریحی با هیئت مذهبی، لحظاتی شاد و معنوی را در دل طبیعت به ارمغان می‌آورند. این برنامه‌ها فرصتی برای زیارت، تقویت ایمان و ایجاد خاطراتی زیبا با دوستان همفکر هستند.</p>
            </div>
          </div>

          <div class="item">
            <div class="icon">
              <img src="assets/images/service-icon-02.png" alt="">
            </div>
            <div class="down-content">
              <h4>جلسه های قرآنی</h4>
              <p>جلسه‌های قرآنی، محفل انس با کلام الهی و فضایی سرشار از نور و آرامش هستند. در این گردهمایی‌های معنوی، دل‌ها با تلاوت آیات قرآن زنده و جان‌ها با تفاسیر عمیق آن به روشنی هدایت می‌شوند. بیایید با حضور در این جلسات، به سفر در دنیای معنویت و ارتباط نزدیک‌تر با خداوند بپردازیم.</p>
            </div>
          </div>

          <div class="item">
            <div class="icon">
              <img src="assets/images/service-icon-03.png" alt="">
            </div>
            <div class="down-content">
              <h4>جوایز ویژه قرآنی</h4>
              <p>در مجالس قرآنی، جوایز ویژه‌ای برای کسانی که قرآن را حفظ یا یاد می‌گیرند اهدا می‌شود. این جوایز، انگیزه‌ای برای تقویت ارتباط با کلام الهی و ترویج آموزه‌های قرآنی است.</p>
            </div>
          </div>

          <div class="item">
            <div class="icon">
              <img src="assets/images/service-icon-02.png" alt="">
            </div>
            <div class="down-content">
              <h4>نظرات و پیشنهادات</h4>
              <p>نظرات و پیشنهادات ارزشمند شما راهنمایی روشن برای بهبود و ارتقاء فعالیت‌های ماست. لطفاً با اشتراک‌گذاری دیدگاه‌های خود، در این مسیر ما را همراهی کنید.</p>
            </div>
          </div>

          <div class="item">
            <div class="icon">
              <img src="assets/images/service-icon-03.png" alt="">
            </div>
            <div class="down-content">
              <h4>اطلاع از اخبار هر هفته</h4>
              <p>برای اطلاع از اخبار هفتگی هیئت مذهبی حضرت علی‌اصغر، با ما همراه باشید. اخبار برنامه‌ها، جلسات و رویدادهای معنوی هر هفته به‌صورت منظم منتشر می‌شود تا بتوانید از آخرین اطلاعات بهره‌مند شوید.</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
<section class="upcoming-meetings" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading">
          <h2>اخبار هیئت ما</h2>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <?php
          $sql = "SELECT * FROM news ORDER BY id DESC";
          $result = mysqli_query($link, $sql);

          while ($row = mysqli_fetch_array($result)) {
            $date = $row['date'];
            $image = 'uploads/' . $row['image'];
            $subject = $row['subject'];
            $text = $row['text'];
            echo '
              <div class="col-lg-4" style="width:33%">
                <div class="meeting-item">
                  <div class="thumb">
                    <div class="price">
                      <span>' . htmlspecialchars($date) . '</span>
                    </div>
                    <div>
                    <img src="' . htmlspecialchars($image) . '" alt="">
                  </div>
                    </div>
                  <div class="down-content">
                    <a href="meeting-details.html">
                      <h4>' . htmlspecialchars($subject) . '</h4>
                    </a>
                    <p style="color:black">' . htmlspecialchars($text) . '</p>
                  </div>
                </div>
              </div>';
          }
          mysqli_close($link);  
          ?>
        </div>
      </div>
    </div>
  </div>
</section>


<section class="apply-now" id="apply">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 align-self-center">
        <div class="row">
          <div class="col-lg-12">
            <div class="item">
              <h3>درباره ما</h3>
              <p>ما یک هیئت مذهبی هستیم که در حوزه مراسم های عذاداری و شادی و جلسات فعالیت میکنیم</p>
              <p>شما میتوانید در هیئت مذهبی ما ثبت نام کنید و با استفاده از استادان حرفه ای ما قرآن را به بهترین شکل یاد بگیرید</p>
              <p>اگر علاقه به یادگیری قرآن هستید</p>
              <p>پس همین حالا ثبت نام کن یا با ما تماس بگیر</p>
              <div class="main-button-red text-center">
                <div><a href="signup.php">ثبت نام</a></div><br>
                <div><a href="#contact">تماس با ما</a></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="accordions is-first-expanded">
          <article class="accordion">
            <div class="accordion-head">
              <span>کمی در مورد هیئت مذهبی ما</span>
              <span class="icon">
                <i class="icon fa fa-chevron-right"></i>
              </span>
            </div>
            <div class="accordion-body">
              <div class="content">
                <p class="text-white">هیئت ما یک هیئت مذهبی است که در آن جلسات و مراسم های عذاداری و شادی برگزار میشود که در هیئت ما اردو های سیاحتی و زیارتی هم برگزار میشود با جوایز ویژه در هیئت ما شما از طریق صفحه ثبت نام میتوانید ثبت نام خود را انجام بدهید و به عضوی از ما بپیوندید</p>
              </div>
            </div>
          </article>
          <article class="accordion">
            <div class="accordion-head">
              <span>اساتید ما</span>
              <i class="icon fa fa-chevron-right"></i>
              <div class="accordion-head">
              </div>
              <div class="accordion-body">
                <div class="content">
                  <p class="text-white">اساتید ما که همه آنها مسلط به زبان قرآن و حافظ کل قران هستند که یکی یکی آنها رو معرفی میکنیم</p>
                  <ol class="text-white ">
                    <li>مهدی شفیعی</li>
                    <li>غلامرضا قاسمی</li>
                    <li>سجاد محمدی</li>
                    <li>حاج حسین الله دادیان</li>
                  </ol>
                  <p class="text-white">که همه این افراد گفته شده حافظ کل قرآن و مدرس قرآن هستند در تمامی سنین از 5سال تا 60سال</p>
                </div>
              </div>
          </article>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  </div>
</section>

<section class="our-courses" id="courses" dir="ltr">
  <!DOCTYPE html>
  <html lang="fa" dir="rtl">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نگارخانه عمودی با بوت‌استرپ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      .vertical-carousel {
        height: 500px;
        overflow: hidden;
      }

      .vertical-carousel .carousel-inner {
        height: 100%;
      }

      .vertical-carousel .carousel-item {
        height: 100%;
        transition: transform 0.6s ease-in-out;
      }

      .vertical-carousel .carousel-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
      }

      .carousel-control-prev,
      .carousel-control-next {
        width: 5%;
      }
      .negar-khane{
        display: flex;
        justify-content:center;
        align-items: center;
        font-size: 25px;
        margin: 20px;
        padding: 2px;
      }
    </style>
  </head>

  <body>
    <div class="container mt-5">
      <h2 class="text-center mb-4">نگارخانه هیئت حضرت علی اصغر</h2>
      <a href="negar-khane.php" class="negar-khane">نگارخانه</a>

      <div id="verticalGallery" class="carousel slide vertical-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets/images/quran7.jpeg" class="d-block w-100" alt="تصویر 1">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="assets/images/quran6.jpeg" class="d-block w-100" alt="تصویر 2">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="assets/images/quran5.jpeg" class="d-block w-100" alt="تصویر 3">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="assets/images/quran4.jpeg" class="d-block w-100" alt="تصویر 4">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="assets/images/quran8.jpeg" class="d-block w-100" alt="تصویر 4">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
          <div class="carousel-item">
            <img src="assets/images/quran9.jpeg" class="d-block w-100" alt="تصویر 4">
            <div class="carousel-caption d-none d-md-block">
            </div>
          </div>
        </div>
        
        <button class="carousel-control-prev" type="button" data-bs-target="#verticalGallery" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#verticalGallery" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var myCarousel = document.getElementById('verticalGallery');
        var carousel = new bootstrap.Carousel(myCarousel, {
          interval: 5000,
          wrap: true,
          pause: false
        });
      });
    </script>
  </body>

  </html>
</section>

<section class="our-facts">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="row">
          <div class="col-lg-12">
            <h2>در مورد هیئت ما</h2>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="col-12">
                <div class="count-area-content percentage">
                  <div class="count-digit">94</div>
                  <div class="count-title">اعضای مجرب هیئت</div>
                </div>
              </div>
              <div class="col-12">
                <div class="count-area-content">
                  <div class="count-digit">10</div>
                  <div class="count-title">اساتید مجرب</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row">
              <div class="col-12">
                <div class="count-area-content new-students">
                  <div class="count-digit">3250</div>
                  <div class="count-title">اعضای فعلی</div>
                </div>
              </div>
              <div class="col-12">
                <div class="count-area-content">
                  <div class="count-digit">512</div>
                  <div class="count-title">جوایز</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 align-self-center">
        <img src="assets/images/quran4.jpeg">

      </div>
    </div>
  </div>
  </div>
</section>

<section class="contact-us" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 align-self-center">
        <div class="row">
          <div class="col-lg-12">
            <form id="contact" action="" method="post" enctype="multipart/form-data">
              <div class="row">
                <div class="col-lg-12">
                  <h2>ارتباط با ما</h2>
                </div>
                <div class="col-lg-4">
                  <form action="" method="post">
                    <fieldset>
                      <input name="name" type="text" id="name" placeholder="نام و نام خوانوادگی...*" required="">
                    </fieldset>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                    <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="ایمیل..." required="">
                  </fieldset>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                    <input name="subject" type="text" id="subject" placeholder="موضوع...*" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" type="text" class="form-control" id="message" placeholder="پیغام شما..." required=""></textarea>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="button">ارسال پیغام</button>
                  </fieldset>
            </form>
            <?php
            if (isset($_POST["name"])) {
              $sql = "insert into aliasghar.messages(username,email,subject,messages) values ('" . $_POST['name'] . "' , '" . $_POST['email'] . "' , '" . $_POST['subject'] . "' , '" . $_POST['message'] . "')";
              mysqli_query($link, $sql);
            }
            ?>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-3">
    <div class="right-info">
      <ul>
        <li>
          <h6>شماره تفلن</h6>
          <span>09936729280</span>
        </li>
        <li>
          <h6>آدرس ایمیل</h6>
          <span>sajjad017@mgail.com</span>
        </li>
        <li>
          <h6>ادرس</h6>
          <span>فلاورجان خیابان امام</span>
        </li>
        <li>
          <h6>ادرس وبسایت</h6>
          <span>www.aliasghar.com</span>
        </li>
      </ul>
    </div>
  </div>
  </div>
  </div>


  <?php include("footer.php"); ?>