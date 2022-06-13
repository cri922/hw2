<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnimeProject - Login</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;900&display=swap" rel="stylesheet">
  <script>
    const BASE_URL = "{{ url('/') }}";
  </script>
  <script src="{{ asset('js/login.js') }}" defer></script>
</head>

<body>
  <main class="container">
    <div class="form-wrapper">
      <div class="title">Login</div>
      <form id="login-form" method="post" autocomplete="off">
        @csrf
        <div class="row">
          <input type="email" id="email-form" name="f-email" placeholder="Email..." value="{{ old('f-email') }}">
          <span>@if (!empty($errors['emailErr']))
            {{ $errors['emailErr'] }}
          @endif</span>
        </div>
        <div class="row">
          <input type="password" id="password-form" name="f-pass" placeholder="Password">
          <span>@if (!empty($errors['passErr']))
            {{ $errors['passErr'] }}
          @endif</span>
        </div>
        <div class="row button">
          <input type="submit" id="submit-form" value="Login now">
        </div>
      </form>
      <div class="signup-redirect">
        <span>Not a member? <a href="{{ route('signup_form') }}">Signup now!</a></span>
      </div>
    </div>
  </main>
</body>

</html>