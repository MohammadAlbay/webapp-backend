@if($technicains->count() != 0)
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
        <td> - </td>
    </tr>

    @foreach ($technicains as $technicain)
    @php
    $stateSwtch = $technicain->state == 'Active' ? 'Inactive' : 'Active';
    @endphp
    <tr>
        <td>{{$technicain->id}}</td>
        <td><img style="border-radius:50%;width: 41px; height:41px" src={{ ($technicain->profile == "Male.jpg" || $technicain->profile == "Female.jpg") ? "/sources/img/$technicain->profile" : "/cloud/technicain/$technicain->id/images/$technicain->profile"}} alt=""></td>
        <td>{{$technicain->fullname}}</td>
        <td>{{$technicain->email}}</td>
        @if($me->hasPermission(\App\Models\Permission::PERMISSION_MANAGE_WALLETS_NAME)
        && $me->hasPermission(\App\Models\Permission::PERMISSION_PREPAIDCARDS_HISTORY_NAME))
            <td onclick='showWalletInRecord(@json($technicain->transactions))' title="انقر لعرض سجل الكروت التي تم تعبئتها" style="cursor:pointer;text-decoration: underline;color:blue">{{$technicain->wallet->balance}} د.ل</td>
        @elseif($me->hasPermission(\App\Models\Permission::PERMISSION_MANAGE_WALLETS_NAME))
            <td >{{$technicain->wallet->balance}} د.ل</td>
        @else
            <td>🚫</td>
        @endif
        <td>{{$technicain->gender}}</td>
        <td>{{$technicain->address}}</td>
        <td>{{$technicain->phone}}</td>
        <td>{{$technicain->state == 'Active' ? 'مشترك' : ($technicain->state == 'Bloced' ? 'محظور' : ($technicain->state == 'Paused' ? 'متوقف مؤقتا' : 'غير مشترك'))}}</td>
        <td>{{$technicain->created_at}}</td>
        <td>
            <button class="btn btn-success" onclick="prepareTechnicainView({{$technicain->id}})">الملف الشخصي</button>
        </td>
        <td>
        @if($me->hasPermission(\App\Models\Permission::PERMISSION_TECHNICAIN_EDIT_NAME))
            @if($technicain->state == 'Bloced')
            -
            @elseif($technicain->state == 'Active')
            <button onclick="setTechnicainState({{$technicain->id}},'Inactive')"  class="btn btn-danger">الغاء التفعيل</button>
            @else
            <button onclick="setTechnicainState({{$technicain->id}},'Active')" class="btn btn-primary">تفعيل</button>
            @endif
        @else
            🚫
        @endif
        </td>
        <td>
        @if($me->hasPermission(\App\Models\Permission::PERMISSION_TECHNICAIN_BLOCK_NAME))
            @if($technicain->state == 'Bloced')
                @if($technicain->email_verified_at != "")
                <button onclick="setTechnicainState({{$technicain->id}},'Active')"  class="btn btn-primary">الغاء الحظر</button>
                @else
                <button onclick="setTechnicainState({{$technicain->id}},'Inactive')"  class="btn btn-primary">الغاء الحظر</button>
                @endif
            @else
            <button onclick="setTechnicainState({{$technicain->id}},'Bloced')"  class="btn btn-danger">حظر المستخدم</button>
            @endif
        @else
            🚫
        @endif
        </td>
    </tr>
    @endforeach

</table>
@endif