<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Here I'm a Programmer {{Auth::guard("programmer")->user()->fullname}}</h1>


    <a href="{{route("login.end")}}">Log off</a>

    <ul>
    @foreach ($projects as $projectsName)
        <li>{{$projectsName}}</li>
    @endforeach
    </ul>

</body>
</html>