@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
  <div id="breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('welcome.index')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('training.index') }}">Training</a></li>
      <li class="breadcrumb-item active" aria-current="page">Quiz</li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert dark-bg" role="alert">
        <h4 class="alert-heading">Quiz</h4>
        <p>
          <button id="btnFilter" class="btn btn-outline-secondary btn-sm vertical-spacer" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Filter
          </button>
        </p>
        <div class="collapse" id="collapseSelection">
          <div class="card card-body bg-transparent border-transparent">

            {{-- <label for="vocRange" class="form-label">Welche Vokabel? </label><small>Angabe in Wochen</small>
            <input type="range" value="0" min="1" max="200" oninput="this.nextElementSibling.value = this.value">
            <output>0</output> --}}

            <div class="row">
              <div class="col-md-6">
                <label for="vocRange" class="form-label">Welche Vokabel?</label>
                <input type="text" name="daterange" value="" id="vocRange" />
              </div>
            </div>

            <label for="questionRange" class="form-label">Wieviele Fragen?</label>
            <input type="range" value="0" min="1" max="200" oninput="this.nextElementSibling.value = this.value">
            <output>0</output>

            <div class="row-marker">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-danger btn-lg"></button>
                <button type="button" class="btn btn-warning btn-lg"></button>
                <button type="button" class="btn btn-success btn-lg"></button>
              </div>
              <button type="button"class="btn btn-light btn-lg btn-all">ALLE</button>
            </div>

            <div class="row vertical-spacer">
              <div class="col">
                <h6>Welche Reihenfolge?</h6>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioDirection" id="radioBoth" value="both" checked>
                  <label class="form-check-label" for="radioBoth">
                    beide
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection1" value="dir1">
                  <label class="form-check-label" for="radioDirection1">
                    Deutsch --> Spanisch
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection2" value="dir2">
                  <label class="form-check-label" for="radioDirection2">
                    Spanisch --> Deutsch
                  </label>
                </div>
              </div>
              <div class="col">
                <h6>Welche Sortierung?</h6>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioSortorder" id="radioRandom" value="random" checked>
                  <label class="form-check-label" for="radioRandom">
                    zufällig
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioSortorder" id="radioASC" value="asc">
                  <label class="form-check-label" for="radioASC">
                    aufsteigend
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioSortorder" id="radioDESC" value="desc">
                  <label class="form-check-label" for="radioDESC">
                    absteigend
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioSortorder" id="radioDate" value="date">
                  <label class="form-check-label" for="radioDate">
                    nach Datum sortiert
                  </label>
                </div>
              </div>
              <div class="col">
                <button id="btnApplyQuizFilter" class="btn btn-turkis">anwenden</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="outputQuiz" class="container"></div>
  </main>
  @endsection
  @section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
    <script src="{{ asset('js/classes/CardSet.js') }}"></script>
    <script src="{{ asset('js/logic_quiz.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function() {
          $('input[name="daterange"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
          });
        });
    </script>
  <script>
    "use strict";
    let limit = 12;
    let cardSet = new CardSet();
    let question = cardSet.getQuestion();
    let answer = cardSet.getAnswer();
    let fakeAnswers = cardSet.getFakeAnswers();
    const content = document.querySelector('#outputQuiz');
    let flexContainer;
    let outputQuestion;
    let outputAnswers;

    for (let i = 1; i <= limit; i++) {
      if(i % 4 === 1){
        content.insertAdjacentHTML('beforeend', '<div id="contId_'+i+'" class="card-flex-container">');
        flexContainer = document.querySelector('#contId_'+i);
      }

      flexContainer.insertAdjacentHTML('beforeend', '<div id="card_' + i + '" class="card bg-turkis" style="width: 18rem;"><div class="card-body">');
      outputQuestion = document.querySelector('#card_' + i + ' .card-body');
      outputQuestion.insertAdjacentHTML('beforeend', '<div class="card-title bg-darkgray">' + question + '</div><ul class="list-group list-group-flush">');
      outputAnswers = document.querySelector('#card_' + i + ' .card-body .list-group');

      fakeAnswers.forEach(function(value, index) {
        outputAnswers.insertAdjacentHTML('beforeend', '<li class="list-group-item">' + value + '</li>');
      });
    }

  </script>
  @endsection
