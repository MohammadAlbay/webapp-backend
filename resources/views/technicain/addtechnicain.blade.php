<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
   
  <!--  <div class="titleimg"> <img src="./imge/فني لعندك.png"> </img></div>-->
  <img class="s" src="/public/sources/img/فني لعندك.png"> </img>
   <div class="wrappert">
<div class="from-wrapper">
<form action="{{route('posts.store')}}" method="post">
@csrf
<h1>انشاء حساب فني</h1>
<div class="center">
<img  class="img" src="/public/sources/img/image.png" alt="" >
<img  class="icon" src="/public/sources/img/Green-Add-Button-PNG (1).png" alt="" >
</div>
<div class="input-group">
    <label>اسم المستخدم</label>
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
    <link rel="stylesheet" href="/sources/signup.css">
    <title>تسجيل فني</title>

    <style>
        .err-group {
            background-color: red;
            color: whitesmoke;
            direction: rtl;
        }
    </style>
</head>

<body>
    <img class="s" src="/public/sources/img/فني لعندك.png"> </img>
    <div class="wrappert">

        <div class="from-wrapper">

            <form action="{{route('signup.create')}}" method="post">
                @csrf
                <input type="text" name="signup_type" value="technicain" style="display:none">
                <h1>انشاء حساب فني</h1>

                <div class="center">
                    <img class="img" src="/public/sources/img/image.png" alt="">
                    <img class="icon" src="/public/sources/img/Green-Add-Button-PNG (1).png" alt="">
                </div>
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
                    <br>
                    <input type="text" name="signup_name" placeholder="ادخل اسم المستخدم" required>
                    <br>
                </div>
                <div class="input-group">
                    <label>الايميل</label>
                    <br>
                    <input type="text" name="signup_email" placeholder="example@gmail.com" required>
                    <br>
                </div>
                <div class="input-group">
                    <label>رقم الهاتف</label>
                    <br>
                    <input type="text" name="signup_phone" placeholder="09********" required>
                    <br>
                </div>
                <div class="input-group">
                    <label>كلمة المرور</label>
                    <br>
                    <input type="text" name="signup_password" placeholder="ادخل كلمة المرور" required>
                    <br>
                </div>
                <div class="input-group">
                    <label>تاكيد كلمة المرور</label>
                    <br>
                    <input type="text" name="signup_password2" placeholder="تاكيد كلمة المرور" required>
                    <br>
                </div>
                <div class="input-group">
                    <label>المدينة</label>
                    <br>
                    <select name="signup_address" id="" class="select" required>
                        @include('addresses-option');
                    </select>
                </div>
                <div class="input-group">
                    <label>الجنسية</label>
                    <br>
                    <select name="signup_nationality" id="" class="select" required>
                        <option value="city1">ليبي</option>
                        <option value="city1">مصري</option>
                        <option value="city1">تونسي</option>
                        <option value="مغربي">مغربي</option>
                        <option value="موريتاني">موريتاني</option>
                        <option value="جزائري">جزائري</option>
                        <option value="city1">نيجري</option>
                        <option value="city1">سوداني</option>
                        <option value="city1">تشادي</option>
                        <option value="city1">اسيوي</option>
                        <option value="city1">اوروبي</option>
                        <option value="city1">اخرى</option>
                        <option value="ليبي">ليبي</option>
                    </select>
                    <br>
                </div>
                <div class="input-group">
                    <label>التخصصات</label>
                    <br>
                    <select name="signup_specialization" id="" class="select" required>
                        @foreach ($specializations as $s)
                        <option value="{{$s->id}}">{{$s->name}}</option>
                        @endforeach
                    </select>
                    <br>
                </div>
                <div class="input-group">
                    <label>التخصصات</label>
                    <br>
                    <input type="date" name="signup_birthdate" required>
                    <br>
                </div>
                <div class="checkbox">
                    <label>الجنس</label>
                    <br>
                    <label>
                        <input type="radio" name="signup_gender" class="checkboxr" value="Female">
                        <label class="checkboxr">انثى</label>
                    </label>
                    <label>
                        <label class="checkboxl">ذكر</label>
                        <input type="radio" name="signup_gender" class="checkboxl" value="Male">
                    </label>
                    <br>
                </div>
                <div class="input-groupt">
                    <label> (اختياري) الوصف</label>
                    <br>
                    <input type="text" name="signup_desc" placeholder="اكتب ما تريد">
                    <br>
                </div>
                <div class="sub">

                    <button type="submit">تسجيل</button>
                </div>
        </div>

        </form>
    </div>
    </div>
>>>>>>> MD
</body>

</html>