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
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
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

        .wallet-money-div {
            margin: 0 auto;
            margin-top: 2em;
            text-align: center;
            background-color: beige;
            width: 55%;
            font-size: 14pt;
            border-radius: 1em;
            padding: 1.6em 1em 0.5em 1em;
        }

        .ux-input2 {
            margin-top: 1em !important;
        }

        .submit-button {
            width: 100%;
            background-color: rgb(61, 179, 48);
            border-radius: 1em;
            border: none;
            color: white;
            margin-top: 1em;
            margin-bottom: 1em;
            padding: 0.5em 0em;
            cursor: pointer;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- ************************************Navbar***************************************** -->

    <!-- Include Header -->
    @include('customer.header')

    <h1 class="title">محفظتي</h1>
    <div class="wallet-money-div">
        <p>رصيد محفظتك هو
            <b>
                {{$me->wallet->balance}}
             دينار
            </b>
        </p>
    </div>
    <div style="width: 80%; margin: 0 auto">
        <form id="topup_form" action="/customer/topop" method="post">
            @csrf
        <div class="ux-input2">
            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
            <label for="prepaidcard_number">رقم الكرت </label>
            <input type="text" id="prepaidcard_number" name="prepaidcard_number" autocomplete="off" placeholder="">
        </div>
        </form>
        <input onclick="confirmAndSubmit();" class="submit-button" form="form_customer_edit" value="تعبئة">
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
            'icon': 'error',
            'title': 'فشل في العملية',
            'text': '{{$e}}'
        });
    </script>
    @endforeach
    @endif

    <script>
        function confirmAndSubmit() {
    Swal.fire({
        icon: 'question',
        title: 'هل انت متأكد؟',
        text: 'قم بتأكيد العملية',
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonText: 'موافق',
        cancelButtonText: 'الغاء',
    }).then(confirm => {
        if (confirm.isConfirmed) {
            document.forms['topup_form'].submit();
        }
    });
}
    </script>


@include('successful-task');

    @include('customer.search-view')
    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/customer/js/index.js"></script>
    <script>
        Homepage.prepare(document.querySelector('div.search-view'));
    </script>
</body>

</html>