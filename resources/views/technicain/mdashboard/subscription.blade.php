<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Subscription</title>
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">
    <link rel="stylesheet" href="/sources/technicain/css/profile.css">

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

        .align-text {
            text-indent: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .no-data-section {
            margin: 0 auto;
            width: 80%;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 2em;
            background-color: #f9f9f9; /* Match the section background */
            border-radius: 1em;
            border: 1px solid darkgray;
            min-width: 15em;
            max-width: 35em;
            padding: 1em; /* Padding for better appearance */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for better visibility */
        }

        body {
            font-family: 'Cairo', sans-serif; /* Apply the Cairo font */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #fdfdfd; /* Changed to white */
            text-align: center;
            color: #000;
        }

        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            font-family: 'Sp_Morvarid', serif;
        }

        h1 span {
            color: #4CAF50;
        }

        img {
            width: 150px;
            margin-bottom: 20px;
        }

        p,
        h2 {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .subscribe-button {
            margin-top: 20px;
            font-size: 16px;
            background-color: #4CAF50; /* Button background */
            color: #FFF;               /* Button text color */
            padding: 10px 20px;
            border: none;              /* Remove border */
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }

        .subscribe-button.disabled {
            background-color: #aaa; /* Disabled button background */
            cursor: not-allowed;
        }

        table {
            width: 100%;
            margin-top: 2em;
            border-collapse: collapse;
            background-color: #f9f9f9; /* Set a consistent background color */
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            background-color: #f9f9f9; /* Match row background color with table */
        }

        th {
            background-color: #f2f2f2; /* Header background */
        }
    </style>

</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " اشتراكاتي"])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width">
               
                <h1>فنى <span>لعندك</span></h1>
                <img src="{{ asset('rahma-ui/assets/images/subscription (1).png')}}" alt="Worker Image">
              
                <div>
                    <h2>
                        @if($me->state == 'Inactive')
                            انت غير مشترك
                        @else
                            انت مشترك وتاريخ انتهاء صلاحية الاشتراك: {{$me->wallet->lastOutgoingTransactions()->due}}
                        @endif
                    </h2>
              
                    <p>تكلفة الاشتراك شهريا 15 دل عند الاشتراك لايمكنك الغاء الامر</p>
              
                    <form id="form_topup" action="/technicain/subscripe" method="post" style="margin: 0;">
                        @csrf
                        <div class="{{ $me->state == 'Active' ? 'subscribe-button disabled' : 'subscribe-button' }}" onclick="{{$me->state == 'Active' ? '' : 'form_topup.submit()'}}">
                            اشتراك
                        </div>
                    </form>
                </div>
              
                @if($me->wallet->outgoingTransactions()->count() > 0)
                    <table dir="rtl">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>القيمة</th>
                            <th>التاريخ</th>
                            <th>انتهاء الصلاحية</th>
                        </tr>
                        @php $counter = 1; @endphp
                        @foreach ($me->wallet->outgoingTransactions() as $t)
                            @if($t->type != 'Sub')
                                @continue
                            @endif
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td>{{ $me->fullname }}</td>
                                <td>{{ $t->money }} د.ل</td>
                                <td>{{ $t->created_at }}</td>
                                <td>{{ $t->due }}</td>
                            </tr>
                        @endforeach
                    </table>
                
                @endif
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