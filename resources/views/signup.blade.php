<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Signup</title>
</head>

<body>
    <h1>Hi!. This is signup view</h1>

    <form action="{{ route('signup.redirect')}}" method="post">
        @csrf
        <input type="text" style="display: none;" name="signup_type" id="signup_type" value="Technicain">
        <button type="submit">الفني</button>
    </form>
    <form action="{{ route('signup.redirect')}}" method="post">
        <input type="text" style="display: none;" name="signup_type" id="signup_type" value="customer">
        <button type="submit">عميل</button>
    </form>
      <!--  <label for="signup_name">Name: </label>
        <input type="text" name="signup_name" id="signup_name">

        <label for="signup_role">Choose Role: </label>
        <select name="signup_role" id="signup_role">
            @foreach ($roles as $role)
            <option value="{{$role->id}}">{{$role->name}}</option>
            @endforeach
        </select>

        <label for="signup_email">Email: </label>
        <input type="emial" name="signup_email" id="signup_email" value="MohammadAlbay@gmail.com">

        <label for="signup_password">Password: </label>
        <input type="password" name="signup_password" id="signup_password" value="1">

        <label for="signup_gender">Gender: </label>
        <select name="signup_gender" id="signup_gender">
            <option value="Male">male</option>
            <option value="Female">female</option>
        </select>

        <input type="submit" value="Create">-->
    
</body>

</html>