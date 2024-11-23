@if($me->hasPermission(\App\Models\Permission::PERMISSION_ADD_EMPLOYEE_NAME))
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="page-header">
        <h3 class="page-title"> اضافة موظف </h3>
    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">بيانات موظف جديد</h4>
                <p class="card-description">قم بإدخال بيانات موظف جديد فالنموذج التالي</p>
                <form id="add-employee-form1" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();" action="{{route('signup.create')}}" class="forms-sample">
                    @csrf
                    <input type="text" style="display: none;" name="signup_type" id="signup_type" value="employee">
                    <div class="form-group row">
                        <label for="add_employee_fullname" class="col-sm-3 col-form-label">اسم الموظف</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" id="add_employee_fullname" name="add_employee_fullname" placeholder="الإسم">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="add_employee_email" class="col-sm-3 col-form-label">البريد الاكتروني</label>
                        <div class="col-sm-9">
                            <input required type="email" class="form-control" id="add_employee_email" name="add_employee_email" placeholder="البريد الإلكتروني">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="add_employee_password" class="col-sm-3 col-form-label">كلمة المرور</label>
                        <div class="col-sm-9">
                            <input required type="password" class="form-control" id="add_employee_password" name="add_employee_password" placeholder="كلمة المرور">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="add_employee_phone" class="col-sm-3 col-form-label">رقم الهاتف</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add_employee_phone" name="add_employee_phone" placeholder="رقم الهاتف">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="add_employee_address" class="col-sm-3 col-form-label">العنوان</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add_employee_address" name="add_employee_address" placeholder="العنوان">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="add_employee_role" class="col-sm-3 col-form-label">المسمى الوظيفي</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="add_employee_role" name="add_employee_role">
                                @foreach ($roles as $role)
                                    @if($role->name == "System") 
                                        @continue 
                                    @endif
                                    <option value="{{$role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="add_employee_gender" class="col-sm-3 col-form-label">الجنس</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="add_employee_gender" name="add_employee_gender">
                                <option value="Male">ذكر</option>
                                <option value="Female">انثى</option>
                            </select>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2"
                        onclick="addEmployeeProcessor(this);">إضافة</button>
                    <button class="btn btn-light">إلغاء</button>
                </form>
            </div>
        </div>
    </div>
    <script src="/sources/employee/js/index.js"></script>
    <script>
        if (typeof add_employee_check == 'undefined') {
            let add_employee_check = '';
        }

        async function addEmployeeProcessor(butn) {
            event.preventDefault();

            let form = document.forms['add-employee-form1'];
            //return;
            await sendFormData(form.action, "POST", new FormData(form), v => {
                //alert();
                if(v.State == 1) {
                    Swal.fire({
                    icon: "error",
                    title: v.Message,
                    showConfirmButton: true,
                    //timer: 1500
                });
                } else {
                    Swal.fire({
                    icon: "success",
                    title: "اكتمل الاجراء",
                    text: v.Message,
                    showConfirmButton: true,
                    //timer: 1500
                    }).then((result) => ViewFetch.Load('add-employee'));
                }
                
            });
        }
    </script>
</body>

</html>
@endif