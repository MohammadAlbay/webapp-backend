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
        <h3 class="page-title">الصفحة الرئيسية </h3>

    </div>

    <div class="d-flex grid-margin stretch-card">
        <div class="card" style="width:100%">
            <div class="card-body">
                <div id="data-view" style="width:100%; text-align: center;">
                    <div class="stats-container">
                        <h3 style="margin-top:3em;color:black; text-align:right; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                            بيانات النظام
                        </h3>
                        <div class="stats">
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:40pt; margin-top:0.5em;color:black">{{$techniainsCount->value}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        فني نشط
                                    </b></div>
                            </div>
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$customersCount->value}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        زبون نشط
                                    </b></div>
                            </div>
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$employeesCount ? $employeesCount->value : 0}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        موظف نشط
                                    </b></div>
                            </div>
                        </div>
                        <div class="stats">
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:40pt; margin-top:0.5em;color:black">{{$techniainsInactiveCount ? $techniainsInactiveCount->value : 0}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        فني غير نشط
                                    </b></div>
                            </div>
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$postsDeployedCount ? $postsDeployedCount->value : 0}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        منشور تم نشره
                                    </b></div>
                            </div>
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:30pt; margin-top:1em;color:black">{{$averageRateCount ? $averageRateCount->value : 0}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        متوسط التقييمات
                                    </b></div>
                            </div>
                        </div>
                    </div>



                    <div class="stats-container">
                        <h3 style="margin-top:3em;color:black; text-align:right; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                            توزيع الفنيين
                        </h3>
                        <div class="stats">
                            @php $counter = 1; @endphp
                            @foreach ($technicainDistrobutions as $n)
                                @if($counter == 5)
                                    </div>
                                    <div class="stats">
                                    @php $counter = 1; @endphp
                                @endif
                            <div class="flex-item" style="height:200px; border:1px solid #33c92d">
                                <h2 style="width:100%; text-align:center; font-size:40pt; margin-top:0.5em;color:black">{{$n->value}} </h2>
                                <div style="width:100%; text-align:center;"><b style="color:#33c92d; text-decoration:none; font-weight:normal; font-size:20pt; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        {{$n->address}}
                                    </b></div>
                            </div>
                            @php $counter++; @endphp
                            @endforeach
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
                    legend: {
                        position: 'bottom'
                    }, // Position of the legend
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
                    legend: {
                        position: 'right',
                        textStyle: {
                            direction: 'rtl'
                        }
                    }, // RTL configuration
                    hAxis: {
                        direction: -1
                    },
                };

                // Draw
                const chart = new google.visualization.PieChart(document.getElementById(container_id));
                chart.draw(data, options);

            }
        }
        async function getFinanceInformation(self, input) {
            self.disabled = true;
            let loadingLabel = document.getElementById('loadingLabel');
            let st_container = document.getElementById('st_container');
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