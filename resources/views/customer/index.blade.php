<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="/login/end/customer/">logout</a>

    <h1>{{$me->fullname}} - Balance: {{$me->wallet->balance}} LYD</h1>
    <form id="form_search_technicains">
        <input type="text" name="search_field" id="search_field">
    </form>
    <button onclick="searchForTechnicain(self);"></button>



    <script>
        async function searchForTechnicain(self) {
            self.disabled = true;

            let result = await fetch('/customer/search')


            self.disabled = false;
        }
    </script>
</body>
</html>