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
    <title>Specializations list</title>
</head>

<body>
    <div class="page-header">
        <h3 class="page-title"> قائمة بالتخصصات </h3>
    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">قائمة بالتخصصات</h4>
                <p class="card-description">تعرض هذه الصفحة قائمة بالتخصصات المدعومة فالنظام
                    .
                    بامكانك اضافة المزيد عبر النقر على 
                    <a onclick="addNewSpecialization()" style="color: blue; text-decoration:underline;cursor:pointer">اضافة تخصص جديد</a>
                </p>

                <table>
                    <tr>
                        <td>#</td>
                        <td></td>
                        <td>الاسم</td>
                        <td>الحالة</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                    @foreach ($specializations as $specialization)
                    @php
                    $stateSwtch = $specialization->state == 'Active' ? 'Inactive' : 'Active';
                    @endphp
                    <tr>
                        <td>{{$specialization->id}}</td>
                        <td>
                            <img style="width: 36px;height:36px; border-radius:50%" src="/sources/specializations/{{$specialization->image}}" alt="">
                        </td>
                        <td>{{$specialization->name}}</td>
                        <td>{{$specialization->state}}</td>
                        <td><button class="btn btn-primary" onclick="changeSpecializationName({{$specialization->id}})">تغيير الاسم</button></td>
                        <td><button class="btn btn-primary" onclick="changeSpecializationImage({{$specialization->id}})">تغيير الصورة </button></td>
                        <td>
                            @if($stateSwtch == 'Active')
                            <button class="btn btn-primary" onclick="switchSpecializationState({{$specialization->id}});">تفعيل</button>
                            @else
                            <button class="btn btn-danger" onclick="switchSpecializationState({{$specialization->id}});">الغاء التفعيل</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    <script src="/sources/employee/js/index.js"></script>
    <script>
        async function openFilePicker(multiple = false) {
            return new Promise((resolve, reject) => {
                let input = document.createElement('input');
                input.type = 'file';
                input.style.display = 'none';
                input.accept = "image/*";

                if (multiple)
                    input.setAttribute('multiple', '');

                input.addEventListener('change', () => {
                    if (input.files.length > 0)
                        resolve(input.files);
                    else
                        reject(new Error('No files selected'));
                });

                input.click();
            });
        }
    </script>
    <script>
        async function switchSpecializationState(id) {
            if (id == null) return;

            Swal.fire({
                title: "هل انت متأكد?",
                text: "تغييرك لحالة التخصص سينعكس على كافة وظائف النظام",
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
            await sendFormData('/employee/specialization/switchstate/' + id, 'POST', {}, v => {
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
                    }).then((result) => ViewFetch.Load('specializations-list'));

                }
            });
        }

        async function changeSpecializationName(id) {
            if (id == null) return;

            const {
                value: newName
            } = await Swal.fire({
                title: "تغيير اسم التخصص",
                text: "تغييرك لاسم التخصص سينعكس على كافة وظائف النظام",
                icon: "warning",
                input: 'text',
                inputPlaceholder: "الاسم الجديد للتخصص",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "الغاء",
                confirmButtonText: "موافق"
            });

            if (!newName) return;

            let url = `/employee/specialization/setname/${id}`;
            let result = await sendFormDataNoCallback(url, 'Post', {
                name: newName
            });
            if (result.State == 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'حدثت مشكلة',
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'اكتمل الاجراء',
                    text: result.Message,
                    showConfirmButton: true,
                    confirmButtonText: 'تم'
                }).then((result) => ViewFetch.Load('specializations-list'));
            }
        }


        async function changeSpecializationImage(id) {
            if (id == null) return;

            openFilePicker().then(async files => {
                const formData = new FormData();
                formData.append('image', files[0]);

                let url = `/employee/specialization/setimage/${id}`;
                let result = await sendFormDataNoCallback(url, 'Post', formData);
                if (result.State == 1) {
                    Swal.fire({
                        icon: 'error',
                        title: 'حدثت مشكلة',
                        text: result.Message
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'اكتمل الاجراء',
                        text: result.Message,
                        showConfirmButton: true,
                        confirmButtonText: 'تم'
                    }).then((result) => ViewFetch.Load('specializations-list'));
                }
            }).catch(error => {
                console.info(error);
            });
        }


        async function addNewSpecialization() {
            const {
                value: name
            } = await Swal.fire({
                title: "اختر اسم التخصص",
                text: "اختيارك لاسم التخصص سينعكس على كافة وظائف النظام",
                icon: "info",
                input: 'text',
                inputPlaceholder: "اسم التخصص الجديد",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "الغاء",
                confirmButtonText: "موافق"
            });

            if (!name) return;

            let url = `/employee/specialization/create`;
            let result = await sendFormDataNoCallback(url, 'Post', {
                name: name
            });
            if (result.State == 1) {
                Swal.fire({
                    icon: 'error',
                    title: 'حدثت مشكلة',
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'اكتمل الاجراء',
                    text: result.Message,
                    showConfirmButton: true,
                    confirmButtonText: 'تم'
                }).then((result) => ViewFetch.Load('specializations-list'));
            }
        }
    </script>
</body>

</html>