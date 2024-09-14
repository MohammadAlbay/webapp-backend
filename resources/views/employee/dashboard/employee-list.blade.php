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
                        <td>profile</td>
                        <td>الاسم</td>
                        <td>البريد الاكتروني</td>
                        <td>المسمى الوظيفي</td>
                        <td>الجنس</td>
                        <td>العنوان</td>
                        <td>رقم الهاتف</td>
                        <td>الحالة</td>
                        <td>تاريخ الانضمام</td>
                        <td> - </td>
                        <td> - </td>
                    </tr>

                    @foreach ($employees as $employee)
                    @php
                    $stateSwtch = $employee->state == 'Active' ? 'Inactive' : 'Active';
                    @endphp
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
                        <td>{{$employee->created_at}}</td>
                        @if($myId != $employee->id)
                        <td><b style="color:green;cursor:pointer;" onclick="prepareDialog(add_employee_dialog_edit_employee, '{{$employee->id}}')">Edit</b></td>
                            @if($employee->role()->name != "Admin")
                                <td><b style="color:red;cursor:pointer;" onclick='processEmployee(this, "{{$employee->id}}",  "{{$stateSwtch}}")'>
                                    {{$stateSwtch == "Active" ? "Activate" : "Deactivate"}}
                                </b></td>
                                <td><b style="color:red;cursor:pointer;" onclick="processDeleteEmployee(this, '{{$employee->id}}')">Delete</b></td>
                            @else
                                <td>-</td>
                                <td>-</td>
                            @endif
                        @else
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        @endif
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
    <dialog id="add_employee_dialog_edit_employee" class="ui-dialog1">
        <h1>تعديل بيانات موظف</h1>
        <div class="ui-dialog-content-container">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="card-title">بيانات موظف جديد</h4> -->
                    <p class="card-description">قم بإدخال البيانات الجديدة للموظف الذي تريد تغيير بياناته فالنموذج التالي</p>
                    <form id="edit-employee-form1" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();" action="{{route('signup.create')}}" class="forms-sample">
                        @csrf
                        <input type="text" style="display: none;" name="employee_id" id="employee_id">
                        <div class="form-group row">
                            <label for="edit_employee_fullname" class="col-sm-3 col-form-label">اسم الموظف</label>
                            <div class="col-sm-9">
                                <input required type="text" class="form-control" id="edit_employee_fullname" name="edit_employee_fullname" placeholder="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_employee_email" class="col-sm-3 col-form-label">البريد الاكتروني</label>
                            <div class="col-sm-9">
                                <input required type="email" class="form-control" id="edit_employee_email" name="edit_employee_email" placeholder="Email" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_employee_phone" class="col-sm-3 col-form-label">رقم الهاتف</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_employee_phone" name="edit_employee_phone" placeholder="Phone number">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_employee_address" class="col-sm-3 col-form-label">العنوان</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="edit_employee_address" name="edit_employee_address" placeholder="Address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_employee_role" class="col-sm-3 col-form-label">المسمى الوظيفي</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="edit_employee_role" name="edit_employee_role" {{$me->role()->name == "Admin" ? "readonly" : ""}}>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="edit_employee_gender" class="col-sm-3 col-form-label">الجنس</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="edit_employee_gender" name="edit_employee_gender">
                                    <option value="Male">ذكر</option>
                                    <option value="Female">انثى</option>
                                </select>

                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mr-2"
                            onclick="editEmployeeProcessor(this);">Submit</button>
                        <button class="btn btn-light" onclick="add_employee_dialog_edit_employee.removeAttribute('open')">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>
    <script src="/sources/employee/js/index.js"></script>
    <script>
        var roles = @json($roles, JSON_PRETTY_PRINT);
        var employees = @json($employees, JSON_PRETTY_PRINT);

        function prepareDialog(dialog, id) {
            let row = employees.filter(e => e.id == id);
            if (row == null || row.length == 0) return;
            row = row[0];
            edit_employee_fullname.value = row.fullname;
            edit_employee_email.value = row.email
            edit_employee_phone.value = row.phone
            edit_employee_address.value = row.address
            edit_employee_role.value = row.role_id; //roles.filter(r => r.id == row.role_id)[0].name;
            edit_employee_gender.value = row.gender;
            employee_id.value = row.id;
            dialog.setAttribute('open', '');
        }

        async function editEmployeeProcessor(self) {
            self.disabled = true;
            await sendFormData('/employee/edit', "POST", new FormData(document.forms['edit-employee-form1']), v => {

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
                    }).then((result) => {
                        ViewFetch.Load('employee-list');
                    });

                }

            });
            self.disabled = false;
        }
        async function processEmployee(self, id, whatToDo) {
            self.disabled = true;
            await sendFormData('/employee/switchstate/' + id + '/' + whatToDo, "GET", {}, v => {

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
                    }).then((result) => {
                        ViewFetch.Load('employee-list');
                    });

                }

            });
            self.disabled = false;
        }

        async function processDeleteEmployee(self, id) {
            self.disabled = true;
            await sendFormData('/employee/delete/' + id, "GET", {}, v => {

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
                    });

                    Swal.fire({
                        title: v.Message,
                        icon: "success",
                        showConfirmButton: true
                    }).then((result) => {
                        ViewFetch.Load('employee-list');
                    });


                }

            });
            self.disabled = false;
        }
    </script>
</body>

</html>