<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <h1>Form :</h1>
    <form action="/send" method="post">
        @csrf
        <input type="text" name="text" id="text">
        <input type="submit" value="Send">
    </form>
</body>
</html>