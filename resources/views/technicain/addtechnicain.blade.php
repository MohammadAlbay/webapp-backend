<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
<<<<<<< HEAD
=======
<<<<<<< HEAD
    <link rel="stylesheet" href="/public/sources/signup.css">
    <title>تسجيل فني</title>
</head>

<body>
 <!--   <h1>Hi!. This is signup view</h1>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>-->
  <header>
    <nav>
        <div class="btn-login">
        <a  class="sinup" href="#">تسجيل الدخول</a>
        </div> 
        <img class="logo" src="/public/sources/img/فني لعندك.png"> </img>
        <i  id="btnmenu"class="fa-solid fa-bars"></i><!--عند تصغير الشاشة تظهر-->
    </nav>
   </header>
   <div class="wrappert">
<div class="from-wrapper">
<form action="{{route('posts.store')}}" method="post">

<h1>انشاء حساب فني</h1>
<div class="center">
<img  class="img" src="/public/sources/img/image.png" alt="" >
<img  class="icon" src="/public/sources/img/Green-Add-Button-PNG (1).png" alt="" >
</div>
<div class="input-group">
    <label>اسم المستخدم</label>
    @csrf
    <br>
    <input type="text" name="name" placeholder="ادخل اسم المستخدم">
    <br>
    </div>
    <div class="input-group">
    <label>الايميل</label>
    <br>
    <input type="text" name="email" placeholder="example@gmail.com">
    <br>
    </div>
    <div class="input-group">
    <label>رقم الهاتف</label>
    <br>
    <input type="text" name="phone" placeholder="09********">
    <br>
    </div>
    <div class="input-group">
    <label>كلمة المرور</label>
    <br>
    <input type="text" name="password" placeholder="ادخل كلمة المرور">
    <br>
    </div>
    <div class="input-group">
    <label>تاكيد كلمة المرور</label>
    <br>
    <input type="text" name="confirm-password" placeholder="تاكيد كلمة المرور">
    <br>
    </div>
    <div class="input-group">
    <label>المدينة</label>
    <br>
    <select name="cties" id="" class="select">
        <option value="city1">طرابلس</option>
        <option value="city1">مصراتة</option>
        <option value="city1">بنغازي</option>
        <option value="city1">سبها</option>
    </select>   
    </div>
    <div class="input-group">
    <label>الجنسية</label>
    <br>
    <select name="cties" id="" class="select">
        <option value="city1">ليبي</option>
        <option value="city1">مصري</option>
        <option value="city1">تونسي</option>
        <option value="city1">اخرى</option>
    </select>
    <br>
    </div>
    <div class="input-group">
    <label>التخصصات</label>
    <br>
    <select name="cties" id="" class="select">
        <option value="city1">سباكة</option>
        <option value="city1">صيانة مكيفات</option>
        <option value="city1">تنظيف</option>
        <option value="city1">اخرى</option>
    </select>
    <br>
    </div>
    <div class="checkbox">
    <label>الجنس</label>
    <br>
    <label>
    <input type="radio" name="op1" class="checkboxr" value="left">
     <label class="checkboxr" >انثى</label>    
    </label>
    <label>
    <label class="checkboxl" >ذكر</label> 
    <input type="radio" name="op2" class="checkboxl" value="right">
    </label>
    <br>
    </div>
    <div class="input-groupt">
    <label> (اختياري) الوصف</label>
    <br>
    <input type="text" name="password" placeholder="اكتب ما تريد">
    <br>
    </div>
    <div class="sub">
        
    <button type="submit">تسجيل</button>  
    </div>
    </div>
   
</form>
</div>  
</div>
=======
>>>>>>> 87f94ea18b1a44b6799a06c8c4a04a016d582c58
    <link rel="stylesheet" href="/sources/signup.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    
    <title>تسجيل فني</title>

    <style>
        .err-group {
            background-color: red;
            color: whitesmoke;
            direction: rtl;
            font-size: 12px;
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
  <!--  <img class="s" src="/public/sources/img/فني لعندك.png"> </img>-->
    <div class="wrapper">
    <div class="grid-container">
         <!-- القسم الأول: الصورة -->
         <div class="image-section">
        <h1>انشاء حساب فني</h1>
       <!-- <img class="img" src="./imge/Hero-section.png" alt="">-->
        <img class="img" src="/sources/img/image.png" alt="">
          <img class="icon" src="/sources/img/Green-Add-Button-PNG (1).png" alt="">
        </div>
        
        <!-- القسم الثاني: المدخلات من اسم المستخدم إلى تأكيد كلمة المرور -->
        <div class="input-section">
            <form action="{{route('signup.create')}}" method="post">
                @csrf
                <input type="text" name="signup_type" value="technicain" style="display:none">
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
                    <input type="text" name="signup_name" placeholder="ادخل اسم المستخدم" required>
                </div>

                <div class="input-group">
                    <label>الايميل</label>
                    <input type="text" name="signup_email" placeholder="example@gmail.com" required>
                </div>
                <div class="input-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="signup_phone" placeholder="09********" required>
                </div>

                <div class="input-group">
                    <label>كلمة المرور</label>
                    <input type="text" name="signup_password" placeholder="ادخل كلمة المرور" required>
                </div>
                <div class="input-group">
                    <label>تاكيد كلمة المرور</label>
                    <input type="text" name="signup_password2" placeholder="تاكيد كلمة المرور" required>
                </div>
    </div>
                      <!-- القسم الثالث: المدخلات من المدينة إلى الوصف -->
                      <div class="city-section">
                      <div class="input-group">
                    <label>المدينة</label>
                    <br>
                    <select name="signup_address" id="" class="select" required>
                        <option value="city1">طرابلس</option>
                        <option value="city1">مصراتة</option>
                        <option value="city1">بنغازي</option>
                        <option value="city1">سبها</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>الجنسية</label>
                    <br>
                    <select name="signup_nationality" id="" class="select" required>
                        <option value="city1">ليبي</option>
                        <option value="city1">مصري</option>
                        <option value="city1">تونسي</option>
                        <option value="city1">نيجري</option>
                        <option value="city1">سوداني</option>
                        <option value="city1">تشادي</option>
                        <option value="city1">اسيوي</option>
                        <option value="city1">اوروبي</option>
                        <option value="city1">اخرى</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>التخصصات</label>
                    <br>
                    <select name="signup_specialization" id="" class="select" required>
                        @foreach ($specializations as $s)
                        <option value="{{$s->id}}">{{$s->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="signup_birthdate" required>
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

                <div class="input-groupt">
                    <label> (اختياري) الوصف</label>
                    <input type="text" name="signup_desc" placeholder="اكتب ما تريد">
                </div>
            </div>
         </div>

         <!-- زر التسجيل أسفل الأقسام الثلاثة -->
            <div class="submit-section">
                <button type="submit">تسجيل</button>  
            </div>
        </div>
<<<<<<< HEAD
=======

        </form>
    </div>
    </div>
>>>>>>> MD
>>>>>>> 87f94ea18b1a44b6799a06c8c4a04a016d582c58
</body>
</html>