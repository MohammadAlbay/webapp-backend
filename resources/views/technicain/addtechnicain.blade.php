<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
</body>

</html>