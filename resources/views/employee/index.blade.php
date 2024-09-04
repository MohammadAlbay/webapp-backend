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
    <button onclick="toggleDialog(dialog_manage_employee)">Show/Hide Employee</button>
    <button onclick="toggleDialog(dialog_manage_rolepermission)">Show/Hide Role permission</button>





    <dialog id="dialog_manage_rolepermission" class="employee_dialog">
        <h1>Function group: role permission</h1>
        <hr>
        <form action="{{route('employee.role.addpermission')}}" method="post">
            @csrf
            <label for="employee_roles">Role:</label>
            <select name="role" id="role">
                @foreach ($roles as $role)
                <option value="{{$role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            <label for="permission">Name :</label>
            <select name="permission" id="permission">
                @foreach ($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                @endforeach
            </select>

            <input type="submit" value="Assign and save">
        </form>
        @if($errors->has('role-exists'))
        <b style="color:Red">{{ $errors->first('role-exists')  }}</b>
        @endif

        <table border="1">
            <tr>
                <td>role id</td>
                <td>role name</td>
                <td>permission id</td>
                <td>permission name</td>
                <td></td>
            </tr>

            @foreach ($employees as $employee)
            @foreach ($employee->getPermissionList() as $rolePermission)
            <tr>
                <td>{{ $rolePermission->role_id }}</td>
                <td>{{ $rolePermission->getRoleName() }}</td>
                <td>{{ $rolePermission->permission_id }}</td>
                <td>{{ $rolePermission->getPermissionName() }}</td>
                <td><a href="{{route('employee.role.removepermission', $rolePermission->id)}}" style="color: red">Delete Permission</a></td>
            </tr>
            @endforeach

            @endforeach
        </table>

        <h2>Errors: </h2>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @else
            <b style="color:green">No Errors!</b>
        @endif
    </dialog>


    <dialog id="dialog_manage_employee" class="employee_dialog">
        <h1>Function group: employee</h1>
        <hr>
        <a href="/signup">create employee account</a>
        <table border="1">
            <tr>
                <td>id</td>
                <td>name</td>
                <td>email</td>
                <td>role</td>
                <td>change state</td>
            </tr>
            @foreach ($employees as $employee)
            <tr>
                <td>{{$employee->id}}</td>
                <td>{{$employee->fullname}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->role()->name}}</td>
                <td><button><a href="{{route('employee.switchstate', ["id" => $employee->id, "state" => ($employee->state == "Active" ? "Inactive" : "Active")] )}}">
                {{($employee->state == "Active" ? "Inactive" : "Active")}}
                </a></button></td>
            </tr>
            @endforeach
        </table>
        <h2>Errors: </h2>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @else
            <b style="color:green">No Errors!</b>
        @endif
    </dialog>

    <dialog id="dialog_add_role" class="employee_dialog">
        <h1>Function group: role</h1>
        <form action="{{route('employee.role.add')}}" method="post">
            @csrf
            <label for="role_name">Name :</label><input type="text" name="role_name" id="role_name">
            <input type="submit" value="Save">
        </form>

        <ul>
            @foreach ($roles as $role)
            <li>
                {{ $role->name }}
            </li>
            @endforeach
        </ul>
        <h2>Errors: </h2>
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @else
            <b style="color:green">No Errors!</b>
        @endif
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