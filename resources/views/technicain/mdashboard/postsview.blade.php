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

    <link rel="stylesheet" href="/sources/technicain/css/profile.css">
    <link rel="stylesheet" href="/sources/technicain/css/posts.css">

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
@include("technicain.mdashboard.md-dash-nav-bar", ['location' => " منشوراتي"])
@include("technicain.mdashboard.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;padding-top:0px">

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
                        <i>تقييم</i>
                    </div>
                    @endif
                </div>
            </div>

        </div>
        
        @include('technicain.mdashboard.posts-listview')
        <div class="loading" id="loading" style="display: none;">
            <p>Loading more posts...</p>
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

    <script src="/sources/technicain/js/index.js"></script>
    <script src="/sources/technicain/js/profile.js"></script>



    <script src="/sources/technicain/js/posts.js"></script>
    <script>
        let slideshows = document.querySelectorAll('.slideshow-container');
        slideshows.forEach(e => {
            PostsView.setupNewSlider(e, e.querySelector('.next'), e.querySelector('.prev'))
        });

        PostsView.isTechnicain = true;
        PostsView.actorId = {{$me->id}}
    </script>



    <script>
        let page = 1;
        let container = document.querySelector('.md-container');
        const loadMorePosts = () => {
            page++;
            fetch(`/technicain/posts?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(data => {
                if(!data.includes(`<h4 style="width:100%;text-align:center;color:gray">لا يوجد مناشير لعرضها</h4>`) && data != "")
                    document.querySelector('#posts_list').insertAdjacentHTML('beforeend', data);
                if (data.includes(`<h4 style="width:100%;text-align:center;color:gray">لا يوجد مناشير لعرضها</h4>`) || data === "") {
                    ///!data.trim()
                    container.removeEventListener('scroll', handleScroll);
                    document.getElementById('loading').style.display = 'none';
                }

                let slideshows = document.querySelectorAll('.slideshow-container:not([slider-index])');
                slideshows.forEach(e => {
                    PostsView.setupNewSlider(e, e.querySelector('.next'), e.querySelector('.prev'))
                });
            })
            .catch(error => console.error('Error:', error));
        };

        const handleScroll = () => {
            const { scrollTop, scrollHeight, clientHeight } = document.documentElement;

            //let scrollableDiv = document.querySelector('.md-container');
            const buffer = 10;
            const scrollPosition = container.scrollTop + container.clientHeight;
            const bottomPosition = container.scrollHeight - buffer;

            if (scrollPosition >= bottomPosition) {
                console.log("You've reached the bottom of the div!");
                document.getElementById('loading').style.display = 'block';
                loadMorePosts();
            }
        }

        container.addEventListener("scroll", handleScroll, { passive: true });

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

    @include('successful-task');


    <!-- For Regular Errors -->
    @if($errors->any())
        @foreach ($errors->all() as $err)
        <script>
        Swal.fire({
                toast: true,
                icon: "error",
                title: 'مشكلة في العملية',
                text: "{{$err}}",
                position: "top-end",
                showConfirmButton: false,
                timer: 900,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },

                didClose: () => {
                    location.reload();
                }
            });
    </script>
        @endforeach
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
</body>

</html>