
    @extends('layouts.main')
    @section('css')
        <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    @endsection
    @section('content')

  <main id="welcomePage">
    <div class="container">
      <div class="row card-group">
        <div class="card col-md turkis-bg">
          <img src="{{ asset('img/lerninhalt.jpg') }}" class="card-img-top" alt="Lerninhalt">
          <div class="card-body">
            <h5 class="card-title">Vokabel</h5>
            <p class="card-text">Füge Vokabel hinzu, bearbeite oder lösche sie</p>
            <a href="{{ route('vocabulary.index') }}" class="btn btn-darkgray">zu den Vokabeln</a>
          </div>
        </div>
        <div class="card col-md dark-bg">
          <img src="{{ asset('img/lernen.jpg') }}" class="card-img-top" alt="training">
          <div class="card-body">
            <h5 class="card-title">Training</h5>
            <p class="card-text">Los geht's! Prüfe dein Wissen</p>
            <a href="{{ route('training.index') }}" class="btn btn-turkis">zum Training</a>
          </div>
        </div>
        <div class="card col-md turkis-bg">
          <img src="{{ asset('img/dashboard.jpg') }}" class="card-img-top" alt="dashboard">
          <div class="card-body">
            <h5 class="card-title">Dashboard</h5>
            <p class="card-text">Kontrolliere deine bisherigen Leistungen</p>
            <a href="{{ route('dashboard.index') }}" class="btn btn-darkgray">zum Dashboard</a>
          </div>
        </div>
      </div>
    </div>

  </main>
  @endsection
