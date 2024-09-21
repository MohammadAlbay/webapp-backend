<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/calendar.css">
</head>

<body>
    @include("main.md-dash-nav-barmenu")
    <div class="md-container" style="overflow-y: auto;">
        @include("main.homepage")
    </div>
    <script src="/js/index.js"></script>
    <script>
        document.getElementById('view_posts').addEventListener('click', e => {
            e.stopPropagation();
            alert('ff');
        });
    </script>
</body>

</html>