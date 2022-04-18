@extends('layouts.main')
@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pairs.css') }}">
    <link rel="stylesheet" href="{{ asset('css/daterange.css') }}">
@endsection
@section('content')
<div id="breadcrumb" aria-label="breadcrumb">
    <ol id="breadcrumb" class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('vocabulary.index') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('training.index') }}">Training</a></li>
      <li class="breadcrumb-item active" aria-current="page"><strong>Pairs</strong></li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert dark-bg" role="alert">
        <h4 class="alert-heading">Pairs</h4>
        @if(isset($countDataRows) && $countDataRows < 6)
          <div class="alert alert-danger">{!! 'Es sind zu wenige Vokabeln vorhanden, um <strong>Pairs</strong> zu spielen. Leg noch ein paar <a href="/vocabulary" >Vokabeln</a> an!' !!}</div>
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
                <input type="text" name="daterange" value="{{ old('daterange') }}" id="vocRange" />
              </div>
            </div>

            <div class="row-marker vertical-spacer" id="rowMarker">
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
                  <div class="row vertical-spacer">
                    <div class="col">
                      <button type="submit" id="btnApplyPairsFilter" class="btn btn-turkis">anwenden</button>
                    </div>
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
          <div class="card-header bg-darkgray">
            AUSWERTUNG
          </div>
          <div id="card-content">
            <div class="card-body">
              <p class="card-text" id="pairsTime"><strong>Benötigte Zeit:</strong> <span></span></p>
              <p class="card-text" id="pairsHighscore"><strong>{{-- Highscore: --}}</strong> <span>{{-- $highscore --}}</span></p>
              <p class="card-text" id="outputPairsErrors"><strong>Fehler:</strong> <span></span></p>
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
  <script src="{{ asset('js/includes/pairs.js') }}"></script>
  <script src="{{ asset('js/classes/Pair.js') }}"></script>

  <script>
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        locale: {
          format: 'DD.MM.YYYY'
        },
        minDate: <?= ($jsonMinDate) ?? ''; ?>,
        maxDate: <?= ($jsonMaxDate) ?? ''; ?>,
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
              datatype:"json",
              data:{start:start, end:end},
              success:function(data){
                
                if(data.dateDataRow < 6){
                  $('#rowMarker').hide();
                  $('#fieldSizeContainer').hide();                 
                  console.log('Für den ausgewählten Zeitraum gibt es zu wenig Datensätze .. min. 6', data.dateDataRow);
                }else{
                  if(data.markerDataRow < 6){
                    $('#difficultyLevel').hide();
                  }
                  $('#rowMarker').show();
                }
              }
            });
        });
        
        let dataCount = 0;
        let markerArray = [];

        $('#difficultyLevel input[type="checkbox"]').on('click', function(e){
          $('#hdSelectAll').val('');
          $(e.target).parent().toggleClass('active');
          $(e.target).toggleClass('active');

          // wenn der button aktiv ist
          if($(e.target).hasClass('active')){

            markerArray.push($(e.target).prop('id'));

            $.ajax({
              type:'GET',
              url:"{{ route('pair.check.difflevel') }}",
              datatype:"json",
              data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
              success:function(data){
                console.log('data.diffDataRow selbst aktiv ', data.diffDataRow);
                if(data.marker == 0){
                  $(e.target).parent().prop('disabled', true).removeClass('active');
                  $(e.target).prop('disabled', true).removeClass('active');
                  
                }else{
                  //console.log('diffDataRow active', data.diffDataRow);
                  dataCount += data.diffDataRow;
                  
                  if(data.diffDataRow >= 6){
                    
                    switch(data.diffDataRow){
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
                               $('#radio74').parent().siblings().hide();
                               break;
                      default: $('#radio74').parent().siblings().show();
                               $('#radio74').parent().show();                     
                      
                    }

                    $('#fieldSizeContainer').show();
                  }else{
                    $('#fieldSizeContainer').hide();
                  }

                }
              }
            });               
          }else{
            // wenn der Button nicht aktiv ist, aber noch andere Buttons aktiv sind
            if($(e.target).parent().siblings().children().hasClass('active')){
              
              markerArray.splice(markerArray.indexOf($(e.target).prop('id')), 1);

              $.ajax({
                type:'GET',
                url:"{{ route('pair.check.difflevel') }}",
                datatype:"json",
                data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
                success:function(data){
                  console.log('data.diffDataRow selbst nicht aktiv - andere noch aktiv ', data.diffDataRow);
                  if(data.diffDataRow != 0){

                    dataCount -= data.diffDataRow;

                    if(data.diffDataRow < 6){
                      $('#fieldSizeContainer').hide();
                    }
                    
                    switch(data.diffDataRow){
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
                               $('#radio74').parent().siblings().hide();
                               break;
                      default: $('#radio74').parent().siblings().show();
                               $('#radio74').parent().show();                    
                      
                    }

                  }
                }
              }); 
            // wenn kein Button aktiv ist
            }else{
              markerArray = [];
              dataCount = 0;
              $('#fieldSizeContainer').hide();
            }                        
          }
        });

        $('#selectAll').on('click', function(e){
          e.preventDefault();
          markerArray = [];
          $('#selectAll').siblings().children().removeClass('active').children().removeClass('active');
          $('#hdSelectAll').val('btnSelectAll');
          $.ajax({
            type:'GET',
            url:"{{ route('pair.select.all') }}",
            datatype:"json",
            data:{start:start, end:end},
            success:function(data){
              //console.log('data.vocabulariesCount', data.vocabulariesCount);
              if(data.vocabulariesCount >= 6){
                
                switch(data.vocabulariesCount){
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
                               $('#radio74').parent().siblings().hide();
                               break;
                      default: $('#radio74').parent().siblings().show();
                               $('#radio74').parent().show();                     
                      
                    }
                    $('#fieldSizeContainer').show();
              }else{
                $('#fieldSizeContainer').hide();
              }
            }
          });    
          
          dataCount = 0;
        });
      });
    });
</script>
  <script>
    "use strict";

    $(function(){
      <?php if(!empty($_POST)) { $countColumns = substr($_POST['fieldSize'], 0, 1); }?>
      let vocabularies = <?= ($jsonStringPHP) ?? ''; ?>;
      let countCols = <?= ($countColumns) ?? ''; ?>;
      let jsVariable = <?= ($jsVariable) ?? ''; ?>;
      playPairs(vocabularies, countCols, jsVariable);
    });

/*     "use strict";

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
      countColumns = <?= ($countColumns) ?? ''; ?>;
      // console.log(countColumns);
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
          // console.log(e.target);
          if (pairsCounter == 0) {
            interval = setInterval(function() {
              pairsCounter++;
            }, 1000);
          }
          e.target.classList.add('card-turkis');
          // console.log(e.target);
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
 */  </script>
  @endsection
