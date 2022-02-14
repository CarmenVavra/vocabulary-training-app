@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<div id="breadcrumb" aria-label="breadcrumb">
  <ol id="breadcrumb" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('vocabulary.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('language.admin.index') }}">Sprachen</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>ändern</strong></li>
  </ol>
</div>
<main>
    <div class="alert dark-bg">
      <form class="row g-3" action="{{ route('language.update', $language->id) }}" method="post">
          @csrf
          @method('put')
        <div class="col-md-6">
          <label for="languageName" class="form-label">Sprache</label>
          <input type="text" id="languageName" class="form-control" name="name" value="{{ $language->name }}" required minlength="2">
          <div class="text-danger">Das Feld <italic>Sprache</italic> darf nicht leer sein!</div>
        </div>
        <div class="col-md-6">
          <label for="languageShortName" class="form-label">Kurzform</label>
          <input type="text" id="languageShortName" class="form-control" name="short_name" value="{{ $language->short_name }}" required minlength="2">
          <div class="text-danger">Das Feld <italic>Kurzform</italic> darf nicht leer sein!</div>
        </div>
        <div class="col-12">
          <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
        </div>
      </form>
    </div>
</main>
@endsection

