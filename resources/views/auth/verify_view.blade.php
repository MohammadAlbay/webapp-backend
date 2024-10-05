<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>تم ارسال رابط تفعيل حسابك اللاكتروني</h1>
    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li style="color:red">{{$error}}</li>
        @endforeach
    </ul>
    @endif

    @if($errors->has('verify-limit-error'))
    <a style="color:grey; font-style:underline">resend activation link</a>
    @else
        @if(session(key: 'id'))
        <a href="/verify/resend/{{ session(key: 'id') }}/{{ session(key: 'type') }}">resend activation link</a>
        @else
        <a href="#" style="color:Red">خطأ في النظام</a>
        @endif
    
    @endif
    
</body>

</html>