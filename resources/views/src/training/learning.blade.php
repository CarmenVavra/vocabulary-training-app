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
                      <input type="text" name="daterange" value="" id="vocRange" />
                    </div>
                </div>

                @if(!empty($marker)) 
                
                <div class="row-marker">
                  <label for="difficultyLevel" class="form-label">Welcher Schwierigkeitsgrad? </label>
                  <div id="difficultyLevel" class="btn-group" role="group">
                    <button name="diffRed" type="button" class="btn btn-danger btn-lg" data-value="red"></button>
                    <button name="diffYellow" type="button" class="btn btn-warning btn-lg" data-value="yellow"></button>
                    <button name="diffGreen" type="button" class="btn btn-success btn-lg" data-value="green"></button>
                  </div>
                  <button type="button" class="btn btn-light btn-lg btn-all">ALLE</button>
                </div>
                
                @endif

                <div class="row vertical-spacer">
                  <div class="col">
                    <h6>Welche Richtung?</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection1" value="dir1"
                        checked>
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
                  <div class="col">
                    <button type="submit" id="btnApplyLearningFilter" class="btn btn-turkis">anwenden</button>
                  </div>
                </div>
                
              </form>

            </div>
          </div>
        </div>
      </div>
      
      @if(isset($vocabularies))

      <div id="contTblLearning" class="container">
        <div class="alert dark-bg">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                @if('dir1' == $direction)
                  <th>Deutsch</th>
                  <th>{{ session('foreign_name') }}</th>
                @else
                  <th>{{ session('foreign_name') }}</th>
                  <th>Deutsch</th>
                @endif
                <th>Marker</th>
              </tr>
            </thead>
            <tbody>
              
              @foreach ($vocabularies as $vocabulary)
                <tr>
                  @if('dir1' == $direction)
                  <td id="v_{{ $vocabulary['vid'] }}" class="language">{{ $vocabulary['vn'] }}</td>
                  <td id="fv_{{ $vocabulary['fvid'] }}" class="language">{{ $vocabulary['fvn'] }}</td>
                  @else
                    <td id="v_{{ $vocabulary['fvid'] }}" class="language">{{ $vocabulary['fvn'] }}</td>
                    <td id="fv_{{ $vocabulary['vid'] }}" class="language">{{ $vocabulary['vn'] }}</td>
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
        $(function() {
          $('input[name="daterange"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
          });
        });
    </script>

  @endsection
