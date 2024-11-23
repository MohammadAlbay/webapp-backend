<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>techwallet</title>
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">

    <link rel="stylesheet" href="/sources/technicain/css/profile.css">
    <link rel="stylesheet" href="/sources/technicain/css/posts.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/main.js"></script>
    <script src="/sources/employee/js/index.js"></script>

    <style>
        .error-card {
            width: 95%;
            margin: 0 auto;
            background-color: rgb(216, 32, 32);
            border-radius: 0.5em;
            padding: 0.5em;
            box-sizing: border-box;
            color: white;
            opacity: 1;
            transition: opacity 1s ease-in-out 5s;
        }

        .hide-now {
            opacity: 0;
        }

        .balance-box {
            margin: 0 auto;
            width: 50%;     min-width: 15em;
            max-width: 25em;
            background-color: beige;
            border-radius: 1em;
            border: 1px solid darkgray;
            text-align: center;
        }

        /* Adjusted styles for the wallet balance section */
        body {
            font-family: 'Cairo', sans-serif; /* Apply the Cairo font */
        }
        .wallet-balance {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
        }

        .balance-card {
            background-color: #ffe6b3;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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

        .wallet-history {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .wallet-history h3 {
            font-size: 20px;
            margin-bottom: 10px;
            text-align: right;
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
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " محفظتي"])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">
        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width">
                <div class="md-grid-item full-width" dir="rtl">
                    <!--<h1 class="title" style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">المحف</h1>-->
                    <div>
                        <div class="wallet-balance">
                            <div class="balance-card">
                                <img src="{{ asset('rahma-ui/assets/images/wallet.png') }}" alt="Wallet Money">
                                <p>المبلغ الموجود في محفظتك</p>
                                <h2>{{$me->wallet->balance}} دينار</h2>
                            </div>
                        </div>
                        <div style="margin: 0 auto; width:60%">
                            <form id="form_topup" action="/technicain/topup" method="post">
                                @csrf
                                <h5 style="text-indent:30px;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">ادخل رقم البطاقة للتعبئة</h5>
                                <div class="ux-input2">
                                    <label for="prepaidcard_number">الرقم السري لبطاقة الشحن</label>
                                    <input type="text" id="prepaidcard_number" name="prepaidcard_number" placeholder="">
                                </div>
                                <div class="ux-input2 btn success" onclick="form_topup.submit()">
                                    تعبئة
                                </div>
                            </form>
                        </div>

                        <section class="wallet-history" dir="rtl">
                            <h3>سجل كروتي</h3>
                            <table class="qr-table" dir="rtl">
                                <thead>
                                    <tr>
                                        <th>#</th>
                            <th>المستخدم</th>
                            <th>القيمة</th>
                            <th>التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 1; @endphp
                                    @foreach ($me->transactions as $t)
                                        <tr>
                                            <td>{{ $counter++ }}</td>
                                            <td>{{$me->fullname}}</td>
                                            <td>{{$t->card()->money}}</td>
                                            <td>{{$t->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/bad-word/word.js"></script>
    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>

    @include('successful-task');

    <!-- For Regular Errors -->
    @if($errors->any())
    @foreach ($errors->all() as $err)
    <script>
        Swal.fire({
            toast: true,
            icon: "error",
            title: 'مشكلة في العملية',
            text: "{{$err}}",
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },

            didClose: () => {
                location.reload();
            }
        });
    </script>
    @endforeach
    @endif
    @if($me->profile == 'Male.jpg' || $me->profile == 'Female.jpg')
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: "يرجى تغيير الصورة الشخصية حتى تتكمن من تفعيل خدمات حسابك"
        });
    </script>
    @endif
    <script>
        setTimeout(() => {
            let errCard = document.querySelector('.error-card');
            if (errCard == null) return;
            errCard.addEventListener("transitionend", (event) => {
                errCard.remove();
            });
            errCard.classList.add('hide-now');
        }, 1000);
    </script>
</body>

</html>