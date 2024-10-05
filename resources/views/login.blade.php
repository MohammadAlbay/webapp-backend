<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
    <link rel="stylesheet" href="/sources/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/employee/js/index.js"></script>r

    <style>
        .fakeLink {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="login-box">
            <div class="half-circle"></div>
            <div class="image-container"></div>
            <div class="form-container">
                <h2>اهلا وسهلا بكم</h2>
                <p>سجل دخولك للوصول لادارة حسابك وخدمات الموقع </p>
                <div class="error">
                    @if($errors->any())
                    @foreach ($errors->all() as $e)
                    <b style="color:Red">{{ $e }}</b>
                    @endforeach

                    @elseif(session('account-verified'))
                    <b style="color:green;">تم تفعيل حسابك بنجاح </b>
                    @elseif(session('password-reset-done'))
                    <b style="color:green;">تم تغيير كلمة المررو بنجاح </b>
                    @endif
                </div>
                <form action="{{ route('login.start') }}" method="post">
                    @csrf
                    <label for="login_emial">اسم االمستخدم/الايميل</label>
                    <input type="emial" name="login_emial" id="login_emial">
                    <label for="login_password">كلمة المرور</label>
                    <input type="password" name="login_password" id="login_password">
                    <div class="options">
                        <label><input type="checkbox" name="login_rememberme">تذكرني</label>
                        <a class="fakeLink" onclick="resetPasswordProcessor(this)">نسيت كلمة المرور؟</a>
                    </div>
                    <button type="submit">تسجيل الدخول</button>
                    <p>لاتمتلك حسابا؟ <a href="/signup">سجل هنا</a></p>
                </form>

            </div>
        </div>

        <script>
            async function resetPasswordProcessor(self) {
                const {
                    value: email
                } = await Swal.fire({
                    title: "كم بادخال البريد الاكتروني المرتبط بحسابك بنرسل رابط اعادة تعيين كلمة المرور",
                    input: "email",
                    inputAttributes: {
                        autocapitalize: "off"
                    },
                    showCancelButton: true,
                    cancleButtonText: "الغاء",
                    confirmButtonText: "ارسال",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false
                });
                if (email) {
                    let form = new FormData();
                    form.append('email', email);
                    sendFormData('/reset-request/make', 'POST', form, async v => {
                        if (v.State == 1) {
                            Swal.fire({
                                icon: "error",
                                title: "خطأ",
                                text: v.Message,
                            });
                        } else {
                            Swal.fire({
                                icon: "success",
                                title: "تم ارسال رابط تعيين كملة المرور لحسابك بنجاح",
                            });
                        }
                    })
                }
            }
        </script>
</body>

</html>