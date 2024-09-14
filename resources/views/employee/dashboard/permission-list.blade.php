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
    <title>Permissions list</title>
</head>

<body>
    <div class="page-header">
        <h3 class="page-title"> قائمة الصلاحيات </h3>
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
                <h4 class="card-title">قائمة بالصلاحيات</h4>
                <p class="card-description">تعرض هذه الصفحة قائمة بالصلاحيات المدعومة فالنظام</p>

                <table>
                    <tr>
                        <td>#</td>
                        <td>الاسم</td>
                        <td>الحالة</td>
                        <td>-</td>
                    </tr>

                    @foreach ($permissions as $permission)
                    @php
                    $stateSwtch = $permission->state == 'Active' ? 'Inactive' : 'Active';
                    @endphp
                    <tr>
                        <td>{{$permission->id}}</td>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->state}}</td>
                        <td>
                            <b style="color:{{$stateSwtch == 'Active' ? 'green' : 'red'}};cursor:pointer;"
                                onclick="switchPermissionState({{$permission->id}});">
                                {{($stateSwtch == 'Active') ? "Activate" : "Deactivate"}}
                            </b>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    <script src="/sources/employee/js/index.js"></script>
    <script>
        async function switchPermissionState(id) {
            if (id == null) return;

            Swal.fire({
                title: "هل انت متأكد?",
                text: "تغييرك لحالة الصلاحية سينعكس على كافة الموظفين المتحصلين علظ هذه الصلاحية",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "الغاء",
                confirmButtonText: "موافق"
            }).then(async (result) => {
                if (result.isConfirmed) 
                    await requestSwitchState(id);

            });
        }

        async function requestSwitchState(id) {
            await sendFormData('/employee/permission/switchstate/' + id, 'POST', {}, v => {
                if (v.State == 1) {
                    Swal.fire({
                        icon: "error",
                        title: v.Message,
                        showConfirmButton: true,
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: v.Message,
                        showConfirmButton: true,
                    }).then((result) => ViewFetch.Load('permission-list'));

                }
            });
        }
    </script>
</body>

</html>