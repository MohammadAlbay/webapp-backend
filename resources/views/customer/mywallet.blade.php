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

        
.wallet-balance {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
    height: 600; /* Set a fixed height */
}

.balance-card {
    background-color: #ffe6b3;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    width: 400px; /* Set a fixed width */
    height: 200px; /* Set a fixed height */
    display: flex;
    flex-direction: column;
    justify-content: center; /* Center content vertically */
    align-items: center; /* Center content horizontally */
}
.balance-card img {
    width: 65px;
}

.balance-card p {
    font-size: 18px;
    margin: 10px 0 5px 0;
}

.balance-card h2 {
    font-size: 32px;
    margin: 0;
}

.wallet-button {
    display: block; /* Change to block to center */
    margin: 20px auto; /* Center the button */
    padding: 10px 0; /* Adjust padding for top and bottom */
    width: 300px; /* Set the same width as the balance card */
    background-color: #28a745; /* Green background */
    color: white;
    border: none;
    border-radius: 5px;
    text-align: center; /* Center text inside button */
    text-decoration: none; /* Remove underline */
    font-size: 1em;
    transition: background-color 0.3s;
}

.wallet-button:hover {
    background-color: #218838; /* Darker green on hover */
}
.input-field {
    display: block; /* Change to block to center */
    margin: 10px auto; /* Center the input field */
    padding: 10px; /* Padding for the input field */
    width: 300px; /* Same width as the button and balance card */
    border: 1px solid #ccc; /* Border for the input field */
    border-radius: 5px; /* Rounded corners */
    font-size: 1em; /* Font size for the text */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Subtle shadow */
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
/*wallet history*/
.wallet-history {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.wallet-history h3 {
    font-size: 20px;
    margin-bottom: 10px;
    text-align: right; /* Ensure the text aligns to the right */
}

.qr-table {
    width: 100%;
    border-collapse: collapse;
}

.qr-table th, .qr-table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: center;
}

.qr-table th {
    background-color: #f0f0f0;
}
    </style>
</head>

<body>
    <!-- Include Header -->
    @include('customer.header')

    <main>
        <h1 class="title">محفظتي</h1>
        <div class="wallet-balance">
            <div class="balance-card">
                <img src="{{ asset('rahma-ui/assets/images/wallet.png') }}" alt="Wallet Money">
                <p>المبلغ الموجود في محفظتك</p>
                <h2>{{$me->wallet->balance}} دينار</h2>
            </div>
        </div>
        <div style="width: 80%; margin: 0 auto;">
            <form id="topup_form" action="/customer/topop" method="post">
                @csrf
                <div class="ux-input2">
                    <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                    <label for="prepaidcard_number">رقم الكرت</label>
                    <input type="text" id="prepaidcard_number" name="prepaidcard_number" autocomplete="off" placeholder="">
                </div>
                <input onclick="confirmAndSubmit();" class="submit-button" value="تعبئة">
            </form>
        </div>
        <section class="wallet-history" dir="rtl">
            <h3>سجل كروتي</h3>
            <!--this the table is just a placeholder all the information will come from the database -->
            <!--i didnt add the pignation becouse the data will come form the database and i dont know how to handel it yet :) -->
            <table class="qr-table" dir="rtl">
                <thead>
                    <tr>
                        <th>ر ق</th>
                        <th>Qr code</th>
                        <th>تاريخ التعبئة</th>
                        <th>القيمة</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1; @endphp <!--  counter -->
                    <tbody>
                        @foreach ($me->transactions as $t)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $t->card()->serial }}</td> 
                                <td>{{ $t->created_at }}</td>
                                <td>{{ $t->card()->money }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </tbody>
            </table>
            
        
    </main>  
    
    <!-- Include Footer -->
    @include('customer.footer')
    
    @include('customer.search-view')
    
    <!-- Scripts -->
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
</body>
</html>