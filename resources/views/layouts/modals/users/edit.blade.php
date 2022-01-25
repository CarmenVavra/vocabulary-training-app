<div id="overlay-edit" @if(!empty($errors->all())) style="display:block;" @endif>
    <div id="overlay-edit-container">
      <div id="close">X</div>
      <div class="alert bg-turkis">
        <div id="card-content">
          <div class="card-body">
            <h5 class="card-title">Daten ändern</h5>
            <div class="col-md-12 login-form-2">
              <form action="{{ route('user.update', Auth::user()->id) }}" method="post">
                @csrf
                @method('put');
                <div class="form-group">
                  <input name="name" type="text" class="form-control is-invalid" placeholder="Name" value="{{ Auth::user()->name }}" />
                  <div class="invalid-feedback">Name darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <input name="email" type="text" class="form-control is-invalid" placeholder="E-Mail" value="{{ Auth::user()->email }}" />
                  <div class="invalid-feedback">E-Mail darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <input name="password" type="password" class="form-control is-invalid" placeholder="Passwort" value="" />
                  <div class="invalid-feedback">Passwort darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <input name="password" type="password" class="form-control is-invalid" placeholder="Passwort wiederholen" value="" />
                  <div class="invalid-feedback">Passwort Wdh darf nicht leer sein!</div>
                </div>
                <div class="form-group">
                  <button id="btnEditUser" type="submit" class="btn btn-darkgray" value="ändern">ändern</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>