<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="/sources/technicain/css/index.css">
    <link rel="stylesheet" href="/sources/technicain/css/calendar.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar")
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



     <!-- For Regular tasks -->
     @if(session('task-complet'))
    @if(session('task-complet') == true)
    <script>
        Swal.fire({
            toast: true,
            icon: "success",
            title: 'اكتملت العملية',
            text: "{{session('task-complet')}}",
            position: "top-end",
            showConfirmButton: false,
            timer: 1200,
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
    @endif
    @endif
</body>

</html>