<header>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-darkgray">
    <!-- Container wrapper -->
    <div class="container-fluid">
      <!-- Toggle button -->
      <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Collapsible wrapper -->
      <div class="collapse navbar-collapse" id="navbarContent">
        <!-- Navbar brand -->
        <a class="navbar-brand mt-2 mt-lg-0" href="#">
          CARYSSA - DEIN VOKABELTRAINER
        </a>
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a id="nav_1" class="nav-link" href="#">Vokabel</a>
          </li>
          <li class="nav-item">
            <a id="nav_2" class="nav-link" href="#">Training</a>
            <div class="dropdown-menu">
              <a id="nav_2_1" class="dropdown-item" href="/learning">Lernen</a>
              <a id="nav_2_2" class="dropdown-item" href="/quiz">Quiz</a>
              <a id="nav_2_3" class="dropdown-item" href="/hangman">Hangman</a>
              <a id="nav_2_4" class="dropdown-item" href="/pair">Pairs</a>
            </div>
          </li>
          <li class="nav-item">
            <a id="nav_3" class="nav-link" href="#">Dashboard</a>
          </li>
        </ul>
      </div>
      <!-- Right elements -->
      <div class="d-flex align-items-center btn-group" role="group">
        <!-- Avatar -->
        <div class="dropdown">
          <button class="btn btn-turkis dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="http://localhost:8000/img/user_icon3_klein.png" height="25" alt="" loading="lazy" />
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a id="profile" class="dropdown-item" href="#">Profil</a>
            <a id="edit" class="dropdown-item" href="#">Daten ändern</a>
            <a class="dropdown-item" href="http://localhost:8000/index.php">Logout</a>
          </div>
        </div>
        <div class="logout">
          <a href="http://localhost:8000/index.php"><img src="http://localhost:8000/img/logout_icon.png" class="logout-icon" alt="" /></a>
        </div>
      </div>

    </div>
  </nav>
</header>
<!-- modal -->
<div id="overlay-profile">
  <div id="overlay-profile-container">
    <div id="close">X</div>
    <div class="alert bg-turkis">
      <div id="card-content">
        <div class="card-body">
          <h5 class="card-title">Dein Profil</h5>
          <p class="card-text">Name: $name</p>
          <p class="card-text">E-Mail: $email</p>
          <p><small>Rolle: $role</small></p>
          <hr>
          <p class="card-text">angemeldet seit: $date</p>
          <p class="card-text">letzter Login: $date</p>
          <hr>
          <button class="btn btn-turkis">OK</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal -->

<!-- modal -->
<div id="overlay-edit">
  <div id="overlay-edit-container">
    <div id="close">X</div>
    <div class="alert bg-turkis">
      <div id="card-content">
        <div class="card-body">
          <h5 class="card-title">Daten ändern</h5>
          <div class="col-md-12 login-form-2">
            <form action="" method="post">
              <div class="form-group">
                <input type="text" class="form-control is-invalid" placeholder="Name" value="" />
                <div class="invalid-feedback">Name darf nicht leer sein!</div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control is-invalid" placeholder="E-Mail" value="" />
                <div class="invalid-feedback">E-Mail darf nicht leer sein!</div>
              </div>
              <div class="form-group">
                <input type="password" class="form-control is-invalid" placeholder="Passwort" value="" />
                <div class="invalid-feedback">Passwort darf nicht leer sein!</div>
              </div>
              <div class="form-group">
                <input type="password" class="form-control is-invalid" placeholder="Passwort wiederholen" value="" />
                <div class="invalid-feedback">Passwort Wdh darf nicht leer sein!</div>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-darkgray" value="ändern">ändern</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- modal -->



<script src="http://localhost:8000/js/classes/Modal.js"></script>
<script>
  const buttonProfile = document.querySelector('#profile');
  const closeProfile = document.querySelector('#overlay-profile-container');
  const buttonOk = document.querySelector('#overlay-profile button');
  let profileModal = new Modal(document.querySelector('#overlay-profile'));

  buttonProfile.onclick = function(e) {
    e.preventDefault();
    buttonProfile.parentElement.style.display = 'none';
    profileModal.openModal();
  };

  closeProfile.onclick = function(e) {
    if (e.target.id == 'overlay-profile-container' || e.target.id == 'close') {
      profileModal.closeModal();
    }
  };

  buttonOk.onclick = function(e) {
    profileModal.closeModal();
  };

  const btnEdit = document.querySelector('#edit');
  const closeEdit = document.querySelector('#overlay-edit-container');
  const btnEditSend = document.querySelector('#overlay-edit button');
  let editModal = new Modal(document.querySelector('#overlay-edit'));

  btnEdit.onclick = function(e) {
    e.preventDefault();
    btnEdit.parentElement.style.display = 'none';
    editModal.openModal();
  }

  closeEdit.onclick = function(e) {
    if (e.target.id == 'overlay-edit-container' || e.target.id == 'close') {
      editModal.closeModal();
    }
  };

  btnEditSend.onclick = function(e) {
    profileModal.closeModal();
  };
</script>
