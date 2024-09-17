<?php

use Illuminate\Support\Facades\Auth;

$me = Auth::guard('employee')->user();
$myId = $me->id;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sources/main.css">
    <link rel="stylesheet" href="/sources/employee/css/index.css">
    <!--<title>Document</title>-->
</head>

<body>
    <div class="page-header">
        <h3 class="page-title"> قائمة الفنين  </h3>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">بيانات الفنين</h4>
                <table class="table">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">profile</th>
                        <th scope="col">fullname</th>
                        <th scope="col">email</th>
                        <th scope="col">phone</th>
                        <th scope="col">nationality</th>
                        <th scope="col">address</th>
                        <th scope="col">specialization</th>
                        <th scope="col">created_at</th>
                        <th scope="col">state</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($technicians as $technician)
                        @php
                        $stateSwtch = $technician->state == 'Active' ? 'Inactive' : 'Active';
                        @endphp
                        <tr>
                            <td>{{$technician->id}}</td>
                            <td>{{ $technician->profile }}</td>
                            <td>{{ $technician->fullname }}</td>
                            <td>{{ $technician->email }}</td>
                            <td>{{ $technician->phone }}</td>
                            <td>{{ $technician->nationality }}</td>
                            <td>{{ $technician->address }}</td>
                            <td>{{$technician->Specialization()->name}}</td>
                            <td>{{ $technician->created_at }}</td>
                            <td>{{ $technician->state }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  
   
</body>

</html>