@extends('layouts.app')

@section('title')
<title>AnimeProject - Profile</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">  
@endsection

@section('script')
<script src="{{ asset('js/profile.js') }}" defer></script>
@endsection

@section('content')

<main>
  <div class="content-wrapper">
    <div class="image-wrapper">
      <img src="images/profile-placeholder.png">
    </div>
    <div class="info-wrapper">
      <div class="row">
        <span>First name:</span>
        <span class="pleft">@if (isset($user['firstName']))
          {{ $user['firstName'] }}
        @endif</span>
      </div>
      <div class="row">
        <span>Last name:</span>
        <span class="pleft">@if (isset($user['lastName']))
          {{ $user['lastName'] }}
        @endif</span>
      </div>
      <div class="row">
        <span>Username:</span>
        <span class="pleft">@if (isset($user['username']))
          {{ $user['username'] }}
        @endif</span>
      </div>
      <div class="row">
        <span>Email:</span>
        <span class="pleft">@if (isset($user['email']))
          {{ $user['email'] }}
        @endif</span>
      </div>
    </div>
    <div class="delete-wrapper">
      <span>Do you want to delete your account?</span>
      <img src="images/trash.png">
    </div>
  </div>
  <section id="modal-view" class="hidden">
    <div class="confirmdel-wrapper">
      <span>Are you sure to delete your account?</span>
      <div class="buttons-wrapper">
        <button><a href="{{ route('delete') }}">Yes</a></button>
        <button data-ans="no">No</button>
      </div>
    </div>
  </section>
</main>

@endsection