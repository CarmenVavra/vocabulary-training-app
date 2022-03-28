@extends('layouts.main')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('css/language.css') }}">
@endsection
@section('content')
<main>
  <div class="container">
    <div class="alert turkis-bg" role="alert">
      <h4 class="alert-heading">Impressum</h4>
    </div>

    <div class="alert bg-darkgray">
      <div class="row">
        <div class="col-md-4">
          <p class="h5">Ing. Carmen Vavra</p>
          <p>Privatperson</p>
          <p>E-Mail: <a href="mailto:admin@caryssa.at">admin@caryssa.at</a></p>
        </div>
        <div class="col-md-4">
          <p class="h5">Design, Gestaltung, Programmierung</p>
          <p>Ing. Carmen Vavra</p>
        </div>
        <div class="col-md-4">
          <p class="h5">Fotos</p>
          <p>Die meisten Fotos auf dieser Website wurden von <a href="https://pixabay.com/de" target="_blank">Pixabay</a> zur Verfügung gestellt.</p>
          <p>Dafür bedanke ich mich herzlich!</p>
        </div>

      </div>
      
    </div>
  </div>
</main>

@endsection

