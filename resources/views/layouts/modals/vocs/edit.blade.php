
<div id="overlay-edit-language" style="display:block;">
  <div id="overlay-edit-language-container">
    <div class="alert">
      <form autocomplete="off" class="row g-3" action="{{ route('vocabulary.update', $vocabulary->vid) }}" method="post">
          @csrf
          @method('put')
        <div class="col-md-6">
          <label for="{{ $vocabulary->vid }}_vEdit" class="form-label">{{ session('language_name') }}</label>
          <input type="text" class="form-control  @error('firstLangEdit') is-invalid @enderror" data-id="vEdit" id="{{ $vocabulary->vid }}_vEdit" name="firstLangEdit" value="{{ $vocabulary->vn }}" required minlength="2">
        <div class="invalid-feedback">Das Feld <italic>{{ session('language_name') }}</italic> darf nicht leer sein!</div>
        </div>
        <div class="col-md-6">
          <label for="{{ $vocabulary->fvid }}_fvEdit" class="form-label">{{ session('foreign_name') }}</label>
          <input type="text" class="form-control  @error('secondLangEdit') is-invalid @enderror" data-id="fvEdit" id="{{ $vocabulary->fvid }}_fvEdit" name="secondLangEdit" value="{{ $vocabulary->fvn }}" required minlength="2">
          
          <div class="invalid-feedback">Das Feld <italic>{{ session('foreign_name') }}</italic> darf nicht leer sein!</div>
          {{-- <div class="invalid-feedback">Das Feld <italic>{{ session('foreign_name') }}</italic> darf nicht leer sein!</div> --}}
        </div>
        <div class="col-12">
          <a href="{{ route('vocabulary.cancel') }}"><button id="btnVocDeleteCancel" class="btn btn-danger" type="button">abbrechen</button></a>
          <button class="btn btn-turkis" type="submit" formnovalidate>ändern</button>
        </div>
      </form>
    </div>
  </div>
</div>
