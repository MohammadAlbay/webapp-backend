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
        <h3 class="page-title"> قائمة الفنيين </h3>
    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">بيانات الفنيين</h4>
                <!-- <p class="card-description">قم بإدخال بيانات موظف جديد فالنموذج التالي</p> -->
                <div style="padding:0.5em;border:2px solid gray; border-radius:0.5em">
                    <button onclick="searchForTechnicain(search_input)" id="search_btn" class="btn btn-primary">بحث</button>
                    <input oninput="processInput(this, search_btn)" type="text" style="width:85%; margin-right:1em;height:100%;border:none;border-bottom:1px solid gray; outline:none" name="search_input" id="search_input" placeholder="بحث عن فني">

                </div>
                <div id="nodata-view" style="text-align:center; display: block;">
                    <h3 style="margin-top:1em;">اخر 100 فني مسجل
                        (عدد السجلات
                        {{$technicains->count()}}
                        )
                    </h3>
                    @include('employee.dashboard.technicain-searchview')
                </div>
                <div id="data-view" style="display:none">

                </div>
            </div>
        </div>
    </div>
    <div class="window close">
        <div class="header">
            <b class="title"> الملف الشخصي</b>
            <span class="close-icon" onclick='closeFrame(this)'>&#10005;</span>
        </div>
        <div class="container"><iframe id="iframe" src="/" frameborder="0" style="width:100%;min-height:600px; height:100%"></iframe></div>
        
    </div>
    <script src="/sources/employee/js/index.js"></script>

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
        async function searchForTechnicain(input) {
            const dataViewDiv = document.querySelector('#data-view');
            const nodataViewDiv = document.querySelector('#nodata-view');

            const url = "/employee/search-technicain";

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
            } else {
                nodataViewDiv.innerHTML = "<h5 style='margin-top:1em; text-align:center'>"+`لا يوجد بيانات متطابقة!`+"</h5>";
                nodataViewDiv.style.display = "block";
                dataViewDiv.style.display = "none";
            }
        }
        async function setTechnicainState(id, state) {
            const url = "/employee/technicain-state/";

            let payload = {
                'technicainID': id,
                'state': state
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
                }).then((result) => ViewFetch.Load('manage-technicain'));
            }
        }
        async function showWalletInRecord(transactions) {
            let text = "<ol>"
            transactions.forEach((t, i) => {
                text += `<li> رقم البطاقة هو ${t.card_serial}. بتاريخ ${t.created_at.split('T')[0]} بقيمة ${t.balance} د.ل</li>`;
            });
            Swal.fire({
                title: "<strong>قائمة بالكروت التي تم تعبئتها</strong>",
                html: `${text}</ol>`,
                showConfirmButton: true,
                confirmButtonText: "تم"
            });
        }
    
    
        async function prepareTechnicainView(id) {
            let frame =document.getElementById("iframe");
            frame.src = `/employee/technicain-view/${id}`;
            frame.parentElement.parentElement.className = "window open";
        }
        function closeFrame(self) {
            self.parentElement.parentElement.className = "window close";
        }
    </script>
</body>

</html>