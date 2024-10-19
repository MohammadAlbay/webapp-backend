<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body dir="rtl">
    <h1>تحويل مبلغ مالي من محفظتك</h1>
    <p>
        {{$transactionInfo['desc']}}
    </p>

    <table border="1">
        <tr>
            <th>الحساب</th>
            <th>القيمة</th>
            <th>التاريخ</th>
            @if($transactionInfo['type'] == 'Sub')
            <th>تاريخ انتهاء الصلاحية</th>
            @endif
        </tr>
        <tr>
            <td>{{$transactionInfo['outWallet']->owner->fullname}}</td>
            <td>{{$transactionInfo['balance']}} LYD</td>
            <td>{{now()}}</td>
            @if($transactionInfo['type'] == 'Sub')
            <td>{{$transactionInfo['due']}}</td>
            @endif
        </tr>
    </table>
</body>
</html>

<!-- 
inWallet
outWallet
balance
type
desc
due-->