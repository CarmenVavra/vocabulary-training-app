<div id="overlay-delete" style="display:block;">
  <div id="overlay-delete-container">
    <div class="alert red-bg">
      <div class="row">
        <div class="col-md">
          Möchtest du die Sprache wirklich löschen?<br>
          Dieser Vorgang kann nicht mehr rückgängig gemacht werden!
        </div>
      </div>
      <div class="row">
        <div class="col-md">
          
          <form action="{{ route('language.delete', $deleteLanguage->id) }}" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('language.cancel') }}"><button id="btnLangDeleteCancel" class="btn btn-danger" type="button">abbrechen</button></a>
            <button class="btn btn-turkis" type="submit" formnovalidate>löschen</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>