<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Completed works</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">

    <link rel="stylesheet" href="/sources/technicain/css/mycustomers.css">
    <link rel="stylesheet" href="/sources/technicain/css/image-stack.css">

    <link rel="stylesheet" href="/sources/technicain/css/profile.css">
    <link rel="stylesheet" href="/sources/technicain/css/posts.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/main.js"></script>
    <script src="/sources/employee/js/index.js"></script>

    <style>
            .md-grid-item.full-width {
    grid-column: 1 / -1; /* Full-width */
    text-align: right; /* Align text to the right */
      }
body {
            font-family: 'Cairo', sans-serif; /* Apply the Cairo font */
        }
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
            width: 50%;
            min-width: 15em;
            max-width: 25em;
            background-color: beige;
            border-radius: 1em;
            border: 1px solid darkgray;
            text-align: center;
        }

        .align-text {
            text-indent: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
        }

       
         /*when there is no data */
         .no-data-section {
    margin: 2em auto; /* Center the section horizontally */
    width: 80%;
    text-align: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border-radius: 1em;
    min-width: 15em;
    max-width: 35em;
    display: flex; 
    flex-direction: column;
    align-items: center; 
    justify-content: center;
    height: 400px; 
}

.no-data-image {
    width: 250px; 
    height: auto; 
    margin-bottom: 10px; 
}
    h3 {
            font-family: 'Cairo', sans-serif; 
        }
    </style>


</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " اعمالي السابقة"])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width">
             
            <div class="md-grid-item full-width" dir="rtl">
                <h1 class="title">الأعمال المكتملة</h1>
                <div>
                    @if($reservations->count() > 0)
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"></th>
                            <th scope="col">الزبون</th>
                            <th scope="col">العنوان</th>
                            <th scope="col">رقم الهاتف</th>
                            <th scope="col">الحاله</th>
                            <th scope="col">تاريخ الحجز</th>
                            <th scope="col">تاريخ التسجيل</th>
                            <th scope="col">-</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp <!--  counter -->
                        @foreach ($reservations as $r)
                        @php
                        $customer = $r->customer();
                        @endphp
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>
                                <div class="profile-stack-container m">
                                    <img src="{{($customer->profile == "Male.jpg" || $customer->profile == "Female.jpg") ? "/sources/img/$customer->profile" : "/cloud/customer/$customer->id/images/$customer->profile"}}" alt="">
                                </div>
                            </td>
                            <td>{{$customer->fullname}}</td>
                            <td>{{$customer->address}}</td>
                            <td>{{$customer->phone}}</td>
                            <td style="color:#A1DD70">{{$r->sweetStateName()}}</td>
                            <td>{{$r->date}}</td>
                            <td>{{$r->created_at}}</td>
                            <td>
                                <a onclick="reportCustomer({{$r->id}})" class="login-btn" style="background-color: red;">
                                    تبليغ
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    {{ $reservations->links() }}
                    @else
                    <div class="no-data-section">
                        <div class="no-data-section">
                            <img src="{{ asset('rahma-ui/assets/images/finishyouwork.png') }}" alt="No Data" class="no-data-image">
                            <h3>قم بإنهاء أعمالك أولاً</h3>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>


   
    
    <script src="/bad-word/word.js"></script>
    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>



    <script src="/sources/technicain/js/posts.js"></script>

    <script>
        async function reportCustomer(reservationID) {
            const {
                value: reportDesc
            } = await Swal.fire({
                title: 'تقديم بلاغ عن زبون',
                text: 'قم بالاختيار من مربع الخيارات ادناه',
                showCancelButton: true,
                cancelButtonText: 'الغاء',
                cancelButtonColor: "#d33",
                showConfirmButton: true,
                confirmButtonText: 'اختيار',
                confirmButtonColor: "#3085d6",
                input: 'select',
                inputPlaceholder: 'اختر سبب البلاغ',
                inputOptions: {
                    harmlvl1: 'السب والشتم وسوء المعاملة',
                    harmlvl2: 'افساد ممتلكات شخصية او اضاعت مواد كان قد اشتراها الفني',
                    harmlvl3: 'التعدي الجسدي او اي شيء قد يمس بصحة الفني',
                },
            });

            if (!reportDesc) return;
            const url = "/technicain/report";
            const data = {
                reason: reportDesc,
                reservation: reservationID
            };
            let result = await sendFormDataNoCallback(url, "POST", data);

            if (result.State == 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'فشل الاجراء',
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'اكتمل الاجراء',
                    text: result.Message
                });
            }

        }
    </script>

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
            timer: 1700,
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