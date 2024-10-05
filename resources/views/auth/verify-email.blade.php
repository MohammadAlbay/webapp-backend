<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Email address been sent to you</h1>

    <form action="/email/verification-notification" method="post">
        <input type="submit" value="اعادة الارسال">
    </form>
    <a
    @if(session('message'))
    <div style="background-color:green; color:white">
        {{ session('message') }}
    </div>
    @endif
</body>

</html>