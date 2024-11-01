<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="page-header">
        <h3 class="page-title"> تعديل بياناتي </h3>
    </div>
    





    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تعديل بياناتي</h4>
                <p class="card-description"></p>
                <form id="edit-mydata-form" autocomplete="off" method="post" enctype="multipart/form-data" onsubmit="event.preventDefault();" action="/employee/edit-mydata" class="forms-sample">
                    @csrf
                    <input type="text" id="employee_id" name="employee_id" value="{{$me->id}}" style=display:none>
                    <input type="text" style="display: none;" name="signup_type" id="signup_type" value="employee">
                    <div class="form-group row">
                        <label for="edit_employee_fullname" class="col-sm-3 col-form-label">اسم الموظف</label>
                        <div class="col-sm-9">
                            <input required type="text" class="form-control" id="edit_employee_fullname" name="edit_employee_fullname" placeholder="الاسم" value="{{$me->fullname}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label  class="col-sm-3 col-form-label">البريد الاكتروني</label>
                        <div class="col-sm-9">
                            <input required type="email" class="form-control" placeholder="Email" readonly value="{{$me->email}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_employee_password" class="col-sm-3 col-form-label">كلمة المرور</label>
                        <div class="col-sm-9">
                            <input required type="password" class="form-control" id="edit_employee_password" name="edit_employee_password" placeholder="اترك الحقل فارغا اذا لا تريد تغيير كلمة المرور">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_employee_phone" class="col-sm-3 col-form-label" >رقم الهاتف</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_employee_phone" name="edit_employee_phone" placeholder="كلمة المرور" value="{{$me->phone}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_employee_address" class="col-sm-3 col-form-label">العنوان</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_employee_address" name="edit_employee_address" placeholder="العنوان" value="{{$me->address}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_employee_role" class="col-sm-3 col-form-label">المسمى الوظيفي</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_employee_role" name="edit_employee_role">
                                @foreach ($roles as $role)
                                <option value="{{$role->id }}" {{$role->id == $me->role_id ? 'selected' : ''}}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="edit_employee_gender" class="col-sm-3 col-form-label">الجنس</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_employee_gender" name="edit_employee_gender">
                                <option value="Male" {{$me->gender == 'Male' ? 'selected' : ''}}>ذكر</option>
                                <option value="Female" {{$me->gender == 'Female' ? 'selected' : ''}}>انثى</option>
                            </select>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mr-2"
                        onclick="editEmployeeProcessor(this);">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                </form>
            </div>
        </div>
    </div>
    <script src="/sources/employee/js/index.js"></script>
    <script>
        if (typeof add_employee_check == 'undefined') {
            let add_employee_check = '';
        }

        async function editEmployeeProcessor(butn) {
            event.preventDefault();

            let form = document.forms['edit-mydata-form'];
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
                    }).then((result) => ViewFetch.Load('edit-mydata'));
                }
                
            });
        }
    </script>
</body>

</html>