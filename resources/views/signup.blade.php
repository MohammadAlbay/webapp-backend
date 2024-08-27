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
    <form action="{{ route('signup.create')}}" method="post">
        @csrf

        <label for="signup_type">Choose User type: </label>
        <select name="signup_type" id="signup_type">
            <option value="programmer">Programmer</option>
            <option value="company">Company</option>
        </select>

        <label for="signup_name">Name: </label>
        <input type="text" name="signup_name" id="signup_name">

        <label for="signup_qualification">Choose Qualification: </label>
        <select name="signup_qualification" id="signup_qualification">
            <option value="UN-EDUCATED">Un educated</option>
            <option value="SELF-EDUCATED">self educated</option>
            <option value="PREPARATIVE">preprative</option>
            <option value="SECONDARY">secondary</option>
            <option value="BACHELOR">bachelor</option>
            <option value="MASTER">Master</option>
            <option value="DOCTOR">doctor</option>
            <option value="PROFESSOR">professor</option>
        </select>

        <label for="signup_email">Email: </label>
        <input type="emial" name="signup_email" id="signup_email" value="MohammadAlbay@gmail.com">

        <label for="signup_password">Password: </label>
        <input type="password" name="signup_password" id="signup_password" value="1">

        <label for="signup_studiedat">Studied at: </label>
        <input type="text" name="signup_studiedat" id="signup_studiedat">

        <input type="submit" value="Create">
    </form>
</body>
</html>