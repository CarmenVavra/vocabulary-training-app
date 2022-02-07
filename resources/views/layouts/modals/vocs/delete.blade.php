<div id="overlay-delete" @if(!empty(session('vocDelete'))) style="display:block;" @endif>
    <div id="overlay-delete-container">
      <div id="close">X</div>
      <div class="alert green-bg">
        <div class="row">
          <div class="col-md">
            Möchtest du die Vokabeln wirklich löschen?<br>
            Dieser Vorgang kann nicht mehr rückgängig gemacht werden!
          </div>
        </div>
        <div class="row">
          <div class="col-md">
            <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
          </div>
        </div>
        
<!--  {{--        <form class="row g-3" action="{{ route('vocabulary.delete') }}" method="post">
            @csrf
          <div class="col-md-6">
            <label for="{{ session('language_name') }}" class="form-label">{{ session('language_name') }}</label>
            <input type="text" class="form-control @error('firstLangNew') is-invalid @enderror" id="{{ session('language_name') }}" name="firstLangNew" value="{{ old('firstLangNew')}}" required minlength="2">
            <div class="invalid-feedback">Das Feld <italic>{{ session('language_name') }}</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-md-6">
            <label for="{{ session('foreign_name') }}" class="form-label">{{ session('foreign_name') }}</label>
            <input type="text" class="form-control @error('secondLangNew') is-invalid @enderror" id="{{ session('foreign_name') }}" name="secondLangNew" value="{{ old('secondLangNew')}}" required minlength="2">
            <div class="invalid-feedback">Das Feld <italic>{{ session('foreign_name') }}</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-12">
            <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
          </div>
        </form> --}}
 -->      
      </div>
    </div>
  </div>
