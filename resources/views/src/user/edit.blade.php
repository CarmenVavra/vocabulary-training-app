@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<div id="breadcrumb" aria-label="breadcrumb">
  <ol id="breadcrumb" class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('vocabulary.index') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Benutzer</a></li>
    <li class="breadcrumb-item active" aria-current="page"><strong>ändern</strong></li>
  </ol>
</div>
<main>
    <div class="alert dark-bg">
      <div class="row-md" style="display:flex">
        <div class="col-md-6 left-spacer">
            <div class="row-md">
              <div class="col-md-12">Benutzername:<span class="user-info"> {{ $user->name }} </span></div>
            </div>
            <div class="row-md vertical-spacer">
              <div class="col-md-12">E-Mail:<span class="user-info"> {{ $user->email }} </span></div>
            </div>
            <div class="row-md vertical-spacer">
              <div class="col-md-12">Rolle:<span class="user-info"> {{ $role_name }} </span></div>
            </div>
            <div class="row-md vertical-spacer">
              <div class="col-md-12">angemeldet seit:<span class="user-info"> {{ $user->created_at->format('d.m.Y') }} </span></div>
            </div>
        </div>
        <div class="col-md-6">
          <form action="{{ route('admin.update', $user->id) }}" method="post">
            @csrf
            @method('put') 
          <div class="row-md">
            <div class="col-md-12 form-check form-switch">
              <input class="form-check-input" type="checkbox" id="userRole" name="role_id" @if($user->role_id == '1') ? {{ 'checked' }} : '' @endif>
              <label class="form-check-label" for="userRole">Admin</label>
            </div>
          </div>
          <div class="row-md vertical-spacer">
            <div class="col-md-4 btn-group">
              <button class="btn btn-turkis" type="submit" formnovalidate>ändern</button>
              <a href="{{ route('user.index') }}" class="btn btn-danger" type="button" formnovalidate>zurück</a>
            </div>
          </div>
        </form>
        </div>
      </div>

    </div>
</main>
@endsection