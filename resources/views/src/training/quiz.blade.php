@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/quiz.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
@endsection
@section('content')
  <div id="breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('vocabulary.index')}}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('training.index') }}">Training</a></li>
      <li class="breadcrumb-item active" aria-current="page"><strong>Quiz</strong></li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert dark-bg" role="alert">
        <h4 class="alert-heading">Quiz</h4>
        @if(isset($countDataRows) && $countDataRows < 4)
          <div class="alert alert-danger">{!! 'Es sind zu wenige Vokabeln vorhanden, um <strong>Quiz</strong> zu spielen. Leg noch ein paar <a href="/vocabulary" >Vokabeln</a> an!' !!}</div>
        @endif
        @if(isset($countDataRows) && $countDataRows >=4)
        <p>
          <button id="btnFilter" class="btn btn-outline-secondary btn-sm vertical-spacer" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Filter
          </button>
        </p>
        <div class="collapse" id="collapseSelection">
          <div class="card card-body bg-transparent border-transparent">
            <form action="{{ route('quiz.filter.select') }}" method="post">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  <label for="vocRange" class="form-label">Welche Vokabel?</label>
                  <input type="text" name="daterange" value="{{ old('daterange')}}" id="vocRange" />
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

              <div class="row" id="questionCount">
                <div class="col-md-6">
                  <label for="questionRange" class="form-label">Wieviele Fragen?</label>
                  <input name="countQuestions" id="questionRange" type="range" value="4" min="4" max="" step="4" oninput="this.nextElementSibling.value = this.value">
                  <output>4</output>
                </div>
              </div>

              <div class="row vertical-spacer" id="direction">
                <div class="col">
                  <h6>Welche Richtung?</h6>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection1" value="dir1" checked>
                    <label class="form-check-label" for="radioDirection1">
                    {{ session('language_name') }} --> {{ session('foreign_name') }}
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection2" value="dir2">
                    <label class="form-check-label" for="radioDirection2">
                    {{ session('foreign_name') }} --> {{ session('language_name') }}
                    </label>
                  </div>
                </div>
                <div class="row vertical-spacer">
                  <div class="col">
                    <button id="btnApplyQuizFilter" class="btn btn-turkis">anwenden</button>
                  </div>
                </div>
              </div>

            </form>

          </div>
        </div>
        @endif
      </div>
    </div>
    @if(isset($vocabularies))
      <div id="outputQuiz" class="container">

        <div id="overlay-spinner" style="display:none;">
          <div id="overlay-spinner-container">            
            <div class="alert turkis-bg">
              <div class="row">
                <div class="col-md">
                  <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="overlay-quizresult" style="display:none;">
          <div id="overlay-quizresult-container">
            <div id="close">X</div>
            <div class="alert bg-turkis">
            <div id="card-content">
                <div class="card-body">
                  <h5 class="card-title">QUIZ</h5>
                  <p class="card-text" id="quizResult"> Du hast <span></span>x falsch geantwortet! </p>
                  
                  <hr>
                  <button type="button" class="btn btn-turkis"><a href="{{ route('quiz.index') }}">OK</a></button>
                </div>
              </div>
            </div>
          </div>
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
    <script src="{{ asset('js/classes/CardSet.js') }}"></script>
    {{-- <script src="{{ asset('js/includes/quiz.js') }}"></script> --}}
    <script src="{{ asset('js/logic_quiz.js') }}"></script>

  <script>
    "use strict";
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        locale: {
          format: 'DD.MM.YYYY'
        },
