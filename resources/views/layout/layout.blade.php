<html>

<head>
    @include('layout.header')
    @yield('custom_css')
    @yield('title')
</head>

<body>
    @include('layout.navbar')
    <div class="container">
        @yield('content')
    </div>
    @include('layout.footer')
    @yield('custom_js')
</body>

</html>
