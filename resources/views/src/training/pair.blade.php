@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/pairs.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
<div id="breadcrumb" aria-label="breadcrumb">
    <ol id="breadcrumb" class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('training.index') }}">Training</a></li>
      <li class="breadcrumb-item active" aria-current="page">Pairs</li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert dark-bg" role="alert">
        <h4 class="alert-heading">Pairs</h4>
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

            <label for="field" class="form-label vertical-spacer">Wie groß soll das Feld sein? </label>
            <div id="field">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fieldSize" data-col="4" data-row="3" id="radio43" value="4x3">
                <label class="form-check-label" for="radio3x4">4 x 3</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fieldSize" data-col="4" data-row="4" id="radio44" value="4x4">
                <label class="form-check-label" for="radio4x4">4 x 4</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fieldSize" data-col="5" data-row="4" id="radio54" value="5x4">
                <label class="form-check-label" for="radio5x4">5 x 4</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fieldSize" data-col="6" data-row="4" id="radio64" value="6x4">
                <label class="form-check-label" for="radio6x4">6 x 4</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="fieldSize" data-col="7" data-row="4" id="radio74" value="7x4">
                <label class="form-check-label" for="radio7x4">7 x 4</label>
              </div>
            </div>
            <div class="row vertical-spacer">
              <div class="col">
                <button id="btnApplyPairsFilter" class="btn btn-turkis">anwenden</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL START -->
    <div id="overlay">
      <div id="overlay-container">
        <div id="close">X</div>
        <div class="alert bg-turkis">
          <div id="card-content">
            <div class="card-body">
              <h5 class="card-title">Zeiten</h5>
              <p class="card-text" id="pairsTime">Benötigte Zeit: <span></span></p>
              <p class="card-text" id="pairsHighscore">Highscore: <span>$highscore</span></p>
              <p class="card-text" id="outputPairsErrors">Fehler: <span></span></p>
              <hr>
              <button class="btn btn-turkis">OK</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL END -->

    <div id="contTblPairs" class="container table-responsive">
      <div class="table-responsive alert turkis-bg align-center">
        <table id="tblPairs" class="table">

        </table>
      </div>
    </div>
<!--     <div class="container">
      <button id="pairsReplay" class="btn btn-turkis">noch einmal</button>
    </div> -->
  </main>
@endsection
@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
  <script src="{{ asset('js/classes/Pair.js') }}"></script>
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
    //['Freund', 'Vater', 'Mutter', 'Onkel', 'Tante', 'Tochter', 'Sohn', 'Frage', 'ich lebe', 'Hallo', 'auf Wiedersehen', 'Großmutter']
    //['el amigo', 'el padre', 'la madre', 'el tio', 'la tia', 'la hija', 'el hijo', 'la pregunta', 'vivo', 'Hola', 'adios', 'la abuela']
    const german = ['Freund', 'Vater', 'Mutter', 'Onkel', 'Tante', 'Tochter', 'Sohn', 'Frage'];
    const spain = ['el amigo', 'el padre', 'la madre', 'el tio', 'la tia', 'la hija', 'el hijo', 'la pregunta'];
    let mixedWords = [];
    const germanLen = german.length;
    const spainLen = spain.length;
    const mixedLen = germanLen + spainLen;
    const table = document.querySelector('#tblPairs');
    const btnPairsApply = document.querySelector('#btnApplyPairsFilter');
    const filterSettings = document.querySelector('#collapseSelection');
    const radioField = document.querySelectorAll('#field .form-check-input');
    let indexCount = 0;
    let countColumns = 0;
    let checkedRadio;

    radioField.forEach(function(value, index) {
      value.onclick = function(e) {
        checkedRadio = e.target;
      };
    });

    btnPairsApply.onclick = function() {
      countColumns = checkedRadio.getAttribute('data-col');
      filterSettings.style.display = 'none';
      // für die Anzeige --> Vokabel aus beiden Tabellen werden in ein gemeinsames Array gespeichert
      german.forEach(function(value, index) {
        mixedWords[index] = value;
        indexCount++;
      });

      spain.forEach(function(value, index) {
        mixedWords[indexCount] = value;
        indexCount++;
      });

      let shuffledMixedWords = _.shuffle(mixedWords);

      let tr;
      let td;
/*       let btnReplay = document.querySelector('#pairsReplay');

      btnReplay.onclick = function(e) {
        window.location.href = "pairs.php";
      }; */

      shuffledMixedWords.forEach(function(value, index) {
        if (index % countColumns === 0) {
          tr = document.createElement('tr');
          table.appendChild(tr);
        }
        tr.insertAdjacentHTML('beforeend', '<td id="td_' + index + '" class="td-pairs">' + value + '</td>');

      });

      let counterHide = 0;
      let idxCards = 0;
      let cards = [];
      let cardElements = [];
      let pairsModal = new Modal(document.querySelector('#overlay'));
      const tds = document.querySelectorAll('.td-pairs');
      const closeCont = document.querySelector('#overlay-container');
      let outputTime = document.querySelector('#pairsTime span');
      let outputErrors = document.querySelector('#outputPairsErrors span');
      const btnOK = document.querySelector('#overlay button');
      let pairsCounter = 0;
      let errorCount = 0;

      btnOK.onclick = function(){
        pairsModal.closeModal();
        window.location.href = './pairs.php';
      }

      closeCont.onclick = function(e) {
        if (e.target.id == 'overlay-container' || e.target.id == 'close') {
          pairsModal.closeModal();
          window.location.href = './pairs.php';
        }
      };

      let interval;
      tds.forEach(function(value, index) {
        value.onclick = function(e) {
          if (pairsCounter == 0) {
            interval = setInterval(function() {
              pairsCounter++;
            }, 1000);
          }
          e.target.classList.add('card-turkis');
          if (idxCards <= 1) {
            cards[idxCards] = e.target.innerHTML;
            cardElements[idxCards] = e.target;
            if (idxCards == 1) {
              let pair = new Pair(cards[0], cards[1]);
              let isPair = pair.compareCards(german, spain);

              if (isPair == true) {
                cardElements.forEach(function(value, index) {
                  value.classList.add('hide-card');
                  counterHide++;
                  if (counterHide == mixedLen) {
                    console.log('alles aufgedeckt');
                    clearInterval(interval);
                    outputTime.innerHTML = '<strong>' + pairsCounter + '</strong> Sekunden';
                    outputErrors.innerHTML = '<strong>' + errorCount + '</strong>';
                    setTimeout(function() {
                      pairsModal.openModal();
                    }, 1300);
                  }
                });
              } else{
                errorCount++;
              }

              idxCards = -1;
              cardElements.forEach(function(value, index) {
                if (cards.length == 2 && value.classList.contains('card-turkis')) {
                  cardElements.forEach(function(value, index) {
                    setTimeout(function() {
                      value.classList.remove('card-turkis');
                    }, 350);
                  });
                }
              });
            }
          }
          idxCards++;
        }

      });


    };
  </script>
  @endsection
