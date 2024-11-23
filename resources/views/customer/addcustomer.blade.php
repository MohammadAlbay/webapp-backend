<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/sources/signup.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    
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

        .submit-section {
            margin-top: 20px; /* Add space above the button */
        }

        .submit-section button {
            background-color: #28a745; /* Change the button color */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px; /* Increase the font size */
            padding: 10px 20px; /* Increase the padding for a larger button */
            border-radius: 5px; /* Add some rounded corners */
            display: block; /* Make the button a block-level element */
            margin: 0 auto; /* Center the button horizontally */
        }
    </style>
</head>

<body>

  <div class="wrapper">
    <div class="grid-container">
         <!-- القسم الأول: الصورة -->
         <div class="image-section">
            <h1>إنشاء حساب عميل</h1>
            <img class="img" src="/sources/img/image.png" alt="">
        </div>
        
        <!-- القسم الثاني: المدخلات من اسم المستخدم إلى تأكيد كلمة المرور -->
        <div class="input-section">
            <form action="{{route('signup.create')}}" method="post">
                @csrf
                <input type="text" name="signup_type" value="customer" style="display:none">
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
                    <label>إسم المستخدم</label>
                    <input id="technicain_field_name" type="text" name="signup_name" placeholder="ادخل اسم المستخدم" required>
                </div>

                <div class="input-group">
                    <label>الإيميل</label>
                    <input type="text" name="signup_email" placeholder="example@gmail.com" required>
                </div>
                <div class="input-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="signup_phone" placeholder="09********" required>
                </div>

                <div class="input-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="signup_password" placeholder="ادخل كلمة المرور" required>
                </div>
                <div class="input-group">
                    <label>تاكيد كلمة المرور</label>
                    <input type="password" name="signup_password2" placeholder="تاكيد كلمة المرور" required>
                </div>
            </div>
                      <!-- القسم الثالث: المدخلات من المدينة إلى الوصف -->
                      <div class="city-section">
                          <div class="input-group">
                              <label>المدينة</label>
                              <select name="signup_address" class="select" required>
                                  @include('addresses-option');
                              </select>
                          </div>

                          <div class="input-group">
                              <label>الجنسية</label>
                              <select name="signup_nationality" class="select" required>
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
                      </div>
                    </div>

                    <div class="submit-section">
                        <button id="submit_button" type="submit">تسجيل</button>
                    </div>
                </form>
            </div>
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