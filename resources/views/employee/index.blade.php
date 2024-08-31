<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee/Index</title>
</head>
<body>
    <a href="/login/end/customer/">logout</a>

    <h1>Employee : {{$me->fullname}} - Balance: {{$me->wallet->balance}} LYD</h1>

    <button id="show_add_specialization_dialog"></button>
    <dialog id="dialog_add_specialization">This is an open dialog window</dialog>

    <script src="/sources/employee/js/index.js"></script>
</body>
</html>