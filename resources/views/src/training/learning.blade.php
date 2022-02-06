@extends('layouts.main')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/lernen.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}">
@endsection
@section('content')
  <div id="breadcrumb" aria-label="breadcrumb">
    <ol id="breadcrumb" class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('training.index') }}">Training</a></li>
      <li class="breadcrumb-item active" aria-current="page">Lernen</li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert dark-bg" role="alert">
        <h4 class="alert-heading">Lernen</h4>
        @if(isset($countDataRows) && $countDataRows == 0)
          <div class="alert alert-danger">{!! 'Leg erst ein paar <a href="/vocabulary">Vokabeln</a> an!' !!}</div>
        @endif
        @if(isset($countDataRows) && $countDataRows > 0)
        <p>
          <button id="btnFilter" class="btn btn-outline-secondary btn-sm vertical-spacer" type="button"
            data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
            aria-controls="collapseExample">
            Filter
          </button>
        </p>
        <div class="collapse" id="collapseSelection">
          <div class="card card-body bg-transparent border-transparent">

            <form action="{{ route('learning.filter.select') }}" method="post">
              @csrf

              <div class="row">
                  <div class="col-md-6">
                    <label for="vocRange" class="form-label">Welche Vokabel? </label>
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

              <div class="row vertical-spacer" id="direction">
                <div class="col-md-3">
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
                <div class="col-md-3">
                  <h6>Welche Sortierung?</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioSortorder" id="radioRandom" value="random"
                      checked>
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
                </div>
                <div class="row vertical-spacer">
                  <div class="col">
                    <button type="submit" id="btnApplyLearningFilter" class="btn btn-turkis">anwenden</button>
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

    <div id="contTblLearning" class="container">
      <div class="alert dark-bg">
        <table class="table table-striped table-hover" id="vocLearnTable">
          <thead>
            <tr>
              @if('dir1' == $direction)
                <th>{{ session('language_name') }}</th>
                <th>{{ session('foreign_name') }}</th>
              @else
                <th>{{ session('foreign_name') }}</th>
                <th>{{ session('language_name') }}</th>
              @endif
              <th>Marker</th>
            </tr>
          </thead>
          <tbody>
            
            @foreach ($vocabularies as $vocabulary)
            {{-- {{ dd($vocabulary) }} --}}
            @switch($vocabulary['marker'])
              @case (1)    
                <tr class="red-row">
                @break
              @case (2)    
                <tr class="yellow-row">
                @break
              @case (3)    
                  <tr class="green-row">
                  @break
              @default    
                  <tr class="">
                  @break
              @endswitch                
                @if('dir1' == $direction)
                  <td id="v_{{ $vocabulary['vid'] }}" data-id="vn" name="vn" class="language">{{ $vocabulary['vn'] }}</td>
                  <td id="fv_{{ $vocabulary['fvid'] }}" data-id="fvn" name="fvn" class="language">{{ $vocabulary['fvn'] }}</td>
                @else
                  <td id="v_{{ $vocabulary['fvid'] }}" data-id="fvn" name="fvn" class="language">{{ $vocabulary['fvn'] }}</td>
                  <td id="fv_{{ $vocabulary['vid'] }}" data-id="vn" name="vn" class="language">{{ $vocabulary['vn'] }}</td>
                @endif
                <td class="row-marker">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-danger btn-sm"></button>
                    <button type="button" class="btn btn-warning btn-sm"></button>
                    <button type="button" class="btn btn-success btn-sm"></button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif
  </main>
@endsection

@section('javascript')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

  <script>
    "use strict";
    $(function() {
      $('input[name="daterange"]').daterangepicker({
        format: 'DD.MM.YYYY',
        opens: 'left'
      }, function(start, end, label) {
        
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
              url:"{{ route('learning.check.date') }}",
              datatype:"json",
              data:{start:start, end:end},
              success:function(data){
                console.log(data.dateDataRow);

                if(data.dateDataRow == 0){
                  $('#rowMarker').hide();
                  $('#direction').hide();
                  console.log('Für den ausgewählten Zeitraum gibt es zu wenig Datensätze .. min. 4', data.dateDataRow);
                }else{
                  if(data.markerDataRow == 0){
                    //console.log(data.markerDataRow);
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
            //console.log('e.target', $(e.target).prop('id'));
            markerArray.push($(e.target).prop('id'));          

            $.ajax({
              type:'GET',
              url:"{{ route('learning.check.difflevel') }}",
              datatype:"json",
              data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
              success:function(data){
                
                if(data.marker == 0){
                  $(e.target).parent().prop('disabled', true).removeClass('active');
                  $(e.target).prop('disabled', true).removeClass('active');

                }else{     
                  dataCount += data.diffDataRow;
                  $('#direction').show();
                }
              }
            });

          }else{

            if($(e.target).parent().siblings().children().hasClass('active')){
              
              markerArray.splice(markerArray.indexOf($(e.target).prop('id')), 1);

                $.ajax({
                type:'GET',
                url:"{{ route('learning.check.difflevel') }}",
                datatype:"json",
                data:{start:start, end:end, markerArray:markerArray, marker:$(e.target).val()},
                success:function(data){

                  if(data.diffDataRow > 0){

                      dataCount -= data.diffDataRow;
                      $('#direction').show();

                      if(data.diffDataRow <= 0){                      
                        $('#direction').hide();
                      }
                    }
                  }
                });
              }else{
                markerArray = [];
                dataCount = 0;
                $('#direction').hide();

            }               
          }  
        });

        $('#selectAll').on('click', function(e){
          e.preventDefault();
          $('#selectAll').siblings().children().removeClass('active').children().removeClass('active');
          $('#hdSelectAll').val('btnSelectAll');
          
          $.ajax({
            type:'GET',
            url:"{{ route('learning.select.all') }}",
            datatype:"json",
            data:{start:start, end:end},
            success:function(data){
              $('#direction').show();
            }
          });
          
          dataCount = 0;
        });

      });
    });
</script>

@endsection
