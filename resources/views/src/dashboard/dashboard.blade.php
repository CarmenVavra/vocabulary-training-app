@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')

  <div id="breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('welcome.index') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </div>
  <main id="dashboard">
    <div class="container">
      <div class="row card-group">
        <div class="card col-md turkis-bg">
          <img src="{{ asset('img/editlanguage.png') }}" class="card-img-top" alt="languages">
          <div class="card-body">
            <h5 class="card-title">Sprachen bearbeiten</h5>
            <p class="card-text">Sprachen bearbeiten und löschen</p>
            <a href="{{ route('language.admin.index') }}" class="btn btn-darkgray">zu den Sprachen</a>
          </div>
        </div>
        <div class="card col-md dark-bg">
          <img src="{{ asset('img/editUsers.png') }}" class="card-img-top" alt="users">
          <div class="card-body">
            <h5 class="card-title">Benutzer bearbeiten</h5>
            <p class="card-text">Benutzer-Rolle ändern oder Benutzer löschen</p>
            <a href="{{ route('user.index') }}" class="btn btn-turkis">zu den Benutzern</a>
          </div>
        </div>

      </div>
    </div>

  </main>

@endsection


