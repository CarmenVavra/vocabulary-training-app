@extends('layouts.main')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pairs.css') }}">
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
        @if(isset($countDataRows) && $countDataRows < 6)
          <div class="alert alert-danger">{{ 'Es sind zu wenige Vokabel vorhanden, um Pairs zu spielen. Leg noch ein paar Vokabeln an!' }}</div>
        @endif
        @if(isset($countDataRows) && $countDataRows >=6)
        <p>
          <button id="btnFilter" class="btn btn-outline-secondary btn-sm vertical-spacer" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Filter
          </button>
        </p>
        <div class="collapse" id="collapseSelection">
          <div class="card card-body bg-transparent border-transparent">
            <form action="{{ route('pair.filter.select') }}" method="post">
              @csrf
            <div class="row">
              <div class="col-md-6">
                <label for="vocRange" class="form-label">Welche Vokabel?</label>
                <input type="text" name="daterange" value="" id="vocRange" />
              </div>
            </div>


            <div class="row-marker" id="rowMarker">
              <label for="difficultyLevel" class="form-label">Welcher Schwierigkeitsgrad? </label>
              <div id="difficultyLevel" class="btn-group" role="group">

                <label for="diffRed" class="btn-difficulty-danger btn-lg">
                  <input name="diffRed" id="diffRed" type="checkbox" value="1">
                </label>
                <label for="diffYellow" class="btn-difficulty-warning btn-lg">
                  <input name="diffYellow" id="diffYellow" type="checkbox" value="2">
                </label>
                <label for="diffGreen" class="btn-difficulty-success btn-lg">
                  <input name="diffGreen" id="diffGreen" type="checkbox" value="3">
                </label>
              </div>

              <button name="selectAll" id="selectAll" type="button" class="btn btn-light btn-lg btn-all">ALLE</button>
              <input type="hidden" name="hdSelectAll" id="hdSelectAll" value="">
            </div>


              <div id="fieldSizeContainer">
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
              </div>

            <div class="row vertical-spacer">
              <div class="col">
                <button type="submit" id="btnApplyPairsFilter" class="btn btn-turkis">anwenden</button>
              </div>
            </div>
            
          </form>
        </div>
      </div>
      @endif
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
    @if(isset($vocabularies))

    {{-- dd($vocabularies) --}}
      <div id="contTblPairs" class="container table-responsive">
        <div class="table-responsive alert turkis-bg align-center">
          <table id="tblPairs" class="table">

          </table>
        </div>
      </div>
    @endif
  </main>
@endsection
@section('javascript')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="{{ asset('js/classes/Pair.js') }}"></script>

  <script>
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        format: 'DD.MM.YYYY',
        opens: 'left'
      }, function(start, end, label) {
        //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        start = start.format('YYYY-MM-DD');
        end = end.format('YYYY-MM-DD');

        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
      
        $("#vocRange").on('change', function(e){      
            e.preventDefault();
            $.ajax({
              type:'GET',
              url:"{{ route('pair.check.date') }}",
              data:{start:start, end:end},
              success:function(data){
                if(data.dateDataRow < 6){
                  $('#rowMarker').hide();
                  $('#fieldSizeContainer').hide();                 
                  console.log('Für den ausgewählten Zeitraum gibt es zu wenig Datensätze .. min. 6', data.dateDataRow);
                }else{
                  $('#rowMarker').show();
                }
              }
            });
        });
        
        let dataCount = 0;

        $('#difficultyLevel input[type="checkbox"]').on('click', function(e){
          $('#hdSelectAll').val('');
          $(e.target).parent().toggleClass('active');
          $(e.target).toggleClass('active');
          if($(e.target).hasClass('active')){
            $.ajax({
              type:'GET',
              url:"{{ route('pair.check.difflevel') }}",
              data:{start:start, end:end, marker:$(e.target).val()},
              success:function(data){
                if(data.diffDataRow == 0){
                  $(e.target).parent().prop('disabled', true).removeClass('active');
                  $(e.target).prop('disabled', true).removeClass('active');
                  
                }else{
                  //console.log('diffDataRow active', data.diffDataRow);
                  dataCount += data.diffDataRow;
                  //console.log('datacount active ', dataCount);
                  if(dataCount >= 6){
                    
                    switch(dataCount){
                      case 6:
                      case 7: $('#radio43').parent().show();
                              $('#radio43').parent().siblings().hide();
                              break;
                      case 8: 
                      case 9: $('#radio44').parent().siblings().hide();
                              $('#radio44').parent().show();
                              $('#radio43').parent().show();
                              break;
                      case 10: 
                      case 11: $('#radio54').parent().siblings().hide();
                               $('#radio54').parent().show();
                               $('#radio44').parent().show();
                               $('#radio43').parent().show();
                               break;
                      case 12: 
                      case 13: $('#radio64').parent().siblings().show();
                               $('#radio64').parent().show();
                               $('#radio74').parent().shiblings().hide();
                               break;
                      default: $('#radio74').parent().siblings().show();
                               $('#radio74').parent().show();                     
                      
                    }

                    $('#fieldSizeContainer').show();
                  }

                }
              }
            });               
          }else{
            if($(e.target).parent().siblings().children().hasClass('active')){
              //console.log('value von den anderen', $(e.target).parent().siblings().children().val());
              $.ajax({
                type:'GET',
                url:"{{ route('pair.check.difflevel') }}",
                data:{start:start, end:end, marker:$(e.target).val()},
                success:function(data){
                  if(data.diffDataRow != 0){
                    //console.log('diffDataRow not active ', data.diffDataRow);
                    dataCount -= data.diffDataRow;
                    console.log('dataCount in not active', dataCount);
                    if(dataCount < 6){
                      $('#fieldSizeContainer').hide();
                    }

                    switch(dataCount){
                      case 6:
                      case 7: $('#radio43').parent().show();
                              $('#radio43').parent().siblings().hide();
                              break;
                      case 8: 
                      case 9: $('#radio44').parent().siblings().hide();
                              $('#radio44').parent().show();
                              $('#radio43').parent().show();
                              break;
                      case 10: 
                      case 11: $('#radio54').parent().siblings().hide();
                               $('#radio54').parent().show();
                               $('#radio44').parent().show();
                               $('#radio43').parent().show();
                               break;
                      case 12: 
                      case 13: $('#radio64').parent().siblings().show();
                               $('#radio64').parent().show();
                               $('#radio74').parent().shiblings().hide();
                               break;
                      default: $('#radio74').parent().siblings().show();
                               $('#radio74').parent().show();
                      
                      
                    }

                  }
                }
              }); 
            
            }else{
              dataCount = 0;

            }            
            
          }

        });

        $('#selectAll').on('click', function(e){
          e.preventDefault();
          $('#selectAll').siblings().children().removeClass('active').children().removeClass('active');
          $('#hdSelectAll').val('btnSelectAll');

          $.ajax({
            type:'GET',
            url:"{{ route('pair.select.all') }}",
            data:{start:start, end:end},
            success:function(data){
              console.log(data.vocabulariesCount);
              if(data.vocabulariesCount >= 6){
                switch(dataCount){
                      case 6:
                      case 7: $('#radio43').parent().show();
                              $('#radio43').parent().siblings().hide();
                              break;
                      case 8: 
                      case 9: $('#radio44').parent().siblings().hide();
                              $('#radio44').parent().show();
                              $('#radio43').parent().show();
                              break;
                      case 10: 
                      case 11: $('#radio54').parent().siblings().hide();
                               $('#radio54').parent().show();
                               $('#radio44').parent().show();
                               $('#radio43').parent().show();
                               break;
                      case 12: 
                      case 13: $('#radio64').parent().siblings().show();
                               $('#radio64').parent().show();
                               $('#radio74').parent().shiblings().hide();
                               break;
                      default: $('#radio74').parent().siblings().show();
                               $('#radio74').parent().show();                     
                      
                    }
                    $('#fieldSizeContainer').show();
              }
            }
          });    
          
          dataCount = 0;
        });




      });
    });
