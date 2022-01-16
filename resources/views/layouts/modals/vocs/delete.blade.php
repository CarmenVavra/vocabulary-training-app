<div id="overlay-delete" @if(!empty($errors->all())) style="display:block;" @endif>
    <div id="overlay-delete-container">
      <div id="close">X</div>
      <div class="alert green-bg">

        
        <form class="row g-3" action="{{ route('vocabulary.delete') }}" method="post">
            @csrf
          <div class="col-md-6">
            <label for="deutsch" class="form-label">Deutsch</label>
            <input type="text" class="form-control @error('firstLangNew') is-invalid @enderror" id="deutsch" name="firstLangNew" value="{{ old('firstLangNew')}}" required minlength="2">
            <div class="invalid-feedback">Das Feld <italic>Deutsch</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-md-6">
            <label for="spanisch" class="form-label">Spanisch</label>
            <input type="text" class="form-control @error('secondLangNew') is-invalid @enderror" id="spanisch" name="secondLangNew" value="{{ old('secondLangNew')}}" required minlength="2">
            <div class="invalid-feedback">Das Feld <italic>Spanisch</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-12">
            <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
          </div>
        </form>
      </div>
    </div>
  </div>
