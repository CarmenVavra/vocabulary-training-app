@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/trainer.css') }}">
@endsection
@section('content')

  <div id="breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Vokabeltrainer</li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="row card-group">
        <div class="card col-md dark-bg">
          <img src="{{ asset('img/figur_buch.jpg') }}" class="card-img-top" alt="Lerninhalt">
          <div class="card-body">
            <h5 class="card-title">Lernen</h5>
            <p class="card-text">Hier geht es zum Lernen</p>
            <a href="{{ route('learning.index') }}" class="btn btn-turkis">zum Lernen</a>
          </div>
        </div>
        <div class="card col-md turkis-bg">
          <img src="{{ asset('img/birne_gehirn.jpg') }}" class="card-img-top" alt="quiz">
          <div class="card-body">
            <h5 class="card-title">Quiz</h5>
            <p class="card-text">Hier geht es zum Quiz</p>
            <a href="{{ route('quiz.index') }}" class="btn btn-darkgray">zum Quiz</a>
          </div>
        </div>
        <div class="card col-md dark-bg">
          <img src="{{ asset('img/hangman.jpg') }}" class="card-img-top" alt="hangman">
          <div class="card-body">
            <h5 class="card-title">Hangman</h5>
            <p class="card-text">Hier geht es zum Spiel</p>
            <a href="{{ route('hangman.index') }}" class="btn btn-turkis">zu Hangman</a>
          </div>
        </div>
        <div class="card col-md turkis-bg">
          <img src="{{ asset('img/spain_austria_flagge.png') }}" class="card-img-top" alt="pairs">
          <div class="card-body">
            <h5 class="card-title">Pairs</h5>
            <p class="card-text">Hier geht es zum Spiel Pairs</p>
            <a href="{{ route('pair.index') }}" class="btn btn-darkgray">zu Pairs</a>
          </div>
        </div>
      </div>
    </div>

  </main>

@endsection
