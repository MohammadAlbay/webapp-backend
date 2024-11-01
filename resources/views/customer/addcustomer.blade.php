<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/sources/signup.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    
    <title>تسجيل عميل</title>

    <style>
        .err-group {
            background-color: red;
            color: whitesmoke;
            direction: rtl;
        }
    </style>
</head>

<body>
<header>
   <nav>
   <div class="btn-login">
   <a  class="sinup" href="{{ route('login.index')}}">تسجيل الدخول</a>
   </div> 
   <img class="logo" src="/sources/img/فني لعندك.png"> </img>
   <i  id="btnmenu"class="fa-solid fa-bars"></i><!--عند تصغير الشاشة تظهر-->
   </nav>
</header>
    <div class="wrapper">
    <div class="grid-container">
    <!-- القسم الأول: الصورة -->
    <div class="image-section">
    <h1>انشاء حساب</h1>
                    <img class="img" src="/sources/img/image.png" alt="">
                    <img class="icon" src="/sources/img/Green-Add-Button-PNG (1).png" alt="">
                </div>
             
        <!-- القسم الثاني: المدخلات من اسم المستخدم إلى تأكيد كلمة المرور -->
        <div class="input-section">
        <form action="{{route('signup.create')}}" method="post">
               
               @csrf
               <input type="text" value="customer" name="signup_type" style="display:none">
               
           </form> 
                @if ($errors->any())
                <div class="input-group err-group">
                    @foreach ($errors->all() as $error)
                    <b>{{$error}}</b><br>
                    @endforeach
                </div>
                @elseif(session('success'))
                <div class="input-group" style="background-color:green; color:white">
                    {{ session('success') }}
                </div>
                @endif
                <div class="input-group">
                    <label>اسم المستخدم</label>
                    <input type="text" name="signup_name" placeholder="ادخل اسم المستخدم">
                </div>
                <div class="input-group">
                    <label>الايميل</label>
                    <input type="text" name="signup_email" placeholder="example@gmail.com">
                </div>
                <div class="input-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="signup_phone" placeholder="09********">
                </div>
                <div class="input-group">
                    <label>كلمة المرور</label>
                    <input type="text" name="signup_password" placeholder="ادخل كلمة المرور">
                </div>
                <div class="input-group">
                    <label>تاكيد كلمة المرور</label>
                    <input type="text" name="signup_password2" placeholder="تاكيد كلمة المرور"> 
                </div>
        </div>
          <!-- القسم الثالث: المدخلات من المدينة إلى الوصف -->
          <div class="city-section">
                <div class="input-group">
                    <label>المدينة</label>
                    <br>
                    <select name="signup_address" class="select">
                        @include('addresses-option');
                    </select>
                    <br>
                </div>
                <!-- <div class="input-group">
                    <label>الجنسية</label>
                    <br>
                    <select name="cties" id="" class="select">
                        <option value="city1">ليبي</option>
                        <option value="city1">مصري</option>
                        <option value="city1">تونسي</option>
                        <option value="city1">اخرى</option>
                    </select>
                    <br>
                </div> -->
                <div class="input-group">
                    <label>تاريخ الميلاد</label>
                    <br>
                    <input type="date" name="signup_birthdate" required>
                    <br>
                </div>
                <div class="gander-selection">
                    <label>الجنس</label>
                    <div class="options">
                    <div>
                        <input type="radio" name="signup_gender" class="checkbox" value="Female">
                        <label class="checkbox" for="Female">انثى</label>
                    </div>
                    <div>
                        <input type="radio" name="signup_gender" class="checkboxl" value="Male">
                        <label class="checkbox" for="Male">ذكر</label>
                    </div>
                    </div>
                </div>
                </div>
                </div>
              <!-- زر التسجيل أسفل الأقسام الثلاثة -->
              <div class="submit-section">
                <br>
                <button type="submit">تسجيل</button>  
              </div>
        </div>
</body>
</html>