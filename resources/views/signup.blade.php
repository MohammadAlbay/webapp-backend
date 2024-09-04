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
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('signup.create')}}" method="post">
        @csrf

        <label for="signup_type">Choose User type: </label>
        <select name="signup_type" id="signup_type">
            <option value="customer">Customer</option>
            <option value="technicain">Technicain</option>
            <option value="employee" selected>Employee</option>
        </select>

        <label for="signup_name">Name: </label>
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

        <input type="submit" value="Create">
    </form>
</body>

</html>