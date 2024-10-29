<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Profile</title>

    <link rel="stylesheet" href="/sources/main.css">
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">
    <link rel="stylesheet" href="/sources/technicain/css/calendar.css">

    <link rel="stylesheet" href="/sources/technicain/css/profile.css">

    <link rel="stylesheet" href="/sources/technicain/css/posts.css">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/main.js"></script>
    <script src="/sources/employee/js/index.js"></script>

    <script src="/sources/technicain/js/reservations.js"></script>


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
    </style>

    <style>
            .md-container {width:100%; right:0px; top: 0px;}
            .md-navbar {display: none!important;}
    </style>


</head>

<body>
    @include("technicain.mdashboard.rate-dialog")
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " ملفي الشخصي"])
    @if($viewer === '')
        @include("technicain.mdashboard.md-dash-nav-barmenu")
    @endif
    @include('technicain.mdashboard.calendar');
    <div class="md-container" style="overflow-y: auto;padding-top:0px;">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width" style="background-color:green">
                <div class="profile-headblock">
                    <div class="cover" style='background-image: url({{ ($me->cover != "" && $me->cover != null) ? "/cloud/technicain/$me->id/images/$me->cover" : "/sources/img/cover.jpg"}})'>
                    </div>
                    <div class="pic" style='background-image: url( {{($me->profile == "Male.jpg" || $me->profile == "Female.jpg") ? "/sources/img/$me->profile" : "/cloud/technicain/$me->id/images/$me->profile"}});'></div>
                    <div class="name">{{$me->fullname}}</div>
                    
                </div>
            </div>

        </div>
        
        @if($viewer !== '')
        @include('technicain.mdashboard.posts-listview')
        @endif
    </div>

    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>



    @if($viewer != '')
    <script src="/sources/technicain/js/posts.js"></script>
    <script>
        Calendar.prepare(document.querySelector('#reservation-cc'));

        let slideshows = document.querySelectorAll('.slideshow-container');
        slideshows.forEach(e => {
            PostsView.setupNewSlider(e, e.querySelector('.next'), e.querySelector('.prev'))
        });

        PostsView.isTechnicain = false;
        PostsView.actorId = {{$viewer->id}}

        RateProcessor.setupRateDialog(rate_dialog);
    </script>
    <script>
        async function reportTechnicain(reservationID) {
            const {
                value: reportDesc
            } = await Swal.fire({
                title: 'تقديم بلاغ عن فني',
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
                    harmlvl2: 'افساد ممتلكات شخصية او اضاعت مواد كان قد اشتراها الزبون',
                    harmlvl3: 'التعدي الجسدي او اي شيء قد يمس بصحة الزبون',
                },
            });

            if (!reportDesc) return;
            const url = "/customer/report";
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
    @endif
</body>

</html>