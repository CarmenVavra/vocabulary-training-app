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
              <div class="col-md-12">Benutzername: {{ $user->name }}</div>
            </div>
            <div class="row-md vertical-spacer">
              <div class="col-md-12">E-Mail: {{ $user->email }}</div>
            </div>
            <div class="row-md vertical-spacer">
              <div class="col-md-12">Rolle: {{ $role_name }}</div>
            </div>
            <div class="row-md vertical-spacer">
              <div class="col-md-12">angemeldet seit: {{ $user->created_at }} </div>
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
            <div class="col-md-12">
              <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
            </div>
          </div>
        </form>
        </div>
      </div>

    </div>
</main>
@endsection