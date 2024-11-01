 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
</head>
<body dir="rtl">
    <h1>
        تنبيهات النظام
    </h1>
    <hr>
        <h3 style="color:Red">انتهى اشتراكك</h3>
        <p>
        عند انتهاء اشتراكك لن يظهر حسابك للمستخدمين. اشتركك مجددا ولا تفقد زبائنك المميزين!
        </p>
        <br>
        <b style="color:black">
            عزيزي/عزيزتي
            {{$technicain->fullname}}
            نود اعلامك ان اشتراكك قد انتهى. يمكنك اعادة الاشتراك بالضغط 
            <a href="{{Illuminate\Support\Facades\URL::to("/")}}:8000/technicain/subscription">هنا</a>
        
        </b>


    <footer>
        <p>
            الرجاء عدم الرد على هذا الايميل
        </p>
    </footer>
</body>
</html>