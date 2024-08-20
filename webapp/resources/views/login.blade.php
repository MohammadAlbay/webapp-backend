<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
</head>
<body>
    <h1>Hi!. This is login view</h1>
    
    @if($errors->has('status'))
    <b style="color:Red">You're getting an Error : {{ $errors->first('status')  }}</b>
    @endif 
    <form action="{{ route('login.start') }}" method="post">
        @csrf

        <label for="login_type">Choose User type: </label>
        <select name="login_type" id="login_type">
            <option value="programmer">Programmer</option>
            <option value="company">Company</option>
        </select>

        <label for="login_emial">Email: </label>
        <input type="emial" name="login_emial" id="login_emial">

        <label for="login_password">Password: </label>
        <input type="password" name="login_password" id="login_password">

        <input type="submit" value="Login">
    </form>
</body>
</html>