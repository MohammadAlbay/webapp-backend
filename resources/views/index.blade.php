<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @if($user == null)
    <a href="/login/">login</a>
        
    @else
    <a href="/{{ $user }}">Profile</a>
    @endif
    <a href="/signup/">singup for free!</a>
</body>
</html>