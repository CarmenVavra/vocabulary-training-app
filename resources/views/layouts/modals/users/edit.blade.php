<div id="overlay-edit">
    <div id="overlay-edit-container">
      <div id="close">X</div>
      <div class="alert bg-turkis">
        <div class="card-header bg-darkgray">
          DATEN ÄNDERN
        </div>
        @if(!empty(Auth::user()))
            
        <div id="card-content">
          <div class="card-body">
            <div class="col-md-12 login-form-2">
              <form action="{{ route('user.update', Auth::user()->id) }}" method="post" id="editUserForm">
                @csrf
                @method('put')
                <div class="form-group">
                  <input name="name" type="text" class="form-control" placeholder="Name" value="{{ Auth::user()->name }}" />
                  <div class="text-danger">Name darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <input name="email" type="text" class="form-control" placeholder="E-Mail" value="{{ Auth::user()->email }}" />
                  <div class="text-danger">E-Mail darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <input name="password" type="password" class="form-control" placeholder="Passwort" value="" />
                  <div class="text-danger">Passwort darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <input name="password" type="password" class="form-control" placeholder="Passwort wiederholen" value="" />
                  <div class="text-danger">Passwort Wdh darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <button id="btnEditUser" type="submit" class="btn btn-darkgray" value="ändern">ändern</button>
                </div>

              </form>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>