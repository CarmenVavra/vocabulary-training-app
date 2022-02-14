@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<main>
    <div class="alert dark-bg">
      <form class="row g-3" action="{{ route('admin.update', $user->id) }}" method="post">
          @csrf
          @method('put')
        <div class="col-md-6">
          {{ $user->name }}
        </div>
        <div class="col-md-6">
          {{ $user->email }}
        </div>
        <div class="col-md-6">
          <label for="userRole" class="form-label">Rolle</label>
          <input type="text" class="form-control" id="userRole" name="role_id" value="{{ $user->role_id }}" required minlength="2">
          <div class="text-danger">Das Feld <italic>Rolle</italic> darf nicht leer sein!</div>
        </div>
        <div class="col-12">
          <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
        </div>
      </form>
    </div>
</main>
@endsection