/*         startDate: '2013-01-01',
        endDate: '2013-12-31', */
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
              url:"{{ route('quiz.check.date') }}",
              datatype:"json",
              data:{start:start, end:end},
              success:function(data){
                
                if(data.dateDataRow < 4){
                  $('#rowMarker').hide();
                  $('#questionCount').hide();
                  $('#direction').hide();
                  console.log('Für den ausgewählten Zeitraum gibt es zu wenig Datensätze .. min. 4', data.dateDataRow);
                }else{
                  if(data.markerDataRow < 4){
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

          if($(e.target).hasClass('active')){

            markerArray.push($(e.target).prop('id')); 

            $.ajax({
              type:'GET',
              url:"{{ route('quiz.check.difflevel') }}",
              data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
              success:function(data){

                if(data.marker == 0){
                  $(e.target).parent().prop('disabled', true).removeClass('active');
                  $(e.target).prop('disabled', true).removeClass('active');
                  
                }else{

                  dataCount += data.diffDataRow;
                  
                  if(data.diffDataRow >= 4){

                    switch(true){
                      case (data.diffDataRow >= 4 && data.diffDataRow < 8): $('#questionRange').prop('max', 4); break;
                      case (data.diffDataRow >= 8 && data.diffDataRow < 12): $('#questionRange').prop('max', 8); break;                
                      case (data.diffDataRow >= 12 && data.diffDataRow < 16): $('#questionRange').prop('max', 12); break;                
                      case (data.diffDataRow >= 16 && data.diffDataRow < 20): $('#questionRange').prop('max', 16); break;                
                      case (data.diffDataRow >= 20 && data.diffDataRow < 24): $('#questionRange').prop('max', 20); break;                
                      case (data.diffDataRow >= 24 && data.diffDataRow < 28): $('#questionRange').prop('max', 24); break;                
                      case (data.diffDataRow >= 28 && data.diffDataRow < 32): $('#questionRange').prop('max', 28); break;                
                      case (data.diffDataRow >= 32 && data.diffDataRow < 36): $('#questionRange').prop('max', 32); break;                
                      case (data.diffDataRow >= 36 && data.diffDataRow < 40): $('#questionRange').prop('max', 36); break;                
                      case (data.diffDataRow > 40): $('#questionRange').prop('max', 40); break;                
                    }      

                    $('#questionCount').show();
                    $('#direction').show();
                  }else{
                    $('#questionCount').hide();
                    $('#direction').hide();
                  }

                }
              }
            });               
          }else{
            if($(e.target).parent().siblings().children().hasClass('active')){

              markerArray.splice(markerArray.indexOf($(e.target).prop('id')), 1);

              $.ajax({
                type:'GET',
                url:"{{ route('quiz.check.difflevel') }}",
                datatype:"json",
                data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
                success:function(data){
                  if(data.diffDataRow != 0){

                    dataCount -= data.diffDataRow;
                    if(data.diffDataRow < 4){
                      $('#questionCount').hide();
                      $('#direction').hide();
                    }

                    switch(true){
                      case (data.diffDataRow >= 4 && data.diffDataRow < 8): $('#questionRange').prop('max', 4); break;
                      case (data.diffDataRow >= 8 && data.diffDataRow < 12): $('#questionRange').prop('max', 8); break;                
                      case (data.diffDataRow >= 12 && data.diffDataRow < 16): $('#questionRange').prop('max', 12); break;                
                      case (data.diffDataRow >= 16 && data.diffDataRow < 20): $('#questionRange').prop('max', 16); break;                
                      case (data.diffDataRow >= 20 && data.diffDataRow < 24): $('#questionRange').prop('max', 20); break;                
                      case (data.diffDataRow >= 24 && data.diffDataRow < 28): $('#questionRange').prop('max', 24); break;                
                      case (data.diffDataRow >= 28 && data.diffDataRow < 32): $('#questionRange').prop('max', 28); break;                
                      case (data.diffDataRow >= 32 && data.diffDataRow < 36): $('#questionRange').prop('max', 32); break;                
                      case (data.diffDataRow >= 36 && data.diffDataRow < 40): $('#questionRange').prop('max', 36); break;                
                      case (data.diffDataRow > 40): $('#questionRange').prop('max', 40); break;                 

                    }
                    
                  }
                }
              });             
            }else{
              markerArray = [];
              dataCount = 0;
              $('#questionCount').hide();
              $('#direction').hide();
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
            url:"{{ route('quiz.select.all') }}",
            datatype:"json",
            data:{start:start, end:end},
            success:function(data){
              
              let vocCount = data.vocabulariesCount;
              if(vocCount >= 4){
                
                switch(true){
                  case (vocCount >= 4 && vocCount < 8): $('#questionRange').prop('max', 4); break;
                  case (vocCount >= 8 && vocCount < 12): $('#questionRange').prop('max', 8); break;                
                  case (vocCount >= 12 && vocCount < 16): $('#questionRange').prop('max', 12); break;                
                  case (vocCount >= 16 && vocCount < 20): $('#questionRange').prop('max', 16); break;                
                  case (vocCount >= 20 && vocCount < 24): $('#questionRange').prop('max', 20); break;                
                  case (vocCount >= 24 && vocCount < 28): $('#questionRange').prop('max', 24); break;                
                  case (vocCount >= 28 && vocCount < 32): $('#questionRange').prop('max', 28); break;                
                  case (vocCount >= 32 && vocCount < 36): $('#questionRange').prop('max', 32); break;                
                  case (vocCount >= 36 && vocCount < 40): $('#questionRange').prop('max', 36); break;                
                  case (vocCount > 40): $('#questionRange').prop('max', 40); break;               
                }
                
                $('#questionCount').show();
                $('#direction').show();
              }else{
                $('#questionCount').hide();
                $('#direction').hide();3
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

    let limit = <?php echo ($_POST['countQuestions']) ?? 0 ?>;
    let vocFromDB = <?= ($jsonStringPHP) ?? '""'; ?>;
    let radioDirection = "<?= ($radioDirection) ?? ''; ?>";

    let question;
    let answer;
    let fakeAnswers;
    let cardSet;    
    const content = document.querySelector('#outputQuiz');
    const spinner = document.querySelector('#overlay-spinner');
    let flexContainer;
    let outputQuestion;
    let outputAnswers;
    let fakVoc = [];
    let millSec = 0;
    const quizresult = document.querySelector('#overlay-quizresult');
    
    //::PETER:: Funktion für die Cards. Parameter beim ersten Aufruf -> Anzahl der Fragen
    function quizFetchFake(length){
        spinner.style.display = 'block';
        let i = length;
        //::PETER:: Anzahl der Fragen 1 subtrahieren
        length--;
        $.ajax({
            type:'GET',
            url:"{{ route('quiz.fetch.fake') }}",
            datatyp: "json",
            data:{radioDirection:radioDirection},
            success:function(data){
              fakVoc = data.fakeVoc;
              cardSet = new CardSet(vocFromDB[length], fakVoc, radioDirection);
              question = cardSet.getQuestion();
              answer = cardSet.getAnswer();
              fakeAnswers = cardSet.getFakeAnswers();
    
              if( i % 4 === 0 || flexContainer === undefined){
                content.insertAdjacentHTML('beforeend', '<div id="contId_'+i+'" class="card-flex-container">');
                flexContainer = document.querySelector('#contId_'+i);
              }
              
              flexContainer.insertAdjacentHTML('beforeend', '<div id="card_' + i + '" class="card bg-turkis" style="width: 18rem;"><div class="card-body">');
              outputQuestion = document.querySelector('#card_' + i + ' .card-body');
              outputQuestion.insertAdjacentHTML('beforeend', '<div class="card-title bg-darkgray">' + question + '</div><ul class="list-group list-group-flush">');
              outputAnswers = document.querySelector('#card_' + i + ' .card-body .list-group');

              fakeAnswers.forEach(function(value, index) {
                //::Peter:: ich würde die Frage im Data Attribut mitgeben data-
                outputAnswers.insertAdjacentHTML('beforeend', '<li class="list-group-item" data-q="'+ question +'">' + value + '</li>');
              });
              
              if( length > 0){
                //::PETER:: Falls Anzahl der Fragen größer als 0 ist, wird die Funktion nochmal aufgerufen
                quizFetchFake(length);
              }
              else{
                //::PETER:: Falls Anzahl der Fragen  0 ist, wird die Funktion quizFetchFakeEnd aufgerufen
                quizFetchFakeEnd();
              }
            }           
        });
        
    }

  function quizFetchFakeEnd(){
      spinner.style.display = 'none';
      //::Peter:: Hier würde ich den Eventhandler auf die UL setzten und über target arbeitern
      const listItems = document.querySelectorAll('#outputQuiz .list-group');

      let errorCount = 0;
      let correctCount = 0;

      const quizErrors = document.querySelector('#quizResult span');
      quizErrors.innerText = errorCount;
      
      listItems.forEach(function(value, index){
          value.onmouseup = function(e){
            if( e.target.nodeName == 'LI'){
              let listItem = e.target;
              let question = listItem.getAttribute('data-q'); //::Peter:: Data Attribut auslesen
              let selectedAnswer = listItem.innerText;
   
              $.ajax({
                type:'GET',
                url:"{{ route('quiz.check.answers') }}",
                datatype:'json',
                data:{
                  question:question, 
                  selectedAnswer:selectedAnswer
                },
                success:function(data){
                    if(typeof data.check !== undefined  && data.check ){
                        listItem.classList.add('correct');
                        value.classList.add('prevent-pointer-events'); //::Peter:: die CSS Class nur noch auf die UL setzten
                        correctCount++;
                        if(correctCount == limit){
                          quizresult.style.display = 'block';
                        }
                    }
                    else{
                      listItem.classList.add('failure');
                      errorCount++;   
                      quizErrors.innerText = errorCount;   
                    } 
                }
              });
            }
          }
      });

/*       listItems.forEach(function(value, index){
            
            //console.log(itemCount++);
            value.onmousedown = function(e){
          
              cardId = e.target.parentNode.parentNode.parentNode.id;
              cardContainer = e.target.parentNode.parentNode.parentNode;
              cardTitle = e.target.parentNode.previousElementSibling.innerText;
              selectedAnswer = value.innerText;            
              
              $.ajax({
                type:'GET',
                url:"{{ route('quiz.check.answers') }}",
                datatype:'json',
                data:{
                  question:cardTitle, 
                  selectedAnswer:selectedAnswer
                },
                success:function(data){

                  if(data.quizPair.vn == cardTitle){
                    
                    if(data.quizPair.fvn == selectedAnswer){
                      value.classList.add('correct');
                      value.classList.remove('failure');
                      value.classList.add('prevent-pointer-events');
                      cardContainer.classList.add('prevent-pointer-events');
                      correctCount++;
                      if(correctCount == limit){
                        quizresult.style.display = 'block';
                      }
                    }else{
                      value.classList.add('failure');
                      errorCount++;   
                      quizErrors.innerText = errorCount;         
                    }     

                  }
                  
                }
              });
              
            };
            
          }); */  
    }
    
    if( vocFromDB.length > 0 ){
      quizFetchFake( vocFromDB.length );
    }
    //console.log(vocFromDB.length);

/*     for (let i = 1; i <= vocFromDB.length; i++) {
        spinner.style.display = 'block';
      
        $.ajax({
            type:'GET',
            url:"{{ route('quiz.fetch.fake') }}",
            datatyp: "json",
            data:{radioDirection:radioDirection},
            success:function(data){

              fakVoc = data.fakeVoc;

              cardSet = new CardSet(vocFromDB[i-1], fakVoc, radioDirection);

              question = cardSet.getQuestion();
              answer = cardSet.getAnswer();
              fakeAnswers = cardSet.getFakeAnswers();
              
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
        });
      }

     
      switch(true){
        case (limit < 5) : millSec = 3000; break;
        case (limit < 10) : millSec = 7000; break;
        case (limit < 20) : millSec = 13000; break;
        case (limit < 30) : millSec = 18000; break;
        default: millSec = 22000; break;
      }

      // darf erst ausgeführt werden, wenn das Spielfeld fertig aufgebaut ist->setTimeout()
      setTimeout(function() { 
      
          spinner.style.display = 'none';      
          const listItems = document.querySelectorAll('.list-group-item');
          let cardId;
          let cardContainer;
          let cardTitle;
          let selectedAnswer;
          let errorCount = 0;
          let correctCount = 0;
          const quizErrors = document.querySelector('#quizResult span');
          //let itemCount = 0; // DebuggVariable
          listItems.forEach(function(value, index){
            
            //console.log(itemCount++);
            value.onmousedown = function(e){
          
              cardId = e.target.parentNode.parentNode.parentNode.id;
              cardContainer = e.target.parentNode.parentNode.parentNode;
              cardTitle = e.target.parentNode.previousElementSibling.innerText;
              selectedAnswer = value.innerText;            
              
              $.ajax({
                type:'GET',
                url:"{{ route('quiz.check.answers') }}",
                datatype:'json',
                data:{
                  question:cardTitle, 
                  selectedAnswer:selectedAnswer
                },
                success:function(data){

                  if(data.quizPair.vn == cardTitle){
                    
                    if(data.quizPair.fvn == selectedAnswer){
                      
                      value.classList.add('correct');
                      value.classList.remove('failure');
                      value.classList.add('prevent-pointer-events');
                      cardContainer.classList.add('prevent-pointer-events');
                      correctCount++;
                      if(correctCount == limit){
                        quizresult.style.display = 'block';
                      }
                      
                    }else{
                      value.classList.add('failure');
                      errorCount++;   
                      quizErrors.innerText = errorCount;         
                    }     

                  }
                  
                }
              });
              
            };
            
          });    

 
     }, millSec); */

          
   
 </script>
  @endsection
