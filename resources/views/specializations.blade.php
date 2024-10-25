<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>فني لعندك</title>
    @isset($me)
    <link rel="stylesheet" href="/sources/customer/css/search-view.css">
    @endisset
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('rahma-ui/assets/css/specializations/homepage.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .icon-min {
            width: 24px;
            height: 24px;
        }

        .title {
            margin: 1em;
            text-align: right;
        }
    </style>
</head>

<body>
    @isset($me)
    @include('customer.header')
    @else
    @include('partials.header')
    @endisset


    <div class="search-container">
        <input type="text" id="search" placeholder="بحث..." />
        <button id="searchButton" class="btn btn-primary">بحث</button>
    </div>

    <div class="cards" id="cardsContainer">
        @foreach($specializations as $specialization)
        <a href="{{ route('specializations.technicians', $specialization->id) }}" class="card">
            @if($specialization->image)
            <img src="/sources/specializations/{{$specialization->image}}" alt="{{ $specialization->name }}">
            @else
            <img src="https://via.placeholder.com/150" alt="Placeholder">
            @endif
            <h3>{{ $specialization->name }}</h3>
        </a>
        @endforeach
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @if ($specializations->onFirstPage())
            <li class="page-item disabled">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $specializations->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @endif

            @for ($i = 1; $i <= $specializations->lastPage(); $i++)
                <li class="page-item {{ $i == $specializations->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $specializations->url($i) }}">{{ $i }}</a>
                </li>
                @endfor

                @if ($specializations->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $specializations->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
                @endif
        </ul>
    </nav>

    @include('partials.footer')

    <script>
        const searchInput = document.getElementById('search');
        const searchButton = document.getElementById('searchButton');

        // Function to filter cards
        const filterCards = () => {
            const query = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                card.style.display = title.includes(query) ? 'block' : 'none';
            });
        };

        // Event listeners
        searchInput.addEventListener('input', filterCards);
        searchButton.addEventListener('click', filterCards);
    </script>


    @isset($me)
        @include('customer.search-view')
        <script src="/sources/employee/js/index.js"></script>
        <script src="/sources/customer/js/index.js"></script>
        <script>
            Homepage.prepare(document.querySelector('div.search-view'));
        </script>
    @endisset
</body>

</html>