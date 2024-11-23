<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mycustomer</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">
    <link rel="stylesheet" href="/sources/technicain/css/calendar.css">
    <link rel="stylesheet" href="/sources/technicain/css/profile.css">
    <link rel="stylesheet" href="/sources/technicain/css/mycustomers.css">
    <link rel="stylesheet" href="/sources/technicain/css/image-stack.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/main.js"></script>
    <script src="/sources/employee/js/index.js"></script>

    <style>
      
        .md-grid-item.full-width {
    grid-column: 1 / -1; /* Full-width */
    text-align: right; /* Align text to the right */
      }
body {
            font-family: 'Cairo', sans-serif; /* Apply the Cairo font */
        }
        /*when there is no data */
        .no-data-section {
    margin: 2em auto; /* Center the section horizontally */
    width: 80%;
    text-align: center;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    border-radius: 1em;
    min-width: 15em;
    max-width: 35em;
    display: flex; 
    flex-direction: column;
    align-items: center; 
    justify-content: center;
    height: 400px; 
}

.no-data-image {
    width: 300px; 
    height: auto; 
    margin-bottom: 10px; 
}
h3 {
            font-family: 'Cairo', sans-serif; 
        }
    </style>
</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " زبائني"])
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width">
             
            <div class="md-grid-item full-width" dir="rtl">
                <h1 class="title" >قائمة الزبائن المتعامل معهم</h1>
                <div>
        @if($customers->count() > 0)
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">إسم العميل</th>
                    <th scope="col">البريد الإلكتروني</th>
                    <th scope="col">رقم الهاتف </th>
                    <th scope="col">تاريخ المعاملة</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp <!--  counter -->
                @php
                $counter = 1;
                @endphp
                @foreach($customers as $s)
                    @php
                    $c = $s->customer();
                    @endphp
                    <tr>
                        <td>{{$counter++}}</td>
                        <td>
                            <div class="profile-stack-container m">
                                <img src="{{($c->profile == "Male.jpg" || $c->profile == "Female.jpg") ? "/sources/img/$c->profile" : "/cloud/customer/$c->id/images/$c->profile"}}" alt="">
                            </div>
                        </td>
                        <td>{{$c->fullname}}</td>
                        <td>{{$c->email}}</td>
                        <td>{{$c->phone}}</td>
                        <td>{{$s->created_at}}</td>

                    </tr>

                @php
                $counter++;
                @endphp
                @endforeach
            </tbody>
            </table>
        @else
        <div class="no-data-section">
            <img src="{{ asset('rahma-ui/assets/images/mans.png') }}" alt="No Data" class="no-data-image">
            <h3> إذهب للعمل واكتسب عملاء</h3>
        </div>
        @endif
           </div>
            </div>
        </div>

    </div>

    


    <script src="/bad-word/word.js"></script>


    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>
</body>

</html>