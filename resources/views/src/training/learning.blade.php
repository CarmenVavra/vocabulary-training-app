  @extends('layouts.main')
  @section('css')
    <link rel="stylesheet" href="{{ asset('css/lernen.css') }}">
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

              <label for="vocRange" class="form-label">Welche Vokabel? </label><small>Angabe in Wochen</small>
              <input type="range" value="0" min="1" max="200" oninput="this.nextElementSibling.value = this.value">
              <output>0</output>

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
                  <h6>Welche Richtung?</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioDirection" id="radioDirection1" value="dir1"
                      checked>
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
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="radioSortorder" id="radioDate" value="date">
                    <label class="form-check-label" for="radioDate">
                      nach Datum sortiert
                    </label>
                  </div>
                </div>
                <div class="col">
                  <button id="btnApplyLearningFilter" class="btn btn-turkis">anwenden</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="contTblLearning" class="container">
        <div class="alert dark-bg">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>Deutsch</th>
                <th>Spanisch</th>
                <th>Marker</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($vocabularies as $vocabulary)
                <tr>
                  <td class="language">{{ $vocabulary->voca }}</td>
                  <td class="language">{{ $vocabulary->vocalearn }}</td>
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
          <div class="row">
            <div class="col-md-9"></div>
            <div class="col-md-3">
              <button id="saveMarks" class="btn btn-turkis" name="saveMarks" type="button">Markierungen speichern</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  @endsection
