<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Employee/Index</title>
</head>
<body>
    <a href="/login/end/employee/">logout</a>

    <h1>Employee : {{$me->fullname}} - Balance: {{$me->wallet->balance}} LYD</h1>

    <button onclick="toggleDialog(dialog_add_specialization)">Show/Hide</button>
    <dialog open id="dialog_add_specialization">
        <h1>Add specialization</h1>
        @isset($done)
            <button>{{$done}}</button>
        @endisset
        <form action="{{route('employee.addspecialization')}}" method="post">
            @csrf
            <label for="spec_name">Name :</label><input type="text" name="spec_name" id="spec_name">
            <input type="submit" value="Save">
        </form>
    </dialog>

    <script src="/sources/employee/js/index.js"></script>
</body>
</html>