<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
   <link rel="stylesheet" href="/public/sources/signup.css">
    <title>تسجيل عميل</title>

</head>
<body>
<img class="s" src="/public/sources/img/فني لعندك.png"> </img>
 <div class="wrapper">
<div class="from-wrapper">
<form action="{{route('posts.store')}}" method="post">
<h1>انشاء حساب </h1>
@csrf
<div class="center">
<img  class="img" src="/public/sources/img/image.png" alt="" >
<img  class="icon" src="/public/sources/img/Green-Add-Button-PNG (1).png (1).png" alt="" >
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
    <br>
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
    <div class="sub">
        
    <button type="submit">تسجيل</button>  
    </div>
</form>
</div>  
</div>
</body>
</html>