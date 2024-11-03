<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Wallet</title>

    <link rel="stylesheet" href="/sources/main.css">
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
    </style>


</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " محفظتي"])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width" dir="rtl">
                <div>
                    <div class="balance-box">
                        <h2 style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">رصيدك الحالي
                            {{$me->wallet->balance}}
                        </h2>
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

                    <table style="margin-top: 2em;">
                        <tr>
                            <th>#</th>
                            <th>المستخدم</th>
                            <th>القيمة</th>
                            <th>التاريخ</th>
                        </tr>
                        @foreach ($me->transactions as $t)
                        <tr>
                            <td>{{$t->id}}</td>
                            <td>{{$me->fullname}}</td>
                            <td>{{$t->card()->money}}</td>
                            <td>{{$t->created_at}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

    </div>


    <dialog id="add-post-dialog" class="fullscreen-dialog">
        <div class="topbar-container">
            <div class="close" onclick="showDialog()"></div>
            <div class="title">اضافة منشور</div>
        </div>
        <div class="container" style="overflow-y:auto">
            <div class="md-grid-container">
                <div class="md-grid-item half-width " style="border-radius: 1em; padding-bottom:1em; background-color:rgba(244,244,244);">
                    <b class="title">نص المنشور</b>
                    <div>
                        <textarea onchange="" name="techincain-add-post-textarea" id="techincain-add-post-textarea" class="post-textarea"></textarea>
                    </div>
                </div>
                <div class="md-grid-item half-width " style="border-radius: 1em; padding-bottom:1em;  background-color:rgba(244,244,244);">
                    <b class="title">صور وفيديوهات المنشور</b>
                    <button id="techincain-add-post-addmedia" class="button-image">
                        <img src="https://img.icons8.com/?size=100&id=IA4hgI5aWiHD&format=png&color=000000" alt="">
                        <i>اضافة</i>
                    </button>
                    <div id="techincain-add-post-imagelist" style="height:20em; padding:0.2em;white-space: nowrap;overflow-x:scroll;overflow-y:hidden;">
                    </div>
                </div>
            </div>
            <div class="md-grid-container md-grid-item full-width" style="background-color: transparent; border:none;">
                <div class="md-grid-item full-width full-height" style="border-radius: 1em; padding-bottom:1em;">
                    <b class="title">للنشر اضغط على زر النشر ادناه</b>
                    <button id="techincain-add-post-submit" class="button-image">
                        <img src="https://img.icons8.com/?size=100&id=103205&format=png&color=000000" alt="">
                        <i>نشر</i>
                    </button>
                </div>
            </div>
        </div>
    </dialog>

    
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