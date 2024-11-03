@php
$userType = 'customer';
$user = $me;
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>فني لعندك</title>
    <script src="/sources/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="/sources/customer/css/edit.css">
    
    <link rel="stylesheet" href="/sources/customer/css/search-view.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/homepage/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="/sources/customer/js/edit.js"></script>

    <style>
        .icon-min {
            width: 24px;
            height: 24px;
        }

        .title {
            margin: 1em;
            text-align: right;
        }

        .width-70fill {
            width: 70%;
            transition: width 0.5s ease-in;
            margin: 0 auto;
            padding-bottom: 2em;
            position: relative;
        }

        .ux-input2 {
            margin-top: 1em !important;
        }

        .submit-button {
            width:100%;
            background-color: rgb(61, 179, 48);
            border-radius: 1em;
            border:none;
            color:white;
            margin-top:2em;
            padding: 0.5em 0em;
            cursor: pointer;
            text-align: center;
        }

        .disabled {
            pointer-events: none;
            cursor:not-allowed;
        }
        @media only screen and (max-width: 780px) {
            .width-70fill {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <!-- ************************************Navbar***************************************** -->

    <!-- Include Header -->
    @include('customer.header')

    <h1 class="title">تعديل بياناتي</h1>
    <div>
        <div class="width-70fill">
            <form action="/customer/edit" method="post" id="form_customer_edit">
                @csrf
            </form>
            <div style="margin: 0 auto; text-align:right">
                <img class="profile-picture" src="{{($me->profile == "Male.jpg" || $me->profile == "Female.jpg") ? "/sources/img/$me->profile" : "/cloud/customer/$me->id/images/$me->profile"}}" alt="">
                <button onclick="changePictureProcessor(this)" class="button-image primary">
                    <img src="https://img.icons8.com/?size=100&id=61474&format=png&color=000000" alt="">
                    <i>تغيير</i>
                </button>
            </div>
            <!-- Fullname input -->
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="customer_name_edit">الاسم </label>
                <input type="text" id="customer_name_edit" name="customer_name_edit" placeholder="" form="form_customer_edit" value='{{$me->fullname}}'>
            </div>
            <!-- Birthdate input -->
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="customer_db_edit">تاريخ الميلاد </label>
                <input type="date" id="customer_db_edit" name="customer_db_edit" placeholder="" form="form_customer_edit" value='{{$me->birthdate}}'>
            </div>
            <!-- Phone input -->
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="customer_phone_edit">رقم الهاتف </label>
                <input type="text" id="customer_phone_edit" name="customer_phone_edit" placeholder="" form="form_customer_edit" value='{{$me->phone}}'>
            </div>
            <!-- Address input -->
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="customer_address_edit">العنوان </label>
                <select id="customer_address_edit" name="customer_address_edit" placeholder="" form="form_customer_edit" value='{{$me->address}}'>
                    @include('addresses-option');
                </select>
            </div>
            <!-- Gender input -->
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="customer_gender_edit">الجنس </label>
                <select name="customer_gender_edit" id="customer_gender_edit" form="form_customer_edit">
                    <option value="Male" {{$me->gender == 'Male' ? 'selected' : ''}}>ذكر</option>
                    <option value="Female" {{$me->gender == 'Female' ? 'selected' : ''}}>انثى</option>
                </select>
            </div>

            <input id="submit_button" onclick="confromEditData()" class="submit-button" form="form_customer_edit" value="حفظ">
        </div>
    </div>
    <!-- ******************************************************Footer Section********************* -->
    <!-- Include Footer -->
    @include('customer.footer')


    @include('customer.search-view')
    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/customer/js/index.js"></script>
    <script>
        Homepage.prepare(document.querySelector('div.search-view'));

        setTimeout(() => {
            document.querySelector('#customer_address_edit').value = "{{$me->address}}";
        }, 200);
    </script>


    @if($errors->any())
    @foreach ($errors->all() as $e)
    <script>
        swal.fire({
            'icon': 'error',
            'title': 'فشل في العملية',
            'text': '{{$e}}'
        });
    </script>
    @endforeach
    @endif


    @include('customer.search-view')
    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/customer/js/index.js"></script>
    <script src="/bad-word/word.js"></script>
    <script>
        Homepage.prepare(document.querySelector('div.search-view'));


        document.getElementById('customer_name_edit')
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


    @include('successful-task');
</body>

</html>