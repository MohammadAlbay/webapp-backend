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
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
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
        body {
            font-family: 'Cairo', sans-serif; /* Apply the Cairo font */
        }

        .icon-min {
            width: 24px;
            height: 24px;
        }

        .title {
            margin: 1em;
            text-align: right;
            /*font-weight: 600; /* Make the title bold */
        }
        html, body {
            height: 100%; /* Ensure the body takes the full height */
            margin: 0; /* Remove default margin */
            display: flex;
            flex-direction: column; /* Stack elements vertically */
        }

        main {
            flex: 1; /* Allow main to grow and push footer down */
            display: flex;
            flex-direction: column; /* Stack content vertically */
            justify-content: flex-start; /* Align to the top */
        }

        .icon-image {
            width: 100px; /* Set your desired width */
            height: 100px; /* Set your desired height */
            margin: 0 auto 10px; /* Centering, with a small bottom margin */
        }

        .text-container {
            margin: 0 auto; /* Centering */
            text-align: center;
            margin-top: 0; /* Remove top margin */
        }
    </style>
</head>

<body>
    <!-- ************************************Navbar***************************************** -->

    <!-- Include Header -->
    @include('customer.header')

    <main>
        <h1 class="title">حجوزاتي</h1>

        <!-- Centered Image -->
        <div style="text-align: center; margin: 1em auto;">
            <img src="{{ asset('rahma-ui/assets/images/time-management.png') }}" alt="Descriptive Alt Text" class="icon-image">
        </div>

        <div class="text-container">
            <p>
                يرجى الانتباه قبل القيام بالغاء لحجز. قيامك بالغاء حجز لم يتبقى عليه الى 24 ساعة سوف يتسبب في قيام النظام بإجراء خصم من محفظتك كـ إجراء تأديبي
            </p>
        </div>
<!--table-->

<div>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th></th>
                <th>الفني</th>
                <th>التخصص</th>
                <th>الحالة</th>
                <th>التاريخ</th>
                <th>تاريخ التسجيل</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $r)
            @php
                $technicain = $r->technicain();
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Counter -->
                <td>
                    <div class="profile-stack-container m">
                        <img src="{{ ($technicain->profile == 'Male.jpg' || $technicain->profile == 'Female.jpg') ? '/sources/img/'.$technicain->profile : '/cloud/technicain/'.$technicain->id.'/images/'.$technicain->profile }}" alt="" class="img-fluid">
                    </div>
                </td>
                <td>{{ $technicain->fullname }}</td>
                <td>{{ $technicain->specializationName() }}</td>
                <td>{{ $r->sweetStateName() }}</td>
                <td>{{ $r->date }}</td>
                <td>{{ $r->created_at }}</td>
                <td>
                    @if($r->state !== 'Done' && $r->state !== 'Refused')
                    <a href="/customer/reservation/cancel/{{ $r->id }}" class="login-btn" style="background-color: red; color: white;">
                         الغاء الحجز
                    </a>
                    @else
                    <a href="#" class="login-btn" style="background-color: gray; color: white; pointer-events:none">
                        لقد قمت بالغاء الحجز
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    </main>

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
                    'icon': 'error', 'title': 'فشل في العملية',
                    'text': '{{$e}}'
                });
            </script>
        @endforeach
    @endif

    @include('successful-task');
</body>

<!-- ******************************************************Footer Section********************* -->
@include('customer.footer')
</html>