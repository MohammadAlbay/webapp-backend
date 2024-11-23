@php 
$isLoggedIn = $loginInformation['userType'] ?? false;
$userType = $loginInformation['userType'] ?? '#';
$user = $isLoggedIn ? $loginInformation['user'] : null;
@endphp

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فني لعندك</title>
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/homepage/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
 <!-- ************************************Navbar***************************************** -->

 <!-- Include Header -->
 @include('partials.header')

    <!-- *********************************Main Section********************************* -->
    <section class="hero">
        <div class="hero-text">
            <h1>ماهو فني لعندك</h1>
            <p>هي منصة تعمل كوسيط بين أصحاب المنازل الذين يبحثون عن خدمات منزلية متنوعة مثل الصيانة، التنظيف، والإصلاحات المنزلية. ومن المبنيين المتخصصين في هذه المجالات.</p>
            <a href="#" class="btn">استكشفنا</a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('rahma-ui/assets/images/homepage/imageiwillchose') }}" alt="Logo">
        </div>
    </section>

   <!-- *************************Services Section ***************************************-->
   <section class="ui-elements-section">
    <div class="container">
        <img src="{{ asset('rahma-ui/assets/images/gear-wheel.png') }}" alt="Gear Design" class="gear-image left-image">
        
        <h2>خدماتنا</h2>
        <div class="grid-container">
            @foreach ($services->take(4) as $service)
                <div class="grid-item">
                    <img src="{{ asset('sources/specializations/' . $service->image) }}" alt="{{ $service->name }}" class="service-image">
                    <h3>{{ $service->name }}</h3>
                </div>
            @endforeach
        </div>

        <div class="button-container">
            <a href="{{ route('specializations.index') }}" class="see-all-button">See All</a>
        </div>
        
        <img src="{{ asset('rahma-ui/assets/images/gear-wheel.png') }}" alt="Gear Design" class="gear-image right-image">
    </div>
</section>
<!--******************************************** About What We Do Section************************************ -->
<section class="about">
    <h2>نبذة عن عملنا</h2>
    <div class="about-content">
        <div class="about-image">
            <!--here i will add image but i still dont know which image so i left it like this -->
            <img src="{{ asset('rahma-ui/assets/images/homepage/image_i will_chose_later') }}" alt="Logo">
        </div>
        <div class="about-text">
            <h3>منصة فني لعندك</h3>
            <p>
                هي منصة تعمل كوسيط بين أصحاب المنازل الذين يبحثون عن خدمات منزلية متنوعة مثل الصيانة، التنظيف، والإصلاحات المنزلية. ومن الفنيين المتخصصين في هذه المجالات.
            </p>
           
        </div>
    </div>
</section>
<!--************************************something i want to add**************************************-->

<section class="flexible-work-section">
    <div class="container">
        <h2>عمل مرن، في متناول يدك</h2>
        <p class="intro-text">اعثر على وظائف محلية تناسب مهاراتك وجدولك الزمني. مع فني لعندك لديك الحرية والدعم لتكون رئيس نفسك.</p>
        
        <div class="flex-container">
            <div class="flex-item">
                <img src="{{ asset('rahma-ui/assets/images/online-payment.png') }}"  alt="Be your own boss">
                <h3>كن رئيس نفسك بنفسك</h3>
                <p>اعمل كيف ومتى وأينما تريد. اعرض خدماتك وحدد جدولاً زمنياً مرناو حدد منطقتك .</p>
            </div>
            <div class="flex-item">
                <img src="{{ asset('rahma-ui/assets/images/teamwork.png') }}"  alt="Set your own rates">
                <h3>جمهور أكبر </h3>
                <p>مع منصة فني لعندك تمتع بقاعدة جمهو أكبر و أوسع </p>
            </div>
            <div class="flex-item">
                <img src="{{ asset('rahma-ui/assets/images/growth.png') }}"alt="Grow your business">
                <h3>تنمية أعمالك</h3>
                <p>نحن نوصلك بالعملاء في منطقتك وطرق تسويق نفسك - حتى تتمكن من التركيز على ما تبرع فيه.</p>
            </div>
        </div>
    </div>
</section>



<!-- ***********************************************راي العملاء-->

<!--i made it not dynamic-->
<section class="testimonials">
    <h2>رأي العملاء</h2>
    <div class="carousel">
        <div class="testimonial-card">
            <i class="fas fa-quote-left quote-icon"></i>
            <p>منصة جميلة ساعدتني في ايجاد فني ذو خبرة بكل سهولةوتوفير الوقت و الجهد </p>
            <hr>
            <div class="user-info">
                <img src="{{ asset('rahma-ui/assets/images/boy.png') }}" alt="Logo">
                <div>
                    <h4>علي أحمد  </h4>
                    <p>طرابلس - جنزور</p>
                </div>
            </div>
        </div>
        <div class="testimonial-card">
            <i class="fas fa-quote-left quote-icon"></i>
            <p>منصة رائعه قامت بحل مشكلة كنا نعاني منها فا ايجاد فني متاح وذو خبرة يحتاج الكثير من الوقا و الجهد</p>
            <hr>
            <div class="user-info">
                <img src="{{ asset('rahma-ui/assets/images/boy.png') }}" alt="Logo">
                <div>
                    <h4>محمد علي </h4>
                    <p>طرابلس -سوق الجمعة</p>
                </div>
            </div>
        </div>
        <div class="testimonial-card">
            <i class="fas fa-quote-left quote-icon"></i>
            <p>عمل منصة تعمل علي حل مشاكل وتسهيل حياة الناس عمل رائع شكرا منصة فني لعندك علي تسهيل حياتنا</p>
            <hr>
            <div class="user-info">
                <img src="{{ asset('rahma-ui/assets/images/boy.png') }}" alt="Logo">
                <div>
                    <h4>أحمد فتحي</h4>
                    <p>بنغازي-شارع فينيسيا</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- ******************************************************Footer Section********************* -->
    <!-- Include Footer -->
    @include('partials.footer')

</body>
</html>
