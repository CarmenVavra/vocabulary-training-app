<div id="overlay-profile">
    <div id="overlay-profile-container">
      <div id="close">X</div>
      <div class="alert bg-turkis">
        <div id="card-content">
          <div class="card-header bg-darkgray">
            DEIN PROFIL
          </div>
          @if(!empty(Auth::user()))
          <div class="card-body">
            <p class="card-text"><strong>Name:</strong>  {{ Auth::user()->name }} </p>
            <p class="card-text"><strong>E-Mail:</strong> {{ Auth::user()->email }} </p>
            <hr>
            <p class="card-text"><strong>Sprache:</strong>  {{ session('language_name') }} </p>
            <p class="card-text"><strong>Fremdsprache:</strong> {{ session('foreign_name') }} </p>
            <hr>
            <p class="card-text"><strong>angemeldet seit:</strong> {{ Auth::user()->created_at }}</p>
            <p class="card-text"><strong>letzter Login:</strong> {{ Auth::user()->last_login }}</p>
            <hr>
            <a href="#" id="btnProfileClose" class="btn btn-turkis">OK</a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
