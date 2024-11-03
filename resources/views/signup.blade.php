<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/signup.css') }}">
    <title>Sign Up</title>
</head>

<body>
    <div class="container">
        <h2 class="arabic-text">
            <span class="black-text">فني</span>
            <span class="green-text">لعندك</span>
        </h2>
        <h1>Sign Up Us</h1>
        <div class="card" onclick="location.href = '{{ route('signup.registertechnicain_view')}}'">
            <img src="{{ asset('rahma-ui/storage/images/technician.png') }}" alt="Technician Icon">
            <p>Technician</p>
        </div>
        <div class="card" onclick="location.href = '{{ route('signup.registercustomer_view')}}'">
            <img src="{{ asset('rahma-ui/storage/images/man (1).png') }}" alt="Client Icon">
            <p>Client</p>
        </div>
    </div>
    <!-- <script src="script.js"></script> -->
</body>

</html>

<!-- 
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

    <a href="{{ route('signup.registercustomer_view')}}">
        @csrf
        <input type="text" style="display: none;" name="signup_type" id="signup_type" value="Technicain">
        <button type="submit">عميل</button>
    </form>
    <a href="{{ route('signup.registertechnicain_view')}}">
        <button type="submit">الفني</button>
    </a>

      <!--  <label for="signup_name">Name: </label>

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
    
</body>

</html> -->