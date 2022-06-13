<nav>
  <div class="logo"><a href="{{ route('home') }}">Anime Project</a></div>
  <div class="profile-container">
    <img src="{{ asset('images/profile-placeholder.png') }}" id="profile-img">
    <div class="triangle hidden"></div>
    <div class="menu hidden">
      <div class="username">@if (isset($username))
        {{ $username }}
      @endif</div>
      <ul>
        <li>
          <a href="{{ route('profile') }}"><img src="{{ asset('images/person.png') }}"> <span>My Profile</span></a>
        </li>
        <li>
          <a href="{{ route('logout') }}"><img src="{{ asset('images/logout.png') }}"> <span>Logout</span></a>
        </li>
      </ul>
    </div>
  </div>
</nav>