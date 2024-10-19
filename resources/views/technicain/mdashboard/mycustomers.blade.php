<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

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
</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar")
    @include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width" style="background-color:green">
                <div class="profile-headblock">
                    <div class="cover" style='background-image: url({{ ($me->cover != "" && $me->cover != null) ? "/cloud/technicain/$me->id/images/$me->cover" : "/sources/img/cover.jpg"}})'>
     
                        <div class="edit" onclick="changeCoverImageProcessor()"></div>

                    </div>
                    <div class="pic" style='background-image: url( {{($me->profile == "Male.jpg" || $me->profile == "Female.jpg") ? "/sources/img/$me->profile" : "/cloud/technicain/$me->id/images/$me->profile"}});'>

                        <div class="pic-hover-content" onclick="changeProfileImageProcessor()">
                            تغيير
                        </div>
                    </div>
                    <div class="name">{{$me->fullname}}</div>
                    
                </div>
            </div>

        </div>
        <div class="md-grid-item full-width" style="border-radius: 1em;">
            <table class="green-table" dir="rtl">
                <tr>
                    <th>#</th>
                    <th></th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>State</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>
                        <div class="profile-stack-container xxl">
                            <img src="https://images.unsplash.com/photo-1727447903891-f4a3bad38598?q=80&w=1374&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
                        </div>
                    </td>
                    <td>Mohammad albay</td>
                    <td>12/10/2024 2:50 PM</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td class="profile-stack-container">
                        <img src="" alt="">
                    </td>
                    <td>Ali Khalid</td>
                    <td>30/11/2024 6:50 PM</td>
                </tr>
            </table>
        </div>
    </div>
    </div>



    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>
</body>

</html>