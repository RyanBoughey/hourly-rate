<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>

<body class="scrollbar-lg">
    <div class="header">
        <p style="padding: 1.5rem; color: white; font-size: 18px;">@yield('title')</p>
    </div>
    <div class="main">
        @yield('content')
    </div>
</body>
</html>
