<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sources/main.css">
    <title>Document</title>
</head>

<body>
    <div class="page-header">
        <h3 class="page-title"> قائمة الموظفين </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/employee">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Employee</li>
            </ol>
        </nav>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">بيانات الموظفين</h4>
                <!-- <p class="card-description">قم بإدخال بيانات موظف جديد فالنموذج التالي</p> -->

                <table>
                    <tr>
                    <td>#</td>
                    <td>profile</td>td>
                    <td>الاسم</td>
                    <td>البريد الاكتروني</td>
                    <td>المسمى الوظيفي</td>
                    <td>الجنس</td>
                    <td>العنوان</td>
                    <td>رقم الهاتف</td>
                    <td>الحالة</td>
                    <td> - </td>
                    <td> - </td>
                    </tr>

                    @foreach ($employees as $employee)
                        <tr>
                            <td>{{$employee->id}}</td>
                            <td><img style="width: 41px; height:41px" src={{ $employee->profile == "" ? "/sources/img/icons8_circled_user_male_skin_type_4_127px.png" : $employee->profile}} alt=""></td>
                            <td>{{$employee->fullname}}</td>
                            <td>{{$employee->email}}</td>
                            <td>{{$employee->role()->name}}</td>
                            <td>{{$employee->gender}}</td>
                            <td>{{$employee->address}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>{{$employee->state}}</td>
                            <td><b style="color:green;cursor:pointer;">Edit</b></td>
                            <td><b style="color:red;cursor:pointer;">Delete</b></td>
                        </tr>
                    @endforeach
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>