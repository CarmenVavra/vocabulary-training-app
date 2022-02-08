<div id="overlay-delete" style="display:block;">
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
            
            <form action="{{ route('vocabulary.delete', $deleteVocabulary->vid) }}" method="post">
              @csrf
              @method('delete')
              <a href="{{ route('vocabulary.delete.cancel') }}"><button id="btnVocDeleteCancel" class="btn btn-danger" type="button">abbrechen</button></a>
              <button class="btn btn-turkis" type="submit" formnovalidate>löschen</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
