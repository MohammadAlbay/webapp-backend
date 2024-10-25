<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="/sources/technicain/css/index.css">
    <link rel="stylesheet" href="/sources/technicain/css/homepage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => ""])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;">
        @include("technicain.mdashboard.homepage")
    </div>
    <script src="/sources/technicain/js/index.js"></script>
    @if($me->profile == 'Male.jpg' || $me->profile == 'Female.jpg')
        <script>
            Swal.fire({
                icon: 'warning', title: 'تنبيه',
                text: "يرجى تغيير الصورة الشخصية حتى تتكمن من تفعيل خدمات حسابك"
            });
        </script>
    @endif

    @include('successful-task');


    @php
    $newReservations = $me->pendingReservations()->count();
    @endphp
    @if($newReservations > 0)
    <script>
        Swal.fire({
            icon:'info',
            title: "لديك حجوزات جديدة", text: "لديك عدد "+ " {{$newReservations}} " + " حجز جديد. تفقد بريدك الالكتروني"
        });
    </script>
    @endif
</body>

</html>