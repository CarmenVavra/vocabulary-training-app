@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/hangman.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
@endsection
@section('content')


  <div id="breadcrumb" aria-label="breadcrumb">
    <ol id="breadcrumb" class="breadcrumb">
      <li class="breadcrumb-item"><a href="./../welcome.php">Home</a></li>
      <li class="breadcrumb-item"><a href="./trainingHome.php">Training</a></li>
      <li class="breadcrumb-item active" aria-current="page">Hangman</li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert dark-bg" role="alert">
        <h4 class="alert-heading">Hangman</h4>
        <p>
          <button id="btnFilter" class="btn btn-outline-secondary btn-sm vertical-spacer" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Filter
          </button>
        </p>
        <div class="collapse" id="collapseSelection">
          <div class="card card-body bg-transparent border-transparent">

          <div class="row">
              <div class="col-md-6">
                <label for="vocRange" class="form-label">Welche Vokabel?</label>
                <input type="text" name="daterange" value="" id="vocRange" />
              </div>
            </div>

            <div class="row-marker">
              <div class="btn-group" role="group">
                <button type="button" class="btn btn-danger btn-lg"></button>
                <button type="button" class="btn btn-warning btn-lg"></button>
                <button type="button" class="btn btn-success btn-lg"></button>
              </div>
              <button type="button" class="btn btn-light btn-lg btn-all">ALLE</button>
            </div>

            <div class="row vertical-spacer">
              <div class="col">
                <h6>Welche Reihenfolge?</h6>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection1" value="dir1">
                  <label class="form-check-label" for="radioDirection1">
                    Deutsch --> {{ session('foreign_name') }}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection2" value="dir2">
                  <label class="form-check-label" for="radioDirection2">
                  {{ session('foreign_name') }} --> Deutsch
                  </label>
                </div>
              </div>
              <div class="col">
                <button id="btnApplyHangmanFilter" class="btn btn-turkis">anwenden</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL START -->
    <div id="overlay-hangman">
      <div id="overlay-hangman-container">
        <div id="close">X</div>
        <div class="alert bg-turkis">
        <div id="card-content">
            <div class="card-body">
              <h5 class="card-title"></h5>
              <p class="card-text" id="hangmanUser">$user: <span></span></p>
              <p class="card-text" id="hangmanComp">Computer: <span></span></p>
              <hr>
              <button class="btn btn-turkis">OK</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL END -->
    <div id="contHangman" class="container">
      <div class="hangman-container">
        <canvas id="hangman" width="300" height="400"></canvas>
        <div id="keyboard">
          <div class="jumbotron dark-bg">
            <h1 class="display-4">
              <div id="output"></div>
            </h1>
            <p class="lead">
            <div id="row1" class="keyboard-row"></div>
            <div id="row2" class="keyboard-row"></div>
            <div id="row3" class="keyboard-row"></div>
            </p>
            <hr class="my-4">
            <p class="lead">
            <div class="btn-group">
              <button id="newGame" class="btn btn-turkis">Neues Wort</button>
              <button class="btn btn-warning btn-hint">?</button>
            </div>
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>
  @endsection
  @section('javascript')


    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script src="{{ asset('js/classes/Canvas.js') }}"></script>
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

    let canvas = new Canvas(document.querySelector('#hangman'));
    const output = document.querySelector('#output');

    let origString = "Hallihallo";
    let searchString = origString.toLowerCase();
    let lenSearchString = searchString.length;
    let inputLetters = [];
    let outputArray = [];
    let errors = [];


    let searchStringArray = searchString.split("");
    const keyboardRow1 = ['q', 'w', 'e', 'r', 't', 'z', 'u', 'i', 'o', 'p', 'ü'];
    const keyboardRow2 = ['a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'ö', 'ä'];
    const keyboardRow3 = ['y', 'x', 'c', 'v', 'b', 'n', 'm'];
    const outputKBRow1 = document.querySelector('#row1');
    const outputKBRow2 = document.querySelector('#row2');
    const outputKBRow3 = document.querySelector('#row3');
    const outputKBRows = document.querySelectorAll('.keyboard-row');
    let row1Keys = '';
    let row2Keys = '';
    let row3Keys = '';
    keyboardRow1.forEach(function(value) {
      row1Keys += '<button class="btn-turkis btn-keyboard">' + value + '</button>';
    });
    outputKBRow1.insertAdjacentHTML('beforeend', row1Keys);

    keyboardRow2.forEach(function(value) {
      row2Keys += '<button class="btn-turkis btn-keyboard">' + value + '</button>';
    });
    outputKBRow2.insertAdjacentHTML('beforeend', row2Keys);

    keyboardRow3.forEach(function(value) {
      row3Keys += '<button class="btn-turkis btn-keyboard">' + value + '</button>';
    });
    outputKBRow3.insertAdjacentHTML('beforeend', row3Keys);

    for (let i = 0; i < lenSearchString; i++) {
      outputArray[i] = ' __ ';
    }
    output.innerHTML = outputArray.join("");

    let i = 0;
    let x = 0;
    let hangModal = new Modal(document.querySelector('#overlay-hangman'));
    const closeCont = document.querySelector('#overlay-hangman-container');
    let outputCardTitle = document.querySelector('#overlay-hangman .card-title');
    let outputUserCount = document.querySelector('#hangmanUser span');
    let outputCompCount = document.querySelector('#hangmanComp span');
    let btnOK = document.querySelector('#overlay-hangman button');
    let user = 0;
    let computer = 0;


    outputKBRows.forEach(function(el) {

      el.onclick = function(e) {
        e.target.setAttribute('disabled', "");

        let contains = searchString.indexOf(e.target.textContent);
        if (contains === -1) {
          console.log('Der Buchstabe ist nicht enthalten');
          errors[i] = 1;
          switch (errors.length) {
            case 1:
              canvas.drawBaseTriangle();
              break;
            case 2:
              canvas.drawPoleLine();
              break;
            case 3:
              canvas.drawLatteLine();
              break;
            case 4:
              canvas.drawSlopeLine();
              break;
            case 5:
              canvas.drawRopeLine();
              break;
            case 6:
              canvas.drawHeadCircle();
              break;
            case 7:
              canvas.drawBodyLine();
              break;
            case 8:
              canvas.drawRightArmLine();
              break;
            case 9:
              canvas.drawLeftArmLine();
              break;
            case 10:
              canvas.drawRightLegLine();
              break;
            case 11:
              canvas.drawLeftLegLine();
              computer++;
              outputCardTitle.innerHTML = 'Du hast verloren! Das gesuchte Wort lautet: ' + origString;
              outputUserCount.innerHTML = user;
              outputCompCount.innerHTML = computer;
              hangModal.openModal();
              break;
            default:
              return;
          }
          i++;
        } else {
          let letter = searchString.charAt(contains);

          searchStringArray.forEach(function(value, index) {
            if (value == e.target.textContent) {
              outputArray[index] = value;
              searchStringArray[index] = "";
              searchString = searchStringArray.join("");
              output.innerHTML = outputArray.join("").toUpperCase();
              if (searchString == '') {
                user++;
                outputCardTitle.innerHTML = 'Gratulation!! Du hast gewonnen!';
                outputUserCount.innerHTML = user;
                outputCompCount.innerHTML = computer;
                hangModal.openModal();
              }
            }
          });
        }

        if (errors.length != 0) {
          console.log('Fehler: ', errors);
        }
      }
    });

    btnOK.onclick = function(){
        hangModal.closeModal();
        window.location.href = './hangman.php';
    };

    closeCont.onclick = function(e) {
      if (e.target.id == 'overlay-hangman-container' || e.target.id == 'close') {
        window.location.href = './hangman.php';
        hangModal.closeModal();
      }
    };
  </script>
  @endsection
