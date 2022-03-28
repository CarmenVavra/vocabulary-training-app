@extends('layouts.main')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('css/language.css') }}">
@endsection
@section('content')
  <!-- MODAL START -->
  <div id="overlay-select-language">
    <div id="overlay-select-language-container">
      <div class="alert bg-darkgray">
        <div id="card-content">
          <div class="card-body">
            <h5 class="card-title">Account von <strong>{{ Auth::user()->email }}</strong> löschen</h5>
            <div class="row">
              <div class="col">
                <form action="{{ route('account.delete', Auth::user()->id) }}" method="post" id="formAccountDelete">
                  @csrf
                  @method('delete')
                  <div class="row">
                    <div class="col">
                      <p>Wenn sie auf löschen klicken, wird der Account von <strong>{{ Auth::user()->email }}</strong> mit ALLEN Daten gelöscht!</p>
                      <p>Dieser Vorgang kann nicht mehr rückgängig gemacht werden!</p>
                    </div>
                  </div>
                  <div class="row btn-group vertical-spacer">
                    <div class="col-md-6">
                      <a onclick="javascript:history.back();" class="btn btn-turkis" id="accountDeleteCancel">Abbrechen</a>
                    </div>
                    <div class="col-md">
                        <button type="submit" class="btn btn-danger">Löschen</button>
                    </div>
                  </div>                      
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- MODAL END -->
@endsection

