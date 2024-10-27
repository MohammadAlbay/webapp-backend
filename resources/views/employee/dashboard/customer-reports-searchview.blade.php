@if($reports->count() != 0)
@php
$reportLevels = [
    'harmlvl1' => 'السب والشتم وسوء المعاملة',
    'harmlvl2' => 'افساد ممتلكات شخصية او اضاعت مواد كان قد اشتراها الزبون',
    'harmlvl3' => 'التعدي الجسدي او اي شيء قد يمس بصحة الزبون'
];
@endphp
<table id="customers-table">
    <tr>
        <td>#</td>
        <td>قام بالبلاغ</td>
        <td>بلغ عن</td>
        <td>البريد الالكتروني للمبلغ عنه</td>
        <td>سبب البلاغ</td>
        <td>الحالة</td>
        <td>تاريخ البلاغ</td>
        <td> - </td>
        <td> - </td>
        <td> - </td>
    </tr>

    @foreach ($reports as $report)
    @php
    $customer = $report->customer();
    $technicain = $report->technicain();

    $customerUponReportsCount = $customer->reportsUponMe()->count();
    $technicainUponReportsCount = $technicain->reportsUponMe()->count();
    @endphp
    <tr>
        <td>{{$report->id}}</td>
        <td data-bs-toggle="tooltip" data-bs-placement="bottom" title="تم البلاغ عليه {{$customerUponReportsCount}} مره">{{$customer->fullname}}</td>
        <td data-bs-toggle="tooltip" data-bs-placement="bottom" title="تم البلاغ عليه {{$technicainUponReportsCount}} مره">{{$technicain->fullname}}</td>
        <td>{{$technicain->email}}</td>
        <td>{{$reportLevels[$report->description]}}</td>
        <td>{{$report->state == 'Done' ? 'مكتمل' : 'قيد الانتظار'}}</td>
        <td>{{$report->created_at}}</td>
        @if($report->state == 'Done')
        <td><button class="btn btn-danger" disabled>ارسال تنبيه</button></td>
        <td><button class="btn btn-danger" disabled>حظر الفني</button></td>
        <td><button class="btn btn-warning" disabled>تعيين كـ مكتمل</button></td>
        @else
        <td><button onclick="sendWarning({{$report->id}})" class="btn btn-danger">ارسال تنبيه</button></td>
        <td><button onclick="blockTehcnicain({{$report->id}})" class="btn btn-danger">حظر الفني</button></td>
        <td><button onclick="markDone({{$report->id}})" class="btn btn-warning">تعيين كـ مكتمل</button></td>
        @endif
    </tr>
    @endforeach

</table>
@endif