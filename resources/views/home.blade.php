@extends('layouts.app')

@section('title')
<title>AnimeProject - Home</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">  
@endsection

@section('script')
<script src="{{ asset('js/home.js') }}" defer></script>
@endsection

@section('content')

<main class="container">
  <div class="form-search-wrapper">
    <form id="form-anime-search" autocomplete="off">
      <input type="text" id="anime-input" placeholder="Search for an anime...">
      <input type="submit" value="GO">
    </form>
  </div>
  <div class="anime-container">
  </div>
  <div class="favourites-wrapper">
    <h1>My Favourites anime:</h1>
    <div class="favourites"></div>
  </div>
</main>

@endsection