<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/sources/login.css"/>
<<<<<<< HEAD
=======
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="half-circle"></div>
        <div class="image-container"><img src="/sources/technicain/img/Untitled-5 1.png" alt=""></div>
        <div class="form-container">
    <h2>اهلا وسهلا</h2>
    <p>سجل دخولك لإدارة وتشغيل النظام </p>
    
    <div class="error">
    @if($errors->has('status'))
    <b style="color:Red">لقد حصلت على خطا : {{ $errors->first('status')  }}</b>
    @endif 
    </div>
    <form action="{{ route('login.employee.start') }}" method="post">
        @csrf

        <label for="login_emial">اسم االمستخدم/الايميل</label>
        <input type="emial" name="login_emial" id="login_emial">

        <label for="login_password">كلمة المرور</label>
        <input type="password" name="login_password" id="login_password">
        <div class="options">
        <label><input type="checkbox">تذكرني</label>
        <a href="#">نسيت كلمة المرور؟</a>
    </div>
    <button type="submit" value="Login">تسجيل الدخول</button>
        <p>لاتمتلك حسابا؟ <a href="#">سجل هنا</a></p>

    </form>

</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
>>>>>>> MD
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="half-circle"></div>
        <div class="image-container"><img src="/sources/technicain/img/Untitled-5 1.png" alt=""></div>
        <div class="form-container">
    <h2>اهلا وسهلا</h2>
    <p>سجل دخولك لإدارة وتشغيل النظام </p>
    
    <div class="error">
    @if($errors->has('status'))
    <b style="color:Red">لقد حصلت على خطا : {{ $errors->first('status')  }}</b>
    @endif 
    </div>
    <form action="{{ route('login.employee.start') }}" method="post">
        @csrf

        <label for="login_emial">اسم االمستخدم/الايميل</label>
        <input type="emial" name="login_emial" id="login_emial">

        <label for="login_password">كلمة المرور</label>
        <input type="password" name="login_password" id="login_password">
        <div class="options">
        <label><input type="checkbox">تذكرني</label>
        <a href="#">نسيت كلمة المرور؟</a>
    </div>
    <button type="submit" value="Login">تسجيل الدخول</button>
        <p>لاتمتلك حسابا؟ <a href="#">سجل هنا</a></p>

    </form>

</body>
</html> -->