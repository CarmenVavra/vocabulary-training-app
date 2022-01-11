<div id="overlay-edit">
    <div id="overlay-edit-container">
      <div id="close">X</div>
      <div class="alert">
        <form class="row g-3" action="{{-- {{ route('vocabulary.update') }} --}}" method="post">
            @csrf
          <div class="col-md-6">
            <label for="deutsch" class="form-label">Deutsch</label>
            <input type="text" class="form-control is-invalid" id="deutschEdit" name="firstLangEdit" value="{{-- {{ $vocabulary }} --}}" required minlength="2">
            <div class="invalid-feedback">Das Feld <italic>Deutsch</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-md-6">
            <label for="spanisch" class="form-label">Spanisch</label>
            <input type="text" class="form-control is-invalid" id="spanischEdit" name="secondLangEdit" value="" required minlength="2">
            <div class="invalid-feedback">Das Feld <italic>Spanisch</italic> darf nicht leer sein!</div>
          </div>
          <div class="col-12">
            <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
          </div>
        </form>
      </div>
    </div>
  </div>