</script>
  <script type="text/javascript">
   
</script>

  <script>
    "use strict";

    <?php if(!empty($_POST)) { $countColumns = substr($_POST['fieldSize'], 0, 1); }?>

    let vocabularies = <?= ($jsonStringPHP) ?? ''; ?>;
    let language = [];
    let foreign = [];

    //vocabularies = JSON.parse();
    console.log(vocabularies.length);
    for(let i=0; i<vocabularies.length; i++){
      language.push(vocabularies[i].vn);
      foreign.push(vocabularies[i].fvn);
    }

    let mixedWords = [];
    const languageLen = language.length;
    const foreignLen = foreign.length;
    const mixedLen = languageLen + foreignLen;
    const table = document.querySelector('#tblPairs');
    const btnPairsApply = document.querySelector('#btnApplyPairsFilter');
    const filterSettings = document.querySelector('#collapseSelection');
    //const radioField = document.querySelectorAll('#field .form-check-input');
    let indexCount = 0;
    let countColumns = 0;
    let checkedRadio;

    let jsVariable = <?= ($jsVariable) ?? ''; ?>;
    if(jsVariable == 1){
    //btnPairsApply.onclick = function() {
      countColumns = <?= ($countColumns) ?? ''; ?>;
      console.log(countColumns);
      //filterSettings.style.display = 'none';
      // für die Anzeige --> Vokabel aus beiden Tabellen werden in ein gemeinsames Array gespeichert
      language.forEach(function(value, index) {
        mixedWords[index] = value;
        indexCount++;
      });

      foreign.forEach(function(value, index) {
        mixedWords[indexCount] = value;
        indexCount++;
      });

      let shuffledMixedWords = _.shuffle(mixedWords);

      let tr;
      let td;
      
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
        window.location.href = '/pair';
      }

      closeCont.onclick = function(e) {
        if (e.target.id == 'overlay-container' || e.target.id == 'close') {
          pairsModal.closeModal();
          window.location.href = '/pair';
        }
      };

      let interval;
      tds.forEach(function(value, index) {
        
        value.onclick = function(e) {
          console.log(e.target);
          if (pairsCounter == 0) {
            interval = setInterval(function() {
              pairsCounter++;
            }, 1000);
          }
          e.target.classList.add('card-turkis');
          console.log(e.target);
          if (idxCards <= 1) {
            cards[idxCards] = e.target.innerHTML;
            cardElements[idxCards] = e.target;
            if (idxCards == 1) {
              let pair = new Pair(cards[0], cards[1]);
              let isPair = pair.compareCards(language, foreign);

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
