<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body dir="rtl">
    <h1>تنبيات النظام</h1>
    <hr>
    <b style="color:green">
        بيانات تسجيل الدخول للمنصة
    </b>
    <p>
        مرحبا
        {{$credintials['name']}} 
        لقد تم انشاء حساب موظف بعنوان البريد الاكتروني هذا.
        ادناه بيانات تسجيل الدخول للمنصة
        <br>
        <table border="1">
            <tr>
                <th>Email</th>
                <th>Password</th>
            </tr>
            <tr>
                <td>{{$credintials['email']}} </td>
                <td>{{$credintials['password']}} </td>
            </tr>
        </table>
        <br>

        <p>

        لتسجيل الدخول للمنصة قم بالنقر على الرابط 
        <a href="{{$credintials['url']}}">تسجيل الدخول</a>
        </p>
    </p>

    <footer>
        <p>
            الرجاء عدم الرد على هذا الايميل
        </p>
    </footer>
</body>
</html>