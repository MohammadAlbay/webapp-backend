<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Profile</title>

    <link rel="stylesheet" href="/sources/main.css">
    <link rel="stylesheet" href="/sources/technicain/css/button.css">
    <link rel="stylesheet" href="/sources/technicain/css/input.css">
    <link rel="stylesheet" href="/sources/technicain/css/index.css">
    <link rel="stylesheet" href="/sources/technicain/css/calendar.css">

    <link rel="stylesheet" href="/sources/technicain/css/profile.css">
    @if($viewer != '')
    <link rel="stylesheet" href="/sources/technicain/css/posts.css">
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/sources/main.js"></script>
    <script src="/sources/employee/js/index.js"></script>

    <style>
        .error-card {
            width: 95%;
            margin: 0 auto;
            background-color: rgb(216, 32, 32);
            border-radius: 0.5em;
            padding: 0.5em;
            box-sizing: border-box;
            color: white;
            opacity: 1;
            transition: opacity 1s ease-in-out 5s;
        }

        .hide-now {
            opacity: 0;
        }
    </style>


</head>

<body>
    @include("technicain.mdashboard.rate-dialog")
    @include("technicain.mdashboard.md-dash-nav-bar")
    @if($viewer === '')
        @include("technicain.mdashboard.md-dash-nav-barmenu")
    @endif
    <div class="md-container" style="overflow-y: auto;padding-top:0px;">

        <div class="md-grid-container" style="overflow: auto;">
            <div class="md-grid-item full-width" style="background-color:green">
                <div class="profile-headblock">
                    <div class="cover" style='background-image: url({{ ($me->cover != "" && $me->cover != null) ? "/cloud/technicain/$me->id/images/$me->cover" : "/sources/img/cover.jpg"}})'>
                    @if($viewer === '')    
                        <div class="edit" onclick="changeCoverImageProcessor()"></div>
                    @endif
                    </div>
                    <div class="pic" style='background-image: url( {{($me->profile == "Male.jpg" || $me->profile == "Female.jpg") ? "/sources/img/$me->profile" : "/cloud/technicain/$me->id/images/$me->profile"}});'>
                    @if($viewer === '')    
                        <div class="pic-hover-content" onclick="changeProfileImageProcessor()">
                            تغيير
                        </div>
                    @endif
                    </div>
                    <div class="name">{{$me->fullname}}</div>
                    @if($viewer !== '')    
                    <div class="rate-block">
                        <img src="https://img.icons8.com/?size=100&id=19417&format=png&color=000000">
                        <i>3.6</i>
                        <i onclick="RateProcessor.show(rate_dialog);">تقييم</i>
                    </div>
                    @endif
                </div>
            </div>

        </div>
        
        @if($viewer !== '')
        @include('technicain.mdashboard.posts-listview')
        @else

        <div class="md-grid-container md-grid-item full-width" dir="rtl" style="border-radius: 1em;">
            <b class="title">مركز التنبيهات</b>
            <div>Not yet</div>
        </div>
        <div class="md-grid-container full-width" dir="rtl" style="background: transparent; border:none;">
            <div class="md-grid-item half-width" style="border-radius: 1em;">
                <b class="title">جدول الاعمال الحالي</b>
                <div>
                    <table class="calendar">
                        <thead>
                            <tr>
                                <th>Sun</th>
                                <th>Mon</th>
                                <th>Tue</th>
                                <th>Wed</th>
                                <th>Thu</th>
                                <th>Fri</th>
                                <th>Sat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                                <td>5</td>
                                <td>6</td>
                                <td>7</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>9</td>
                                <td>10</td>
                                <td>11</td>
                                <td>12</td>
                                <td>13</td>
                                <td>14</td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>16</td>
                                <td>17</td>
                                <td>18</td>
                                <td>19</td>
                                <td>20</td>
                                <td>21</td>
                            </tr>
                            <tr>
                                <td>22</td>
                                <td>23</td>
                                <td>24</td>
                                <td>25</td>
                                <td>26</td>
                                <td>27</td>
                                <td>28</td>
                            </tr>
                            <tr>
                                <td>29</td>
                                <td>30</td>
                                <td>31</td>
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="md-grid-item half-width" style="border-radius: 1em; padding-bottom:1em">
                <b class="title">بياناتك الشخصية</b>
                <div>
                    @if($errors->any())
                    <div class="error-card">
                        <h5>قائمة الاخطأء فالمدخلات</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif



                    <form id="form_technicain_edit" action="/technicain/edit" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_name">اسم الفني</label>
                            <input type="text" id="technicain_field_name" name="technicain_field_name" placeholder="" form="form_technicain_edit" value='{{$me->fullname}}'>
                        </div>
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_phone">رقم الهاتف</label>
                            <input type="tel" id="technicain_field_phone" name="technicain_field_phone" placeholder="" form="form_technicain_edit" value='{{$me->phone}}'>
                        </div>
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_address">العنوان</label>
                            <input type="text" id="technicain_field_address" name="technicain_field_address" placeholder="" form="form_technicain_edit" value='{{$me->address}}'>
                        </div>
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_nationality">الجنسية</label>
                            <select id="technicain_field_nationality" name="technicain_field_nationality" placeholder="" form="form_technicain_edit">
                                <option value="ليبي">ليبي</option>
                                <option value="تونسي">تونسي</option>
                                <option value="مصري">مصري</option>
                                <option value="تشادي">تشادي</option>
                                <option value="مغربي">مغربي</option>
                                <option value="جزائري">جزائري</option>
                                <option value="موريتاني">موريتاني</option>
                                <option value="سوداني">سوداني</option>
                                <option value="تشادي">تشادي</option>
                                <option value="نيجري">نيجري</option>
                                <option value="افريقي">افريقي</option>
                                <option value="اسيوي">اسيوي</option>
                            </select>
                        </div>
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_birthdate">تاريخ الميلاد</label>
                            <input type="date" id="technicain_field_birthdate" name="technicain_field_birthdate" placeholder="" form="form_technicain_edit" value='{{$me->birthdate}}'>
                        </div>
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_gender">الجنس</label>
                            <select id="technicain_field_gender" name="technicain_field_gender" placeholder="" form="form_technicain_edit">
                                <option value="Male" {{$me->gender == 'Male' ? 'selected' : ''}}>ذكر</option>
                                <option value="Female" {{$me->gender == 'Female' ? 'selected' : ''}}>انثى</option>
                            </select>
                        </div>
                        <div class="ux-input2">
                            <img src="https://img.icons8.com/?size=100&id=19949&format=png&color=000000" alt="">
                            <label for="technicain_field_specialize">التخصص </label>
                            <select id="technicain_field_specialize" name="technicain_field_specialize" placeholder="" form="form_technicain_edit">
                                <option value="{{$me->specialization_id}}">{{$me->specializationName()}}</option>
                                @foreach ($specialization as $s)
                                @if($s->id == $me->specialization_id)
                                @continue
                                @else
                                <option value="{{$s->id}}">{{$s->name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="ux-input2 btn success" onclick="confromEditData()">
                            تغيير
                        </div>
                    </form>
                </div>
            </div>

        </div>

        @endif
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

    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>



    @if($viewer != '')
    <script src="/sources/technicain/js/posts.js"></script>
    <script>
        let slideshows = document.querySelectorAll('.slideshow-container');
        slideshows.forEach(e => {
            PostsView.setupNewSlider(e, e.querySelector('.next'), e.querySelector('.prev'))
        });

        PostsView.isTechnicain = false;
        PostsView.actorId = {{$viewer->id}}

        RateProcessor.setupRateDialog(rate_dialog);
    </script>
    @else
    <script>
        PostsView.isTechnicain = true;
        PostsView.actorId = {{$me->id}}
    </script>
    @if(session('info-updated'))
    @if(session('info-updated') == true)
    <script>
        Swal.fire({
            icon: 'success',
            title: 'اكتملت العملية',
            text: 'تم تعديل بيانات الحساب بنجاح'
        });
    </script>
    @endif
    @endif

    @if($me->profile == 'Male.jpg' || $me->profile == 'Female.jpg')
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'تنبيه',
            text: "يرجى تغيير الصورة الشخصية حتى تتكمن من تفعيل خدمات حسابك"
        });
    </script>
    @endif
    <script>
        setTimeout(() => {
            let errCard = document.querySelector('.error-card');
            if (errCard == null) return;
            errCard.addEventListener("transitionend", (event) => {
                errCard.remove();
            });
            errCard.classList.add('hide-now');
        }, 1000);
    </script>
    @endif
</body>

</html>