@if($customers->count() != 0)
<table id="customers-table">
    <tr>
        <td>#</td>
        <td>profile</td>
        <td>الاسم</td>
        <td>البريد الاكتروني</td>
        <td>المحفظة</td>
        <td>الجنس</td>
        <td>العنوان</td>
        <td>رقم الهاتف</td>
        <td>الحالة</td>
        <td>تاريخ الانضمام</td>
        <td> - </td>
        <td> - </td>
    </tr>

    @foreach ($customers as $customer)
    @php
    $stateSwtch = $customer->state == 'Active' ? 'Inactive' : 'Active';
    @endphp
    <tr>
        <td>{{$customer->id}}</td>
        <td><img style="border-radius:50%;width: 41px; height:41px" src={{ ($customer->profile == "Male.jpg" || $customer->profile == "Female.jpg") ? "/sources/img/$customer->profile" : "/cloud/customer/$customer->id/images/$customer->profile"}} alt=""></td>
        <td>{{$customer->fullname}}</td>
        <td>{{$customer->email}}</td>
        <td onclick='showWalletInRecord(@json($customer->transactions))' title="انقر لعرض سجل الكروت التي تم تعبئتها" style="cursor:pointer;text-decoration: underline;color:blue">{{$customer->wallet->balance}} د.ل</td>
        <td>{{$customer->gender}}</td>
        <td>{{$customer->address}}</td>
        <td>{{$customer->phone}}</td>
        <td>{{$customer->state == 'Bloced' ? "محظور" : ($customer->state == 'Active' ? "مفعل" : "غير مفعل")}}</td>
        <td>{{$customer->created_at}}</td>
        <td>
            @if($customer->state == 'Bloced')
            -
            @elseif($customer->state == 'Active')
            <button onclick="setCustomerState({{$customer->id}},'Inactive')"  class="btn btn-danger">الغاء التفعيل</button>
            @else
            <button onclick="setCustomerState({{$customer->id}},'Active')" class="btn btn-primary">تفعيل</button>
            @endif
        </td>
        <td>
            @if($customer->state == 'Bloced')
                @if($customer->email_verified_at != "")
                <button onclick="setCustomerState({{$customer->id}},'Active')"  class="btn btn-primary">الغاء الحظر</button>
                @else
                <button onclick="setCustomerState({{$customer->id}},'Inactive')"  class="btn btn-primary">الغاء الحظر</button>
                @endif
            @else
            <button onclick="setCustomerState({{$customer->id}},'Bloced')"  class="btn btn-danger">حظر المستخدم</button>
            @endif
        </td>
    </tr>
    @endforeach

</table>
@endif