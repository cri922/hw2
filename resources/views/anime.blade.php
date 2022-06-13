@extends('layouts.app')

@section('title')
<title>{{ $result['data']['title'] }}</title>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('css/anime.css') }}">  
@endsection

@section('script')
<script>
  const CSRF_TOKEN = "{{ csrf_token() }}";
</script>
<script src="{{ asset('js/anime.js') }}" defer></script>
@endsection

@section('content')

<main class="container">
  <section class="first">
    <div class="cover-wrapper">
      <img src="{{ $result['data']['images']['jpg']['image_url'] }}">
    </div>
    <div class="description-wrapper">
      <h1 data-id="{{ $result['data']['mal_id'] }}">{{ $result['data']['title'] }}</h1>
      <div class="row">
        Studio: &nbsp; <span>{{ $result['data']['studios'][0]['name'] }}</span>
      </div>
      <div class="row">
        Stato: &nbsp; <span>{{ $result['data']['status'] }}</span>
      </div>
      <div class="row">
        Data di uscita: &nbsp; <span>{{ $data }}</span>
      </div>
      <div class="row">
        Episodi: &nbsp; <span>{{ $result['data']['episodes'] }}</span>
      </div>
      <div class="row">
        Durata episodi: &nbsp; <span>{{ $result['data']['duration'] }}</span>
      </div>
      <div class="row bottom">
        <img src="{{ asset('images/star.png') }}"> &nbsp; <span class="number">{{ $likes }}</span>
      </div>
    </div>
  </section>
  <section class="second">
    <div class="links">
      <button class="myanimelist"><a href="{{ $result['data']['url'] }}" target="_blank">MyAnimeList</a></button>
      <button class="youtube"><a href="{{ $result['data']['trailer']['url'] }}" target="_blank">Trailer anime</a></button>
    </div>
    <div class="synopsis">
      <h3>Trama:</h3>
      <p>{{ $result['data']['synopsis'] }}</p>
    </div>
  </section>
  <section class="third">
    <div class="genres">
      <ul>
        @foreach ($result['data']['genres'] as $item)
            <li>{{ $item['name'] }}</li>
        @endforeach
        @foreach ($result['data']['demographics'] as $item)
            <li>{{ $item['name'] }}</li>
        @endforeach
      </ul>
    </div>
    <div class="comments-wrapper">
      <h3>Commenti:</h3>
      <div class="comment-form-wrapper">
        <form id="form-comment">
          <textarea name="comment" id="comment-textarea" cols="60" rows="5" placeholder="Add your comment here..."></textarea>
          <input type="submit" value="Post Comment">
        </form>
      </div>
      <div class="comments-content-wrapper">
      </div>
    </div>
  </section>
</main>

@endsection