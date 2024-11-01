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

