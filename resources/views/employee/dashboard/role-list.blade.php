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
        <h3 class="page-title"> قائمة المسميات الوظيفية </h3>

    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">قائمة المسميات الوظيفية</h4>
                <p class="card-description">تعرض هذه الصفحة قائمة بالمسميات الوظيفية المدعومة فالنظام
                @if($me->hasPermission(\App\Models\Permission::PERMISSION_ADD_ROLE_NAME))
                        . لاضافة مسمى وظيفي جديد 
                        انقر على
                        <a style="text-decoration: underline; color:blue; cursor:pointer" onclick="add_role_dialog.setAttribute('open', '')">اضافة مسمى وظيفي</a>
                @endif
                </p>

                <div id="accordion">
                    @foreach ($roles as $role)
                    @if($role->name == "System") 
                        @continue 
                    @endif
                    <div class="card">
                        <div class="card-header" id="heading{{$role->id}}">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$role->id}}" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    المسمى الوظيفي {{$role->name}}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{$role->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$role->id}}" data-parent="#accordion">
                            <div class="card-body">

                            @if($me->hasPermission(\App\Models\Permission::PERMISSION_EDIT_ROLE_NAME))
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
                            @endif
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
                                        @if($me->hasPermission(\App\Models\Permission::PERMISSION_EDIT_ROLE_NAME))
                                            @if($stateSwtch == 'Active')
                                            <button class="btn btn-primary" onclick="switchRolePermission({{$rolePermission->id}})">تفعيل</button>
                                            @else
                                            <button class="btn btn-danger" onclick="switchRolePermission({{$rolePermission->id}})">الغاء التفعيل</button>
                                            @endif
                                        @else
                                            🚫
                                        @endif
                                        </td>
                                        <td>
                                            @if($me->role()->name == 'Admin')
                                                <button class="btn btn-danger" onclick="deleteRolePermission({{$rolePermission->id}})">حذف</button>
                                            @else
                                                🚫
                                            @endif
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


    <dialog id="add_role_dialog" class="ui-dialog1">
        <h1>اضافة مسمى وظيفي جديد</h1>
        <div class="ui-dialog-content-container">
            <div class="card">
                <div class="card-body">
                    <p class="card-description"></p>
                    <form id="add-role-form1" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();" action="{{route('signup.create')}}" class="forms-sample">
                        @csrf
                        <div class="form-group row">
                            <label for="add_role_name" class="col-sm-3 col-form-label">المسمى الوظيفي</label>
                            <div class="col-sm-9">
                                <input onchange="checkForDuplicateName(this)" required
                                    type="text" class="form-control" id="add_role_name"
                                    name="add_role_name" placeholder="المسمى الوظيفي">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="add_role_permissions_repo" class="col-sm-3 col-form-label">اختر الصلاحيات </label>
                            <div class="col-sm-9">
                                <select class="form-control" id="add_role_permissions_repo" multiple>
                                    @foreach ($permissions as $p)
                                    <option value="{{$p->id }}"  {{($p->name == App\Models\Permission::PERMISSION_ALLOW_LOGIN_NAME) ? "selected" : ""}}>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary mr-2"
                            onclick="addRoleProcessor(this);">إضافة</button>
                        <button class="btn btn-light" onclick="add_role_dialog.removeAttribute('open')">إلغاء</button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>
    <script src="/sources/employee/js/index.js"></script>
    <script>
        let permissions = @json($permissions, JSON_PRETTY_PRINT);
        let roles = @json($roles, JSON_PRETTY_PRINT);

        function checkForDuplicateName(self) {
            if (self.value == "") return;

            let enteredValue = self.value.toLowerCase();
            let matches = roles.filter(role => enteredValue == role.name.toLowerCase());

            if (matches != null && matches.length != 0) {
                self.value = "";
                Swal.fire({
                    icon: "error",
                    title: "قيمة اسم المسمى الوظيفي لا يمكن ان تتكرر",
                    showConfirmButton: true,
                });
            }

        }

        async function addRoleProcessor(self) {
            self.disabled = true;
            let permissionsOptionSelect = document.getElementById('add_role_permissions_repo');
            let permissionsOptionsNames = ([...permissionsOptionSelect.selectedOptions].map(a => a.innerText));
            let permissionsOptionsIds = ([...permissionsOptionSelect.selectedOptions].map(a => a.value));
            console.log(permissionsOptionsIds);
            Swal.fire({
                icon: "question",
                title: `هل انت متأكد من منح الصلاحيات التالية : 
            ${permissionsOptionsNames.length == 0 ? "لم يتم الاختيار بعد" : permissionsOptionsNames.join(', ')}`,
                showConfirmButton: true,
                showCancelButton: true,
            }).then(async (result) => {
                if (result.isConfirmed) {
                    let roleInfo = await requestAddingRole();
                    if (roleInfo == null) {
                        console.info("addRoleProcessor: Can't continue the process due to role info oject being null")
                        return;
                    }
                    await requestAssignRolePermission(roleInfo.id, permissionsOptionsIds);
                    add_role_dialog.removeAttribute('open');
                }
            });

            self.disabled = false;
        }

        async function requestAssignRolePermission(id, list) {
            if (id == null) return;

            let failer = 0;
            list.forEach(async p => {
                let payload = {
                    "_token": "{{ csrf_token() }}",
                    "role": id
                };
                payload[`permisison_${id}`] = p;
                await sendFormData('/employee/role/addpermission', 'POST', payload, v => {
                    if (v.State == 1) {
                        failer++;
                        Swal.fire({
                            icon: "error",
                            title: v.Message,
                            showConfirmButton: true,
                        });
                    }
                })
            });

            if (failer == 0) {
                Swal.fire({
                    icon: "success",
                    title: "تم حفظ المسمى الوظيفي",
                    showConfirmButton: true,
                }).then(result => {
                    ViewFetch.Load('role-list');
                });
            }
        }
        async function requestAddingRole() {
            let data = null;
            let payload = {
                "_token": "{{ csrf_token() }}",
                "role_name": document.forms["add-role-form1"].elements["add_role_name"].value
            };
            await sendFormData('/employee/role/add', 'POST', payload, async v => {
                if (v.State == 1) {
                    Swal.fire({
                        icon: "error",
                        title: v.Message,
                        showConfirmButton: true,
                    });
                } else
                    data = v.Message;
            })
            return data;
        }

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