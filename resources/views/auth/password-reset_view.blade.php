<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <style>
        .box {
            width:70%; margin: 0 auto; padding:1em; 
            border-radius:1em; background-color:rgb(230, 230,230)
        }

        .btn {
            padding: 0.5em 1em;
            background-color: hsl(88, 100%, 32%);
            border-radius:0.5em;
            margin: 0 auto;
            display:block;
            margin-top: 1em;
            width: 70%;
            border:none;
            font-size: 14pt;
            color:whitesmoke;
            transition: all 0.4s;
        }
        .btn:hover {box-shadow: rgba(0,0,0, 0.4) 0px 0px 4px 0.4px;}

        .ux-input2 {margin-top: 1em!important;}
    </style>
</head>

<body dir="rtl">
    @if(session('invalid-request-link'))
    <h4>الرابط غير صحيح</h4>
    @else
    <h1>قم بتعيين كلمة المرور الجديدة لحسابك</h1>

    <div class="box">
        <h3>ادخل كلمة السر الجديدة</h3>
        <div>
            @if($errors->any())
                <h5>الاخطاء:</h5>
                <ul>
                @foreach ($errors->all() as $e)
                    <li style="color:red">{{$e}}</li>    
                @endforeach
                </ul>
            @endif
        </div>
        <form action="/reset-request/set-new" method="post">
            @csrf
            <input type="text" style="display:none;" name="_type" value="{{$type}}">
            <input type="text" style="display:none" name="_id" value="{{$user->id}}">
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="reset_from_password">كلمة المرور</label>
                <input type="text" id="reset_from_password" name="reset_from_password" placeholder="">
            </div>
            <div class="ux-input2">
                <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                <label for="reset_from_password2">تأكيد كلمة المرور</label>
                <input type="text" id="reset_from_password2" name="reset_from_password2" placeholder="">
            </div>
            <button class="btn">تغيير</button>
        </form>
    </div>
    @endif


</body>

</html>