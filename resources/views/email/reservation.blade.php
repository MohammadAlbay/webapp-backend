@php 
$from = $data['from']; // only supports 'technicain' or 'customer'
$customer = $data['customer'];
$technicain = $data['technicain'];
$date = $data['date'];
$id = $data['id'];
$url = $data['url'];
$state = $data['state'] ?? "";
@endphp
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
        حجز رقم 
        {{$id }}#
    </h1>
    <hr>
    @if($from == 'technicain')
        <div>
            <p>
                قام
                {{$technicain->fullname}}
                @if($state == 'Accepted')
                    بقبول
                    سوف يقوم بالتواصل معك عبر رقم هاتفك المسجل به فالنظام
                @else
                    برفض
                    الخدمة المطلوبة بتاريخ 
                {{$date}}
                @endif
            </p>
        </div>

    @else
        <div>
            <p>قام 
                {{$customer->fullname}}
                بطلب حجز خدمة بتاريخ 
                {{$date}}
                هل تود القبول ام الرفض؟
                <br>
                رقم هاتف الزبون هو:
                {{$customer->phone}}
            </p>
        </div>
        
        <a href="{{$url}}/technicain/reservation/Accepted/{{$id}}"><div class="ux-input2 btn success">قبول</div></a>
        <a href="{{$url}}/technicain/reservation/Refused/{{$id}}"><div class="ux-input2 btn dangour">رفض</div></a>
    @endif


    <footer>
        <p>
            الرجاء عدم الرد على هذا الايميل
        </p>
    </footer>
</body>
</html>