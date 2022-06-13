<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AnimeProject - Signup</title>
  <link rel="stylesheet" href="{{ asset('css/signup.css') }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;900&display=swap" rel="stylesheet">
  <script>
    const BASE_URL = "{{ url('/') }}";
  </script>
  <script src="{{ asset('js/signup.js') }}" defer></script>
</head>
<body>
  <main class="container">
    <div class="form-wrapper">
      <div class="title">Signup <br> <span class="subtitle">It's free and easy!</span></div>
      <form name="signup" id="signup-form" method="post" autocomplete="off">
        @csrf
        <div class="row">
          <input type="text" id="name-form" name="f-fname" placeholder="First Name" value="{{ old('f-fname') }}">
          <span>@if (!empty($errors['firstNameErr']))
            {{ $errors['firstNameErr'] }}
          @endif</span>
        </div>
        <div class="row">
          <input type="text" id="surname-form" name="f-lname" placeholder="Last Name" value="{{ old('f-lname') }}">
          <span>@if (!empty($errors['lastNameErr']))
            {{ $errors['lastNameErr'] }}
          @endif</span>
        </div>
        <div class="row">
          <input type="text" id="username-form" name="f-nick" placeholder="Username" value="{{ old('f-nick') }}">
          <span>@if (!empty($errors['usernameErr']))
            {{ $errors['usernameErr'] }}
          @endif</span>
        </div>
        <div class="row">
          <input type="email" id="email-form" name="f-email" placeholder="Email" value="{{ old('f-email') }}">
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
        <div class="row">
          <input type="password" id="repassword-form" name="f-repass" placeholder="Confirm password">
          <span>@if (!empty($errors['repassErr']))
            {{ $errors['repassErr'] }}
          @endif</span>
        </div>
        <div class="row button">
          <input type="submit" id="submit-form" value="Signup now!">
        </div>
      </form>
      <div class="login-redirect">
        <span>Already have an account? <a href="{{ route('login_form') }}">Login now!</a></span>
      </div>
    </div>
  </main>
</body>
</html>