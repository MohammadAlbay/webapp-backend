<div class="md-navbar">
    <div class="md-navbar-container">
        <h1 class="title">الصفحة الرئيسية</h1>
        <h1 class="title">
            <span onclick="location.href='/technicain/';" style="cursor:pointer;">الصفحة الرئيسية</span>
            @if($location !== "")
                &#11164;
                {{$location}}
            @endif
        </h1>
        @isset($viewer)
            @if($viewer !== "")
            <button onclick="location.href='/customer/';" class="nav-toggle-icon close"></button>
            @else
            <button class="nav-toggle-icon close"></button>
            @endif
        @else
        <button class="nav-toggle-icon close"></button>
        @endisset
        
    </div>
</div>