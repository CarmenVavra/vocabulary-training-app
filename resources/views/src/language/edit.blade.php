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
      <form id="formLanguageEdit" action="{{ route('language.update', $language->id) }}" method="post">
        @csrf
        @method('put')
          <div class="row-md" style="display: flex">

            <div class="col-md-4 left-spacer">
              <label for="languageName" class="form-label">Sprache</label>
              <input type="text" id="languageName" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $language->name }}" required minlength="2">
              <div class="invalid-feedback">Das Feld <italic>Sprache</italic> darf nicht leer sein!</div>
            </div>
            <div class="col-md-4 left-spacer">
              <label for="languageShortName" class="form-label">Kurzform</label>
              <input type="text" id="languageShortName" class="form-control @error('short_name') is-invalid @enderror"" name="short_name" value="{{ $language->short_name }}" required minlength="2">
              <div class="invalid-feedback">Das Feld <italic>Kurzform</italic> darf nicht leer sein!</div>
            </div>
          <div class="col-md-3 left-spacer btn-group">
            <button class="btn btn-turkis btn-vertical-align" type="submit" formnovalidate>ändern</button>
            <a href="{{ route('language.admin.index') }}" class="btn btn-danger btn-vertical-align" type="button" formnovalidate>zurück</a>
          </div>
        </div>
      </form>
    </div>
</main>
@endsection

