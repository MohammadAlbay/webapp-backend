<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $specialization->name }} - الفنيين</title>
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/specializations/viewTecnican.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

    <!-- Navbar -->
    @isset($me)
    @include('customer.header')
    @else
    @include('partials.header')
    @endisset

    <!-- Search Section -->
    <section class="search-section text-center">
        <h1>دور علي فني</h1>
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="البحث" onkeyup="searchTechnicians()">
            <button onclick="searchTechnicians()">بحث</button>
        </div>
    </section>

    <div class="container">
        <h3>الفنيين المتخصصين في {{ $specialization->name }}</h3>
        <div class="row">
            @if($technicians == null || $technicians->isEmpty())
                <p>لا توجد فنيين لهذا التخصص.</p>
            @else
                @foreach($technicians as $technician)
                    <div class="col-md-4">
                        <div class="card technician-card">
                            <img src="{{ asset('storage/' . $technician->profile) }}" alt="{{ $technician->fullname }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $technician->fullname }}</h5>
                                <p class="card-text">{{ $technician->description }}</p>
                                <p class="card-text">الهاتف: {{ $technician->phone }}</p>
                                <button type="button" class="btn btn-success">رؤية الملف</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Load More Button -->
    <div class="load-more text-center">
        <button>تحميل المزيد</button>
    </div>

  <!-- Image Section -->
<div class="footer-image">
    <img src="{{ asset('assets/images/tools 1.png') }}" alt="Footer Image" loading="lazy" ">
</div>

    <!-- Footer Section -->
    @include('partials.footer')

    <script>
        function searchTechnicians() {
            const query = document.getElementById('search-input').value.toLowerCase();
            const technicians = document.querySelectorAll('.technician-card');
    
            technicians.forEach(tech => {
                const fullname = tech.querySelector('.card-title').innerText.toLowerCase();
                const description = tech.querySelector('.card-text').innerText.toLowerCase();
    
                if (fullname.includes(query) || description.includes(query)) {
                    tech.style.display = 'block'; // Show matching technician
                } else {
                    tech.style.display = 'none'; // Hide non-matching technician
                }
            });
        }
    </script>

    <script src="scripts.js"></script>
</body>
</html>