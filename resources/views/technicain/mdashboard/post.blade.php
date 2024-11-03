@if(count($posts) != 0)
@foreach ($posts as $post)

<div class="post">
    <div class="header">
        <img class="profile-icon" src="{{($me->profile == "Male.jpg" || $me->profile == "Female.jpg") ? "/sources/img/$me->profile" : "/cloud/technicain/$me->id/images/$me->profile"}}" alt="">
        @if($viewer === '')
        <img onclick="location.href = '/technicain/editpost/{{$post->id}}'" class="edit-icon" src="https://img.icons8.com/?size=100&id=49&format=png&color=000000" alt="">
        @endif
        <b class="original-poster">{{$me->fullname}}</b>
        <i class="publish-date">{{$post->created_at}}</i>
    </div>
    <div class="content">
        <p>{{$post->description}}</p>
        @if($post->hasMedia())
        <div class="slideshow-container">
            <div class="slideshow">
                <div class="slides" postid="{{$post->id}}">

                    @foreach ($post->media as $media)
                    <div class="slide">
                        @if(in_array(pathinfo(strtolower($media->image), PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ asset($media->image) }}" alt="Image">
                        @elseif(in_array(pathinfo(strtolower($media->image), PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                        <video controls autoplay="false">
                            <source src="{{ asset($media->image) }}" type="video/{{ pathinfo($media->image, PATHINFO_EXTENSION) }}">
                        </video>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            <button class="prev">&#10095;</button>
            <button class="next">&#10094;</button>
        </div>
        @else
        <br>
        <br>
        <br>
        <br>
        <br>
        @endif
    </div>
    
    <b class="show-comments-button" onclick="PostsView.toggleCommentsSection(comments_{{$post->id}})">التعليقات</b>
    <div class="comment-section close" id="comments_{{$post->id}}">
        <div class="head">
            <div class="close-icon" onclick="PostsView.toggleCommentsSection(comments_{{$post->id}})"></div>
            <div class="input-block ">
                <button id="input_send_comment_{{$post->id}}" {{isset($no_comments) ? 'disabled' : ''}} onclick="PostsView.addComment('{{$post->id}}', input_comment_{{$post->id}})" class="button-image primary" style="height: 100%;flex-grow: 0;">
                    <img src="https://img.icons8.com/?size=100&id=368&format=png&color=000000" alt="">
                    <i>ارسال</i>
                </button>
                <input type="text" id="input_comment_{{$post->id}}" onchange="PostsView.checkForBadWords(this, input_send_comment_{{$post->id}})" {{isset($no_comments) ? 'readonly' : ''}}>
            </div>
        </div>
        <div class="body">
            @foreach ($post->comments as $comment)
            @php 
                $isCustomerViewer = $viewer !== ''; 
                ;
                if($isCustomerViewer)
                    $currentUser = $viewer;
                else
                    $currentUser = $me;
                $isCustomer = 'App\Models\Customer' === get_class($comment->owner);
                $userType = $isCustomer ? 'customer' : 'technicain';
                $owner = $comment->owner;
            @endphp
            <div class="comment-container">
                <div class="comment-head">
                    <img class="commenter-icon" src="{{($owner->profile == "Male.jpg" || $owner->profile == "Female.jpg") ? "/sources/img/$owner->profile" : "/cloud/$userType/$owner->id/images/$owner->profile"}}" alt="">
                    @if(($isCustomer == $isCustomerViewer || !$isCustomer == !$isCustomerViewer) && $owner->id == $currentUser->id)
                        <img onclick="location.href = '/{{$userType}}/post/deletecomment/{{$comment->id}}'" class="delete-icon" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAABe0lEQVR4nO2ZPU4DMRCFTY8ELRJcgYYO+pRQhNBs3nOSIjdANKBcAwqo4ABwAQTNjkMkOi6QG0D6IAeETLTZZIU3P2I+6TXe0diz8yxLtjGKoij/mldrNx15Ita2s+S/9drtDbPM9JJky5F9Rw6nqO9jzbIiZMcvVICWWLuXKaA1iiE7ZllxwKVf5NQ43xXgyiyCx1ptPSWbk7w/EvA0+tt5MV/7xNvrOS8mJZt+zuiFpNZWZ/B+VKXWVqMXMjRmLSV3HfnmNXEP/FHuO7+fy89pysIBPa9Vzf+DFrJKHRHgyJHXv+LJMwFOx3LcpORh0fxRyZso6xzJis87R5wWUhDtSIBaKyZqrQC1VkzUWgFqrZiotQLUWjFRawWotWKi1gpQa83RWjUBbsfGLhx5Ho4JeSfkcdH8UdF7rRlx2pGCCPnggHchK9EvscmKIz8ccG/K5sXaAyEHZT0lCDno1uv7Zh50G40dATDtQaewAEiSbM+lCEVRFLNIPgG2otTj2Va3HwAAAABJRU5ErkJggg==">
                    @endif   
                    <b class="commenter-name">{{$owner->fullname}}</b>
                    <i class="commenter-date">{{$comment->created_at}}</i>
                </div>
                <div class="comment-body">
                    {{$comment->comment}}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endforeach
@else
<h4 style="width:100%;text-align:center;color:gray">لا يوجد مناشير لعرضها</h4>
@endif