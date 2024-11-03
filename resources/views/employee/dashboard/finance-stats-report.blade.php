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
        <h3 class="page-title">الاحصائات المالية </h3>
        <nav>
            <button class="btn btn-primary" onclick="print()">طباعة</button>
        </nav>
    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card" style="width:100%">
            <div class="card-body">
                <h4 class="card-title">الاحصائات المالية</h4>
                <!-- <p class="card-description">قم بإدخال بيانات موظف جديد فالنموذج التالي</p> -->
                <div style="padding:0.5em;border:2px solid gray; border-radius:0.5em">
                    <button onclick="getFinanceInformation(this,search_input)" id="search_btn" class="btn btn-primary">بحث</button>
                    <input oninput="processInput(this, search_btn)" type="number" min="2024" value="{{now()->year}}" max="{{now()->year}}" step="1" style="width:85%; margin-right:1em;height:100%;border:none;border-bottom:1px solid gray; outline:none" name="search_input" id="search_input" placeholder="بحث عن زبون">

                </div>

                <div id="data-view" style="width:100%; text-align: center;">
                    <h5 id="loadingLabel" style="display:none;text-align:center; margin-top:1em; color:black;font-size:40pt">
                        قيد المعالجة
                        ...
                    </h5>
                    <div  class="stats-container">
                        <h3 style="margin-top:3em;color:black; text-align:right; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                             بيانات احصائية عامة
                        </h3>
                        <div class="stats">
                            <div class="flex-item" style="height:200px;">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$transactionTypeOther ? $transactionTypeOther->value : 0}} د.ل</h2>
                                <div style="width:100%; text-align:center;"><b style=" text-decoration:none; font-weight:normal; color:rgba(0,0,0,5)">
                                    اجمالي عقوبات/غرامات 
                                </b></div>
                            </div>
                            <div class="flex-item" style="height:200px;">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$transactionTypeSub ? $transactionTypeSub->value : 0}} د.ل</h2>
                                <div style="width:100%; text-align:center;"><b style=" text-decoration:none; font-weight:normal; color:rgba(0,0,0,5)">
                                    اجمالي الاشتراكات 
                                </b></div>
                            </div>
                            <div class="flex-item" style="height:200px;">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$systemWallet ? $systemWallet->balance : 0}} د.ل</h2>
                                <div style="width:100%; text-align:center;"><b style=" text-decoration:none; font-weight:normal; color:rgba(0,0,0,5)">
                                    محفظة النظام
                                </b></div>
                                
                            </div>
                        </div>
                    </div>
                    <div id="st_container" class="stats-container" style="display:none;">
                        <h3 style="margin-top:3em;color:black; text-align:right; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                            بيانات واحصائات تتعلق بالاشتراكات
                        </h3>
                        <div class="stats">
                            <div id="sub-count-vs-month" class="flex-item" style="height:500px;width:40%"></div>
                            <div id="sub-money-vs-month" class="flex-item" style="height:500px;width:40%"></div>
                        </div>
                        <br>
                        <h3 style="color:black; text-align:right; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                            بيانات واحصائات تتعلق ببطاقات الدفع (الكروت)
                        </h3>
                        <div class="stats">
                            <div id="prepaidcard-state-vs-percentage" class="flex-item" style="height:400px;width:40%"></div>
                            <div id="prepaidcard-fav-vs-percentage" class="flex-item" style="height:400px;width:40%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/sources/employee/js/google-loader.js"></script>
    <script src="/sources/employee/js/index.js"></script>
    <!-- <script src="https://www.gstatic.com/charts/loader.js"></script> -->

    <script>
        async function initChart() {
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                // Set Data
                const data = google.visualization.arrayToDataTable([
                    ['Quantity', 'Month'],
                    [50, 7],
                    [60, 8],
                    [70, 8],
                    [80, 9],
                    [90, 9],
                    [100, 9],
                    [110, 10],
                    [120, 11],
                    [130, 14],
                    [140, 14],
                    [150, 15]
                ]);

                // Set Options
                const options = {
                    title: 'House Prices vs. Size',
                    hAxis: {
                        title: 'الاشتراكات'
                    },
                    vAxis: {
                        title: 'الاشهر'
                    },
                    legend: 'none'
                };

                // Draw
                const chart = new google.visualization.ScatterChart(document.getElementById('myChart'));
                chart.draw(data, options);

            }
        }

        //setTimeout(() => {initChart();}, 200);
    </script>
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
        async function renderSubsChart(statistics, container_id) {
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                // Set Data
                const data = google.visualization.arrayToDataTable(statistics);

                // Set Options
                const options = {
                    title: "",
                    hAxis: {
                        title: statistics[0][0]
                    },
                    vAxis: {
                        title: statistics[0][1]
                    },
                    legend: { position: 'bottom' }, // Position of the legend
                };

                // Draw
                const chart = new google.visualization.LineChart(document.getElementById(container_id));
                chart.draw(data, options);

            }
        }
        async function renderPrepaidcardPie(statistics, container_id) {
            google.charts.load('current', {
                packages: ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {

                // Set Data
                const data = google.visualization.arrayToDataTable(statistics);

                // Set Options
                const options = {
                    title: "",
                    legend: { position: 'right', textStyle: { direction: 'rtl' } }, // RTL configuration
                    hAxis: { direction: -1 },
                };

                // Draw
                const chart = new google.visualization.PieChart(document.getElementById(container_id));
                chart.draw(data, options);

            }
        }
        async function getFinanceInformation(self, input) {
            self.disabled = true;
            let loadingLabel = document.getElementById('loadingLabel');
            let st_container =document.getElementById('st_container');
            const dataViewDiv = document.querySelector('#data-view');
            const nodataViewDiv = document.querySelector('#nodata-view');

            const url = "/employee/finance-report";

            let value = input.value.trim();

            if (value === "") return;

            loadingLabel.style.display = "block";
            let result = await sendFormDataNoCallback(url, 'Post', {
                year: value
            });
            if (result.State == 1) {
                Swal.fire({
                    icon: 'error',
                    title: "حدثت مشكلة!",
                    text: result.Message
                });
            } else {
                //extract values from object
                const {
                    subscriptionMoneyPerMonth,
                    subscriptionCountPerMonth,
                    generatedPrepaidcardsInfo,
                    favPrepaidcardsInfo,
                    systemMoney
                } = result.Message;

                // render each graph/chart/etc


                renderSubsChart(subscriptionCountPerMonth, 'sub-count-vs-month');
                renderSubsChart(subscriptionMoneyPerMonth, 'sub-money-vs-month');

                renderPrepaidcardPie(generatedPrepaidcardsInfo, 'prepaidcard-state-vs-percentage');
                renderPrepaidcardPie(favPrepaidcardsInfo, 'prepaidcard-fav-vs-percentage');
                
            }


            self.disabled = false;
            st_container.style.display = "block";
            loadingLabel.style.display = "none";
        }
        async function setCustomerState(id, state) {
            const url = "/employee/customer-state/";

            let payload = {
                'customerID': id,
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
                }).then((result) => ViewFetch.Load('manage-customers'));
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
    </script>
</body>

</html>