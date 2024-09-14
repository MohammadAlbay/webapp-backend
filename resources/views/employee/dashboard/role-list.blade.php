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
    <title>Role list</title>
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

    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">قائمة بالصلاحيات</h4>
                <p class="card-description">تعرض هذه الصفحة قائمة بالصلاحيات المدعومة فالنظام</p>




                <div id="accordion">
                    @foreach ($roles as $role)
                    <div class="card">
                        <div class="card-header" id="heading{{$role->id}}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$role->id}}" aria-expanded="true" aria-controls="collapse{{$role->id}}">
                                    المسمى الوظيفي {{$role->name}}
                                </button>
                            </h5>
                        </div>

                        <div id="collapse{{$role->id}}" class="collapse show" aria-labelledby="heading{{$role->id}}" data-parent="#accordion">
                            <div class="card-body">
                                
                            <form class="form-inline" id="add_permission_form_id_{{$role->id}}">
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="add_permission_select_{{$role->id}}" class="sr-only">الصلاحية</label>
                                        <select class="form-control" id="permisison_{{$role->id}}" name="permisison_{{$role->id}}">
                                        @foreach ($permissions as $p)
                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <input type="text" name="role" readonly style="display:none" value="{{$role->id}}">
                                    <button type="submit" class="btn btn-primary mb-2" 
                                        onclick="addPermissionToRole(this)" formid="add_permission_form_id_{{$role->id}}">اضافة</button>
                                </form>

                                @if($role->permissions->count() > 0)
                                <table>
                                    <tr>
                                        <td>#</td>
                                        <td>الاسم</td>
                                        <td>الحالة</td>
                                        <td>-</td>
                                        <td>-</td>
                                    </tr>
                                    @foreach ($role->permissions as $rolePermission)
                                    @php
                                    $stateSwtch = $rolePermission->state == 'Active' ? 'Inactive' : 'Active';
                                    @endphp
                                    <tr>
                                        <td>{{$rolePermission->permission_id}}</td>
                                        <td>{{$rolePermission->getPermissionName()}}</td>
                                        <td>{{$rolePermission->state}}</td>
                                        <td>
                                            <a href="#" style="color: {{$stateSwtch == 'Active' ? 'green' : 'orange'}};" onclick="switchRolePermission({{$rolePermission->id}})">
                                                {{$stateSwtch == 'Active'? "Activate" : "Deactivate"}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" style="color: red;" onclick="deleteRolePermission({{$rolePermission->id}})">
                                                Remove
                                            </a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </table>
                                @else
                                <h5>No permissions yet!</h5>
                                @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>

            </div>
        </div>
    </div>
    <script src="/sources/employee/js/index.js"></script>
    <script>
        let permissions = @json($permissions, JSON_PRETTY_PRINT);
        let roles = @json($roles, JSON_PRETTY_PRINT);
        async function switchRolePermission(id) {
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
            await sendFormData('/employee/role/switchstate/' + id, 'POST', {}, v => {
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
                    }).then((result) => ViewFetch.Load('role-list'));

                }
            });
        }


        async function deleteRolePermission(id) {
            if (id == null) return;

            Swal.fire({
                title: "هل انت متأكد?",
                text: "حذفك للصلاحية يلغي بعض الامكانيات للمستخدمين المتحصلين عليها",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "الغاء",
                confirmButtonText: "موافق"
            }).then(async (result) => {
                if (result.isConfirmed)
                    await requestDeleteRolePermission(id);

            });
        }

        async function requestDeleteRolePermission(id) {
            await sendFormData('/employee/role/removepermission/' + id, 'POST', {}, v => {
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
                    }).then((result) => ViewFetch.Load('role-list'));

                }
            });
        }


        async function addPermissionToRole(self) {
            event.preventDefault();
            self.disabled = true;
            await sendFormData('/employee/role/addpermission', 'POST', new FormData(document.forms[self.getAttribute('formid')]), v => {
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
                    }).then((result) => ViewFetch.Load('role-list'));

                }
            });
            self.disabled = false;
        }
    </script>
</body>

</html>