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
                cursor: not-allowed;
            }

            /* Button styling */
            .submit-button {
                background-color: #28a745; 
                color: white; 
                padding: 10px 20px; 
                border: none; 
                border-radius: 5px;
                font-size: 16px; 
                cursor: pointer;
                margin-top: 10px;
                width: 300px; 
                transition: background-color 0.3s; 
            }

            .submit-button:hover {
                background-color: #11872a; /* Darker green on hover */
            }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <div class="grid-container">
                <div class="image-section">
                    <h1>إنشاء حساب فني</h1>
                    <img class="img" src="{{ asset('rahma-ui/storage/images/technician.png') }}"alt="">
                </div>
                
                <div class="input-section">
                    <form action="{{route('signup.create')}}" method="post" enctype="application/x-www-form-urlencoded">
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
                            <label>إسم المستخدم</label>
                            <br>
                            <input id="technicain_field_name" type="text" name="signup_name" placeholder="ادخل اسم المستخدم" required>
                            <br>
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
                            <label>تأكيد كلمة المرور</label>
                            <input type="password" name="signup_password2" placeholder="تاكيد كلمة المرور" required>
                        </div>

                        <!-- Submit Button with class -->
                        <button id="submit_button" type="submit" class="submit-button">تسجيل</button>

                    </div>

                    <div class="city-section">
                        <div class="input-group">
                            <label>المدينة</label>
                            <br>
                            <select name="signup_address" class="select" required>
                                @include('addresses-option');
                            </select>
                        </div>

                        <div class="input-group">
                            <label>الجنسية</label>
                            <br>
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
                            <label>التخصصات</label>
                            <br>
                            <select name="signup_specialization" class="select" required>
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
                                    <input type="radio" name="signup_gender" class="checkbox" value="Male">
                                    <label class="checkbox" for="Male">ذكر</label>
                                </div>
                            </div>
                        </div>

                        <div class="input-groupt">
                            <label>(اختياري) الوصف</label>
                            <br>
                            <input id="desc_field" type="text" name="signup_desc" placeholder="اكتب ما تريد">
                            <br>
                        </div>

                        <div class="input-group">
                            <label>تحميل صورة</label>
                            <input type="file" name="img" accept="image/*" required>
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
                    } else {
                        btn.classList.toggle('disabled', false);
                    }
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
                    } else {
                        btn.classList.toggle('disabled', false);
                    }
                });
        </script>
    </body>
    </html>