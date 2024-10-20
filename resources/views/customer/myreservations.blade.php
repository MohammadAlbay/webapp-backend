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
    <link rel="stylesheet" href="/sources/customer/css/search-view.css">
    <link rel="stylesheet" href="/sources/technicain/css/mycustomers.css">
    <link rel="stylesheet" href="/sources/technicain/css/image-stack.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/homepage/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .icon-min {
            width: 24px;
            height: 24px;
        }

        .title {
            margin: 1em;
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- ************************************Navbar***************************************** -->

    <!-- Include Header -->
    @include('customer.header')

    <h1 class="title">حجوزاتي</h1>
    <div style="margin: 0 auto; margin-top:2em; text-align:center">
        <p>
            يرجى الانتباه قبل القيام بالغاء لحجز. قيامك بالغاء حجز لم يتبقى عليه الى 24 ساعة سوف يتسبب في قيام النظام بإجراء خصم من محفظتك كـ إجراء تأديبي
        </p>
    </div>
    <div>
        <table class="green-table">
            <tr>
                <th>#</th>
                <th></th>
                <th>الفني</th>
                <th>التخصص</th>
                <th>الحالة</th>
                <th>التاريخ</th>
                <th>تاريخ التسجيل</th>
                <th></th>
            </tr>
            @foreach ($reservations as $r)
            @php
                $technicain = $r->technicain();
            @endphp
            <tr>
                <td>{{$r->id}}</td>
                <td>
                    <div class="profile-stack-container m">
                        <img src="{{($technicain->profile == "Male.jpg" || $technicain->profile == "Female.jpg") ? "/sources/img/$technicain->profile" : "/cloud/technicain/$technicain->id/images/$technicain->profile"}}" alt="">
                    </div></td>
                <td>{{$technicain->fullname}}</td>
                <td>{{$technicain->specializationName()}}</td>
                <td>{{$r->sweetStateName()}}</td>
                <td>{{$r->date}}</td>
                <td>{{$r->created_at}}</td>
                <td>
                    @if($r->state !== 'Done' && $r->state !== 'Refused')
                    <a href="/customer/reservation/cancel/{{$r->id}}" class="login-btn" style="background-color: red;">
                         الغاء الحجز
                    </a>
                    @else
                    <a href="" class="login-btn" style="background-color: gray; pointer-events:none">
                         الغاء الحجز
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!-- ******************************************************Footer Section********************* -->
    <!-- Include Footer -->
    @include('customer.footer')


    @include('customer.search-view')
    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/customer/js/index.js"></script>
    <script>
        Homepage.prepare(document.querySelector('div.search-view'));
    </script>


        @if($errors->any()) 
            @foreach ($errors->all() as $e)
                <script>
                    swal.fire({
                        'icon': 'error',    'title': 'فشل في العملية',
                        'text': '{{$e}}'
                    });
                </script>
            @endforeach
        @endif



    @include('successful-task');

    @include('customer.search-view')
    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/customer/js/index.js"></script>
    <script>
        Homepage.prepare(document.querySelector('div.search-view'));
    </script>
</body>

</html>