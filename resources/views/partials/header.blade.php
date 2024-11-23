
<!--the header -->
<header>
    <nav>
        <h2 class="arabic-text">
            <span class="black-text">فني</span>
            <span class="green-text">لعندك</span>
        </h2>
        <!--i still dont know what i want to put in the heder -->
        <ul class="nav-links">
            <li><a href="/homepage">الصفحة الرئيسسية</a></li>
            <li><a href="/specializations">خدماتنا</a></li>
            <li><a href="#">منعرفش</a></li>
            <li><a href="#">منعرفش</a></li>
            <li><a href="#">شن متعرفيش</a></li>
        </ul>
        <div class="auth-buttons">
            <!--goes to another page -->
            <!--here we are going to signup and login page -->
            @if(isset($isLoggedIn))
            @if(!$isLoggedIn)
            <a href="/signup" class="signup-btn">إنشاء حساب</a>
            <a href="/login" class="login-btn">تسجيل دخول</a>
            @else
            <a href="{{$userType}}" class="login-btn"> 
                متابعة كـ 
                {{$user->fullname}}
            </a>
            @endif
            @else
            <a href="/signup" class="signup-btn">إنشاء حساب</a>
            <a href="/login" class="login-btn">تسجيل دخول</a>
            @endif
        </div>
    </nav>
</header>