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
        <h3 class="page-title"> بلاغات الزبائن </h3>
    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">تفاصيل البلاغات</h4>
                <!-- <p class="card-description">قم بإدخال بيانات موظف جديد فالنموذج التالي</p> -->
                <div style="padding:0.5em;border:2px solid gray; border-radius:0.5em">
                    <button onclick="searchForCustomerReports(search_input)" id="search_btn" class="btn btn-primary">بحث</button>
                    <input oninput="processInput(this, search_btn)" type="date" style="width:85%; margin-right:1em;height:100%;border:none;border-bottom:1px solid gray; outline:none" name="search_input" id="search_input">

                </div>
                <div id="nodata-view" style="text-align:center; display: block;">
                <h3 style="margin-top:1em;">اخر 100 بلاغ
                        (عدد السجلات
                            {{$reports->count()}}
                        )
                    </h3>
                    @include('employee.dashboard.customer-reports-searchview')
                </div>
                <div id="data-view" style="display:none">

                </div>
            </div>
        </div>
    </div>

    <script src="/sources/employee/js/index.js"></script>
    <script src="/sources/employee/js/propper.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        async function processInput(self, button) {
            const dataViewDiv = document.querySelector('#data-view');
            const nodataViewDiv = document.querySelector('#nodata-view');

            if (self.value.trim() === "") {
                button.disabled = true;

                nodataViewDiv.style.display = "block";
                dataViewDiv.style.display = "none";
                dataViewDiv.innerHTML = "";
            } else {
                button.disabled = false;
            }
        }
        async function searchForCustomerReports(input) {
            const dataViewDiv = document.querySelector('#data-view');
            const nodataViewDiv = document.querySelector('#nodata-view');

            const url = "/employee/customer/reports/search";

            let value = input.value.trim();

            if (value === "") return;

            let result = await sendDataNoCallbackText(url, 'Post', {
                search: value
            });
            if (result.trim() !== '') {
                nodataViewDiv.style.display = "none";
                dataViewDiv.style.display = "block";
                dataViewDiv.innerHTML = "";
                dataViewDiv.insertAdjacentHTML("beforeend", result);
                prepareBootstrapTooltip();
            } else {
                nodataViewDiv.innerHTML = `لا يوجد بيانات متطابقة!`;
                nodataViewDiv.style.display = "block";
                dataViewDiv.style.display = "none";
            }
        }

        function prepareBootstrapTooltip() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        }
        async function sendWarning(id) {
            const url = "/employee/customer/reports/warn";

            let payload = {
                'report': id
            }
            let result = await sendFormDataNoCallback(url, 'Post', payload);
            if (result.State == 1) {
                Swal.fire({
                    icon: 'error',
                    title: "حذث خطأ",
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: "اكتمل الاجراء",
                    text: result.Message,
                    showConfirmButton: true,
                    confirmButtonText: 'تم',
                    showDenyButton: true,
                    denyButtonText: `تعيين كـ مكتمل`,
                    denyButtonColor: '#00b300'
                }).then(async (result) => {
                    if (result.isConfirmed)
                        ViewFetch.Load('manage-customers-reports')
                    else if (result.isDenied)
                        await markDone(id);
                });
            }
        }

        async function blockTehcnicain(id) {
            const url = "/employee/customer/reports/restrict";

            let payload = {
                'report': id
            }
            let result = await sendFormDataNoCallback(url, 'Post', payload);
            if (result.State == 1) {
                Swal.fire({
                    icon: 'error',
                    title: "حذث خطأ",
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: "اكتمل الاجراء",
                    text: result.Message,
                    showConfirmButton: true,
                    confirmButtonText: 'تم',
                    showDenyButton: true,
                    denyButtonText: `تعيين كـ مكتمل`,
                    denyButtonColor: '#00b300'
                }).then(async (result) => {
                    if (result.isConfirmed)
                        ViewFetch.Load('manage-customers-reports')
                    else if (result.isDenied)
                        await markDone(id);
                });
            }
        }
        async function markDone(id) {
            const url = "/employee/customer/reports/done";

            let payload = {
                'report': id
            }
            let result = await sendFormDataNoCallback(url, 'Post', payload);
            if (result.State == 1) {
                Swal.fire({
                    icon: 'error',
                    title: "حذث خطأ",
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: "اكتمل الاجراء",
                    text: result.Message,
                    showConfirmButton: true,
                    confirmButtonText: 'تم'
                }).then(async (result) => ViewFetch.Load('manage-customers-reports'));
            }

        }
        setTimeout(() => {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('search_input').value = today;

            prepareBootstrapTooltip();
        }, 300);
    </script>
</body>

</html>