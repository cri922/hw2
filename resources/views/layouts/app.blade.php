<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @yield('title')
  @yield('style')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;900&display=swap" rel="stylesheet">
  <script>
    const BASE_URL = "{{ url('/') }}";
  </script>
  @yield('script')
</head>

<body>
  <header>
    @include('layouts.header')
  </header>

  @yield('content')

  <footer>
    @include('layouts.footer')
  </footer>
</body>

</html>