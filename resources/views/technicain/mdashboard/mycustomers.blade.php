<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="/sources/main.css">
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
        .no-data-section {
            margin: 0 auto;
            width: 80%;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin-top: 2em;
            background-color: #3e84e6;
            border-radius: 1em;
            border: 1px solid darkgray;
            min-width: 15em;
            max-width: 35em;
        }
    </style>
</head>

<body>
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " زبائني"])
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
        <h1 dir="rtl" class="title" style="text-indent:80px;width:100%;font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">قائمة الزبائن</h1>
        
        <div>
        @if($customers->count() > 0)
            <table class="green-table" dir="rtl">
                <tr>
                    <th>#</th>
                    <th></th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                </tr>
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
                            <div class="profile-stack-container xxl">
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
            </table>
        @else
                <div class="no-data-section">
                        <h3>لا توجد أي سجلات لعرضها</h3>
                    </div>
        @endif
        </div>
                
            
        </div>
    </div>
    </div>

    
    <dialog id="add-post-dialog" class="fullscreen-dialog">
        <div class="topbar-container">
            <div class="close" onclick="showDialog()"></div>
            <div class="title">اضافة منشور</div>
        </div>
        <div class="container" style="overflow-y:auto">
            <div class="md-grid-container">
                <div class="md-grid-item half-width " style="border-radius: 1em; padding-bottom:1em; background-color:rgba(244,244,244);">
                    <b class="title">نص المنشور</b>
                    <div>
                        <textarea onchange="" name="techincain-add-post-textarea" id="techincain-add-post-textarea" class="post-textarea"></textarea>
                    </div>
                </div>
                <div class="md-grid-item half-width " style="border-radius: 1em; padding-bottom:1em;  background-color:rgba(244,244,244);">
                    <b class="title">صور وفيديوهات المنشور</b>
                    <button id="techincain-add-post-addmedia" class="button-image">
                        <img src="https://img.icons8.com/?size=100&id=IA4hgI5aWiHD&format=png&color=000000" alt="">
                        <i>اضافة</i>
                    </button>
                    <div id="techincain-add-post-imagelist" style="height:20em; padding:0.2em;white-space: nowrap;overflow-x:scroll;overflow-y:hidden;">
                    </div>
                </div>
            </div>
            <div class="md-grid-container md-grid-item full-width" style="background-color: transparent; border:none;">
                <div class="md-grid-item full-width full-height" style="border-radius: 1em; padding-bottom:1em;">
                    <b class="title">للنشر اضغط على زر النشر ادناه</b>
                    <button id="techincain-add-post-submit" class="button-image">
                        <img src="https://img.icons8.com/?size=100&id=103205&format=png&color=000000" alt="">
                        <i>نشر</i>
                    </button>
                </div>
            </div>
        </div>
    </dialog>


    <script src="/bad-word/word.js"></script>


    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>
</body>

</html>