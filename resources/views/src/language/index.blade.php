@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<div id="breadcrumb" aria-label="breadcrumb">
  <ol id="breadcrumb" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('vocabulary.index') }}">Home</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>Sprachen</strong></li>
  </ol>
</div>
@if(isset($deleteLanguage))
  @include('layouts.modals.languages.delete')
@endif
<main>
<div class="container">
  <table id="tblLanguages" class="table table-striped table-dark table-hover">
    <thead>
      <tr>
        <th>Sprache</th>
        <th>Abkürzung</th>
        <th>Benutzer</th>
        <th>Bearbeiten</th>
        <th>Löschen</th>
      </tr>
    </thead>
    <tbody>
      @if(isset($languages))
        @foreach($languages as $language)

          <tr>
            <td class="language">{{ $language->lname }}</td>
            <td class="language">{{ $language->lshort }}</td>
            <td class="language">{{ $language->uname }}</td>
            <td>
              @if($language->uid != null)
              <a href="{{ route('language.edit', $language->lid ) }}"><button type="button" class="btn btn-info btn-sm btn-edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                </svg>
              </button></a>
              @endif
            </td>
            <td>
              @if($language->uid == null)
              <form action="{{ route('language.warn.delete', $language->lid ) }}" method="post">
                  @csrf
                  @method('delete')
                  
                  <button type="submit" class="btn btn-danger btn-sm btn-delete">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                      </svg>
                  </button>
              </form>
              @endif
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>
</main>
@endsection