<div id="overlay-delete" style="display:block;">
  <div id="overlay-delete-container">
    <div class="alert red-bg">
      <div class="row">
        <div class="col-md">
          Möchtest du den Benutzer wirklich löschen?<br>
          Dieser Vorgang kann nicht mehr rückgängig gemacht werden!
        </div>
      </div>
      <div class="row">
        <div class="col-md">
          <form action="{{ route('user.delete', $deleteUser->id) }}" method="post">
            @csrf
            @method('delete')
            <a href="{{ route('user.cancel') }}" class="btn btn-danger">abbrechen</a>
            <button class="btn btn-turkis" type="submit" formnovalidate>löschen</button>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>