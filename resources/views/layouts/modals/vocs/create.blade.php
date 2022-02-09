<div id="overlay"  @if(!empty($errors->all())) style="display:block;" @endif>
    <div id="overlay-container">
      <div id="close">X</div>
      <div class="alert green-bg">
        <form autocomplete="off" class="row g-3" action="{{ route('vocabulary.store') }}" method="post">
            @csrf
            <div class="col-md-6">
            <label for="{{ session('language_name') }}" class="form-label">{{ session('language_name') }}</label>
            <input type="text" class="form-control @error('firstLangNew') is-invalid @enderror" id="{{ session('language_name') }}_vNew" name="firstLangNew" value="{{ old('firstLangNew')}}" required minlength="2">
            
            <div id="resultV" class="box-suggestions">
              <ul class="hide">
                
              </ul>
            </div>
            
            <div class="invalid-feedback">Das Feld <italic>{{ session('language_name') }}</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-md-6">
            <label for="{{ session('foreign_name') }}" class="form-label">{{ session('foreign_name') }}</label>
            <input type="text" class="form-control @error('secondLangNew') is-invalid @enderror" id="{{ session('foreign_name') }}_fvNew" name="secondLangNew" value="{{ old('secondLangNew')}}" required minlength="2">
            
            <div id="resultFV" class="box-suggestions">
              <ul class="hide">
                
              </ul>
            </div>
            
            <div class="invalid-feedback">Das Feld <italic>{{ session('foreign_name') }}</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-12">
            <a href="{{ route('vocabulary.cancel') }}"><button id="btnVocDeleteCancel" class="btn btn-danger" type="button">abbrechen</button></a>
            <button class="btn btn-turkis" type="submit" formnovalidate>anlegen</button>
          </div>
        </form>
      </div>
    </div>
  </div>
