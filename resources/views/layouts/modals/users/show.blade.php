<div id="overlay-profile" @if(!empty($errors->all())) style="display:block;" @endif>
    <div id="overlay-profile-container">
      <div id="close">X</div>
      <div class="alert bg-turkis">
        <div id="card-content">
          <div class="card-body">
            <h5 class="card-title">Dein Profil</h5>
            <p class="card-text">Name:  {{ Auth::user()->name }} </p>
            <p class="card-text">E-Mail: {{ Auth::user()->email }} </p>
            <hr>
            <p class="card-text">angemeldet seit: {{ Auth::user()->created_at }}</p>
            <p class="card-text">letzter Login: {{ Auth::user()->last_login }}</p>
            <hr>
            <a href="#" id="btnProfileClose" class="btn btn-turkis" >OK</a>
          </div>
        </div>
      </div>
    </div>
  </div>
