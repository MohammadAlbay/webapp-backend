<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Profile</title>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
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
    @if($viewer !== '')
        <script src="/sources/technicain/js/reservations.js"></script>
    @endif

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

@if($viewer !== '')
        <style>
            .md-container {width:100%; right:0px}
        </style>
@endif

</head>

<body>
    @include("technicain.mdashboard.rate-dialog")
    @include("technicain.mdashboard.md-dash-nav-bar", ['location' => " ملفي الشخصي"])
    @if($viewer === '')
        @include("technicain.mdashboard.md-dash-nav-barmenu")
    @endif
    @include('technicain.mdashboard.calendar');
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
                        <i>{{$me->rateValue()}}</i>
                        @if($viewer->canRateTechnicain($me->id))
                            <i onclick="RateProcessor.show(rate_dialog);">تقييم</i>
                        @else
                            <i style="cursor:not-allowed">تقييم</i>
                        @endif
                    </div>
                    <div class="featured-buttons">
                            <div>
                                @if($reservation != null)
                                <button onclick="reportTechnicain({{$reservation->id}})" class="button-image warning">
                                    <img src="https://img.icons8.com/?size=100&id=F6dUI1dnIQZI&format=png&color=000000" alt="">
                                    <i>بلاغ</i>
                                </button>
                                @endif
                                <button class="button-image primary"  onclick={{$me->state == 'Active' ? "Calendar.toggle()" : "Calendar.notAllowed()"}}>
                                    <img src="https://img.icons8.com/?size=100&id=7979&format=png&color=000000" alt="">
                                    <i>حجز</i>
                                </button>
                                <b style="margin-top:0.5em;color:black; padding:0em 0.5em 0.5em 0.5em; background-color:white; border-radius:0.5em">يقيم في {{$me->address}}
                                </b>
                            </div>
                    </div>
                    @else
                        @if($me->state == 'Inactive')
                        <div class="featured-buttons">
                            <b>
                             انت غير مشترك. للاشتراك توجه لقائمة الخيارات على اليمين. ثم اختر اشتراكاتي
                            </b>
                        
                        </div>
                        @else
                        <div class="featured-buttons">
                            <div>
                            @if($me->state == 'Active')
                            <button class="button-image primary" onclick="switchAccountState('pause')">
                                <img src="https://img.icons8.com/?size=100&id=F6dUI1dnIQZI&format=png&color=000000" alt="">
                                <i>
                                    أخذ استراحة
                                </i>
                            </button>
                            @else
                            <button class="button-image primary" onclick="switchAccountState('continue')">
                                <img src="https://img.icons8.com/?size=100&id=F6dUI1dnIQZI&format=png&color=000000" alt="">
                                <i>
                                    عودة للعمل
                                </i>
                            </button>
                            @endif
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>

        </div>
        
        @if($viewer !== '')
        @include('technicain.mdashboard.posts-listview')
        @else

        <div class="md-grid-container md-grid-item full-width" dir="rtl" style="border-radius: 1em;">
            <div class="md-grid-item full-width" style="border:none"><b class="title">مركز التنبيهات</b></div>
            <div class="md-grid-item full-width" style="border:none">
                @php
                $newReservations = $me->pendingReservations()->count();
                @endphp
                @if($newReservations > 0)
                <div onclick="location.href='/technicain/scheduled-work';" class="notice-div" style="cursor:pointer">
                لديك 
                {{$newReservations}}
                حجز جديد! 
                تفقد بريدك الاكتروني للقبول او الرفض
                </div>
                @else
                <div class="notice-div">لا يوجد أي حجوزات جديدة</div>
                @endif
                @if($me->state == 'Active')
                <div class="notice-div">
                انت مشترك وتاريخ انتهاء صلاحية الاشتراك
                {{$me->wallet->lastOutgoingTransactions()->due}}
                </div>
                @endif
            </div>
        </div>
        <div class="md-grid-container full-width" dir="rtl" style="background: transparent; border:none;">
            
            <div class="md-grid-item full-width" style="border-radius: 1em; padding-bottom:1em">
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
                            <select id="technicain_field_address" name="technicain_field_address" placeholder="" form="form_technicain_edit" value='{{$me->address}}'>
                            @include('addresses-option');
                            </select>
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
                        <div id="submit_button" class="ux-input2 btn success" onclick="confromEditData()">
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
        Calendar.prepare(document.querySelector('#reservation-cc'));

        let slideshows = document.querySelectorAll('.slideshow-container');
        slideshows.forEach(e => {
            PostsView.setupNewSlider(e, e.querySelector('.next'), e.querySelector('.prev'))
        });

        PostsView.isTechnicain = false;
        PostsView.actorId = {{$viewer->id}}

        RateProcessor.setupRateDialog(rate_dialog);
    </script>
    <script>
        async function reportTechnicain(reservationID) {
            const {
                value: reportDesc
            } = await Swal.fire({
                title: 'تقديم بلاغ عن فني',
                text: 'قم بالاختيار من مربع الخيارات ادناه',
                showCancelButton: true,
                cancelButtonText: 'الغاء',
                cancelButtonColor: "#d33",
                showConfirmButton: true,
                confirmButtonText: 'اختيار',
                confirmButtonColor: "#3085d6",
                input: 'select',
                inputPlaceholder: 'اختر سبب البلاغ',
                inputOptions: {
                    harmlvl1: 'السب والشتم وسوء المعاملة',
                    harmlvl2: 'افساد ممتلكات شخصية او اضاعت مواد كان قد اشتراها الزبون',
                    harmlvl3: 'التعدي الجسدي او اي شيء قد يمس بصحة الزبون',
                },
            });

            if (!reportDesc) return;
            const url = "/customer/report";
            const data = {
                reason: reportDesc,
                reservation: reservationID
            };
            let result = await sendFormDataNoCallback(url, "POST", data);

            if (result.State == 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'فشل الاجراء',
                    text: result.Message
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'اكتمل الاجراء',
                    text: result.Message
                });
            }

        }
    </script>
    @else
    <script src="/bad-word/word.js"></script>
    <script>
        // PostsView.isTechnicain = true;
        // PostsView.actorId = {{$me->id}}

        setTimeout(() => {
            [...document.querySelector('#technicain_field_address').options]
            .forEach(o => {
                if(o.value == "{{$me->address}}")
                    o.selected = true;
            });

            document.getElementById('technicain_field_name')
            .addEventListener('change', e => {
                let btn = document.getElementById('submit_button');
                if(isDirty(e.target.value)) {
                    btn.classList.toggle('disabled', true);
                    Swal.fire({
                        icon: 'warning',
                        title: ' الفاظا بذيئة',
                        text: 'اكتشف النظام الفاظا اذيئة كنت قد ادخلتها في احد حقول الادخال. لن تتمكن من المتابعة حتى تعدل ما ادخلته',
                        timer: 4200,
                        timerProgressBar: true,
                        showConfirmButton:false
                    });
                }
                else 
                    btn.classList.toggle('disabled', false);
            });
        }, 200);
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