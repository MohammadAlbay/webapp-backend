<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/sources/signup.css">
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
    <img class="s" src="/public/sources/img/فني لعندك.png"> </img>
    <div class="wrapper">
        <div class="from-wrapper">
            <form action="{{route('signup.create')}}" method="post">
                <h1>انشاء حساب </h1>
                @csrf
                <input type="text" value="customer" name="signup_type" style="display:none">
                <div class="center">
                    <img class="img" src="/public/sources/img/image.png" alt="">
                    <img class="icon" src="/public/sources/img/Green-Add-Button-PNG (1).png (1).png" alt="">
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
                    <input type="text" name="signup_name" placeholder="ادخل اسم المستخدم">
                    <br>
                </div>
                <div class="input-group">
                    <label>الايميل</label>
                    <br>
                    <input type="text" name="signup_email" placeholder="example@gmail.com">
                    <br>
                </div>
                <div class="input-group">
                    <label>رقم الهاتف</label>
                    <br>
                    <input type="text" name="signup_phone" placeholder="09********">
                    <br>
                </div>
                <div class="input-group">
                    <label>كلمة المرور</label>
                    <br>
                    <input type="text" name="signup_password" placeholder="ادخل كلمة المرور">
                    <br>
                </div>
                <div class="input-group">
                    <label>تاكيد كلمة المرور</label>
                    <br>
                    <input type="text" name="signup_password2" placeholder="تاكيد كلمة المرور">
                    <br>
                </div>
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
                <div class="sub">

                    <button type="submit">تسجيل</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>