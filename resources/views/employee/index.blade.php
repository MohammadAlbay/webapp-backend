<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Employee/Index</title>

    <link rel="stylesheet" href="/sources/employee/css/index.css">
</head>

<body>
    <a href="/login/end/employee/">logout</a>

    <h1>Employee : {{$me->fullname}} - Balance: {{$me->wallet->balance}} LYD</h1>

    <button onclick="toggleDialog(dialog_add_specialization)">Show/Hide specialization</button>
    <button onclick="toggleDialog(dialog_add_role)">Show/Hide Roles</button>




    <dialog id="dialog_add_role" class="employee_dialog">
    <h1>Function group: role</h1>    
    <form action="{{route('employee.role.add')}}" method="post">
            @csrf
            <label for="role_name">Name :</label><input type="text" name="role_name" id="role_name">
            <input type="submit" value="Save">
        </form>
        @if($errors->has('role-exists'))
        <b style="color:Red">{{ $errors->first('role-exists')  }}</b>
        @endif
        <ul>
            @foreach ($roles as $role)
            <li>
                {{ $role->name }}
            </li>
            @endforeach
        </ul>
    </dialog>





    <dialog id="dialog_add_specialization" class="employee_dialog">
        <h1>Function group: specialization</h1>
        @isset($done)
        <button>{{$done}}</button>
        @endisset
        <form action="{{route('employee.specialization.add')}}" method="post">
            @csrf
            <label for="spec_name">Name :</label><input type="text" name="spec_name" id="spec_name">
            <input type="submit" value="Save">
        </form>
        @if($errors->has('specialization-exists'))
        <b style="color:Red">{{ $errors->first('specialization-exists')  }}</b>
        @endif
        <ul>
            @foreach ($specializations as $spec)
            <li>
                {{ $spec->name }}
                <a href="{{route('employee.specialization.setstate', ["id" => $spec->id, "state" =>( $spec->state == 'Active' ? 'Inactive' : 'Active')] )}}">
                    {{$spec->state == 'Active' ? 'Inactive' : 'Active'}}
                </a>
            </li>
            @endforeach
        </ul>
        @if($errors->has('missing-specialization'))
        <b style="color:Red">{{ $errors->first('missing-specialization')  }}</b>
        @endif
    </dialog>

    <script src="/sources/employee/js/index.js"></script>
</body>

</html>