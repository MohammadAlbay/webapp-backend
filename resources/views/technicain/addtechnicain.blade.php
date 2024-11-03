<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/sources/signup.css">
    <title>تسجيل فني</title>

    <style>
        .err-group {
            background-color: red;
            color: whitesmoke;
            direction: rtl;
        }

        .disabled {
            pointer-events: none;
            cursor:not-allowed;
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
                    <input id="technicain_field_name" type="text" name="signup_name" placeholder="ادخل اسم المستخدم" required>
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
                        <option value="ليبي">ليبي</option>
                        <option value="مصري">مصري</option>
                        <option value="تونسي">تونسي</option>
                        <option value="مغربي">مغربي</option>
                        <option value="موريتاني">موريتاني</option>
                        <option value="جزائري">جزائري</option>
                        <option value="نيجري">نيجري</option>
                        <option value="سوداني">سوداني</option>
                        <option value="تشادي">تشادي</option>
                        <option value="اسيوي">اسيوي</option>
                        <option value="اوروبي">اوروبي</option>
                        <option value="اخرى">اخرى</option>
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
                    <input id="desc_field" type="text" name="signup_desc" placeholder="اكتب ما تريد">
                    <br>
                </div>
                <div class="sub">

                    <button id="submit_button" type="submit">تسجيل</button>
                </div>
        </div>

        </form>
    </div>
    </div>
    <script src="/bad-word/word.js"></script>
    <script>
        document.getElementById('technicain_field_name')
            .addEventListener('change', e => {
                let btn = document.getElementById('submit_button');
                if(isDirty(e.target.value)) {
                    btn.classList.toggle('disabled', true);
                    Swal.fire({
                        icon: 'warning',
                        title: ' الفاظا بذيئة',
                        text: 'اكتشف النظام الفاظا اذيئة كنت قد ادخلتها في احد حقول الادخال. لن تتمكن من المتابعة حتى تعدل ما ادخلته',
                        timer: 4200,
                        timerProgressBar: true,
                        showConfirmButton:false
                    });
                }
                else 
                    btn.classList.toggle('disabled', false);
            });

            document.getElementById('desc_field')
            .addEventListener('change', e => {
                let btn = document.getElementById('submit_button');
                if(isDirty(e.target.value)) {
                    btn.classList.toggle('disabled', true);
                    Swal.fire({
                        icon: 'warning',
                        title: ' الفاظا بذيئة',
                        text: 'اكتشف النظام الفاظا اذيئة كنت قد ادخلتها في احد حقول الادخال. لن تتمكن من المتابعة حتى تعدل ما ادخلته',
                        timer: 4200,
                        timerProgressBar: true,
                        showConfirmButton:false
                    });
                }
                else 
                    btn.classList.toggle('disabled', false);
            });
    </script>
</body>

</html>