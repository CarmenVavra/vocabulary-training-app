<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @yield('css')
</head>

<body>
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
          <a class="navbar-brand mt-2 mt-lg-0" href="{{ route('welcome.index') }}">
            CARYSSA - DEIN VOKABELTRAINER
          </a>
          <!-- Left links -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a id="nav_1" class="nav-link" href="{{ route('vocabulary.index') }}">Vokabel</a>
            </li>
            <li class="nav-item">
              <a id="nav_2" class="nav-link" href="{{ route('training.index') }}">Training</a>
              <div class="dropdown-menu">
                <a id="nav_2_1" class="dropdown-item" href="{{ route('learning.index') }}">Lernen</a>
                <a id="nav_2_2" class="dropdown-item" href="{{ route('quiz.index') }}">Quiz</a>
                <a id="nav_2_3" class="dropdown-item" href="{{ route('hangman.index') }}">Hangman</a>
                <a id="nav_2_4" class="dropdown-item" href="{{ route('pair.index') }}">Pairs</a>
              </div>
            </li>
            <li class="nav-item">
              <a id="nav_3" class="nav-link" href="{{ route('dashboard.index') }}">Dashboard</a>
            </li>
          </ul>
        </div>
        <!-- Right elements -->
        <div class="d-flex align-items-center btn-group" role="group">
          <!-- Avatar -->
          <div class="dropdown">
            <button class="btn btn-turkis dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="{{ asset('img/user_icon3_klein.png') }}" height="25" alt="" loading="lazy" />
            </button>
            <div id="dropdownUser" class="dropdown-menu" aria-labelledby="dropdownMenuButton">

              <a id="profile" class="dropdown-item" href="{{ route('user.show', Auth::user()->id) }}">Profil</a>
              <a id="userEdit" class="dropdown-item" href="{{ route('user.edit', Auth::user()->id) }}">Daten ändern</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.querySelector('#logout-form').submit();">
               {{ __('Logout') }}
              </a>
            </div>
          </div>
          <div class="logout">
            <button class="btn-logout" onclick="event.preventDefault(); document.querySelector('#logout-form').submit();">
                <img src="{{ asset('img/logout_icon.png') }}" class="logout-icon" alt="" />
            </button>

            <form action="{{ route('logout') }}" method="post" id="logout-form" class="formLogout">
                @csrf
            </form>

          </div>
        </div>

      </div>
    </nav>
  </header>
  <!-- modal profile -->
  @include('layouts.modals.users.show')

  <!-- modal user edit -->
  @include('layouts.modals.users.edit')


    @yield('content')

    <footer class="bg-dark text-center text-white">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright: Ing. Carmen Vavra
        </div>

    </footer>
    <script src="{{ asset('js/classes/Modal.js') }}"></script>
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script src="{{ asset('js/logic.js') }}"></script>
    @yield('javascript')


  <script>
    const closeProfile = document.querySelector('#overlay-profile-container');
    let profileModal = new Modal(document.querySelector('#overlay-profile'));

    closeProfile.onclick = function(e) {
      if (e.target.id == 'overlay-profile-container' || e.target.id == 'close') {
        profileModal.closeModal();
      }
    };

    const closeEdit = document.querySelector('#overlay-edit-container');
    let editModal = new Modal(document.querySelector('#overlay-edit'));

    closeEdit.onclick = function(e) {
      if (e.target.id == 'overlay-edit-container' || e.target.id == 'close') {
        editModal.closeModal();
      }
    };

  </script>


</body>
</html>
