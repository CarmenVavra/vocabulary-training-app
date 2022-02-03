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
        @if(isset($countDataRows) && $countDataRows == 0)
          <div class="alert alert-danger">{!! 'Es sind zu wenige Vokabeln vorhanden, um <strong>Hangman</strong> zu spielen. Leg noch ein paar <a href="/vocabulary" >Vokabeln</a> an!' !!}</div>
        @endif
        @if(isset($countDataRows) && $countDataRows > 0)
        <p>
          <button id="btnFilter" class="btn btn-outline-secondary btn-sm vertical-spacer" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Filter
          </button>
        </p>
        <div class="collapse" id="collapseSelection">
          <div class="card card-body bg-transparent border-transparent">
          <form action="{{ route('hangman.filter.select') }}" method="post">
            @csrf
          <div class="row">
              <div class="col-md-6">
                <label for="vocRange" class="form-label">Welche Vokabel?</label>
                <input type="text" name="daterange" value="" id="vocRange" />
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
            <div id="learnApply" class="row vertical-spacer">
              <div class="col">
                <button type="submit" id="btnApplyHangmanFilter" class="btn btn-turkis">anwenden</button>
              </div>
            </div>

            </form>
          </div>
        </div>
        @endif
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
              <p class="card-text" id="hangmanUser">{{ Auth::user()->name}}: <span></span></p>
              <p class="card-text" id="hangmanComp">Computer: <span></span></p>
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
    @endif
  </main>
  @endsection
  @section('javascript')


  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="{{ asset('js/includes/hangman.js') }}"></script>
  <script src="{{ asset('js/classes/Canvas.js') }}"></script>
  <script>
    "use strict";
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
              url:"{{ route('hangman.check.date') }}",
              datatype:"json",
              data:{start:start, end:end},
              success:function(data){
                console.log(data.dateDataRow);

                if(data.dateDataRow == 0){
                  $('#rowMarker').hide();
                  $('#learnApply').hide();
                  console.log('Für den ausgewählten Zeitraum gibt es zu wenig Datensätze .. min. 4', data.dateDataRow);
                }else{
                  if(data.markerDataRow == 0){
                    $('#difficultyLevel').hide();
                    $('#learnApply').hide();
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

          if($(e.target).hasClass('active')){

            markerArray.push($(e.target).prop('id')); 

            $.ajax({
              type:'GET',
              url:"{{ route('hangman.check.difflevel') }}",
              datatype:"json",
              data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},

              success:function(data){
                if(data.diffDataRow > 0){
                  $('#learnApply').show();
                }else{
                  $('#learnApply').hide();
                }

                if(data.marker == 0){
                  $(e.target).parent().prop('disabled', true).removeClass('active');
                  $(e.target).prop('disabled', true).removeClass('active');
                }
              }
            });               
          }else{
            if($(e.target).parent().siblings().children().hasClass('active')){

              markerArray.splice(markerArray.indexOf($(e.target).prop('id')), 1);

              $.ajax({
                type:'GET',
                url:"{{ route('hangman.check.difflevel') }}",
                datatype:"json",
                data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
                success:function(data){

                  if(data.diffDataRow > 0){
                    $('#learnApply').show();
                  }else{
                    $('#learnApply').hide();
                  }
                }
              });             
            }else{
              markerArray = [];
              dataCount = 0;
              $('#learnApply').hide();


            }            
            
          }

        });

        $('#selectAll').on('click', function(e){
          e.preventDefault();
          $('#selectAll').siblings().children().removeClass('active').children().removeClass('active');
          $('#hdSelectAll').val('btnSelectAll');
          $.ajax({
            type:'GET',
            url:"{{ route('hangman.select.all') }}",
            datatype:"json",
            data:{start:start, end:end},
            success:function(data){
              if(data.vocabulariesCount > 0 ){
                $('#learnApply').show();
              }else{
                $('#learnApply').hide();
              }
              console.log(data);
            }
          });    
          
          dataCount = 0;
        });




      });
    });
</script>


  <script>
    $(function(){
      let origArray = <?= ($vocJsonStringPHP) ?? ''; ?>;
      playHangman(origArray);
    });
/*     "use strict";

    let canvas = new Canvas(document.querySelector('#hangman'));
    const output = document.querySelector('#output');
    
    let origArray = <?= ($vocJsonStringPHP) ?? ''; ?>;
    let origString = origArray[0].fvn;
    console.log('origArray ', origArray);
    console.log('origString ', origString);
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
            case 1: canvas.drawBaseTriangle(); break;
            case 2: canvas.drawPoleLine(); break;
            case 3: canvas.drawLatteLine(); break;
            case 4: canvas.drawSlopeLine(); break;
            case 5: canvas.drawRopeLine(); break;
            case 6: canvas.drawHeadCircle(); break;
            case 7: canvas.drawBodyLine(); break;
            case 8: canvas.drawRightArmLine(); break;
            case 9: canvas.drawLeftArmLine(); break;
            case 10: canvas.drawRightLegLine(); break;
            case 11: canvas.drawLeftLegLine();
                      computer++;
                      outputCardTitle.innerHTML = 'Du hast verloren! Das gesuchte Wort lautet: ' + origString;
                      outputUserCount.innerHTML = user;
                      outputCompCount.innerHTML = computer;
                      hangModal.openModal();
                      break;
            default: return;
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
        window.location.href = '/hangman';
    };

    closeCont.onclick = function(e) {
      if (e.target.id == 'overlay-hangman-container' || e.target.id == 'close') {
        window.location.href = '/hangman';
        hangModal.closeModal();
      }
    };
 */  </script>
  @endsection
