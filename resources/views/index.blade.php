<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link id="style-css" rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link id="index-css" rel="stylesheet" href="{{ asset('css/index.css') }}">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <title>Caryssa - Vokabeltrainer</title>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-darkgray">
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarContent"
          aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarContent">
          <a class="navbar-brand mt-2 mt-lg-0" href="<?php $_SERVER['PHP_SELF']; ?>">
            CARYSSA - DEIN VOKABELTRAINER
          </a>
        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="container login-container">
      <div class="row">
        <div class="col-md-6 login-form-1">
          <form action="{{ route('login') }}" method="post">
            @csrf
            <h3>Login</h3>
            <div class="form-group">
              <input type="text" name="email" class="form-control is-invalid" placeholder="E-Mail" value="" />

              <div class="invalid-feedback">Login ungültig</div>
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control is-invalid" placeholder="Passwort" value="" />
              <div class="invalid-feedback">Login ungültig</div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-turkis" value="Login">Login</button>
            </div>
            <div class="form-group">
              <a href="#" class="btnForgetPwd">Passwort vergessen?</a>
            </div>
          </form>
        </div>

        <div class="col-md-6 login-form-2">
          <form action="{{ route('user.store') }}" method="post">
            @csrf
            <h3>Registrierung</h3>
            <div class="form-group">
              <input type="text" name="name" class="form-control is-invalid" placeholder="Name" value="" />
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="text" name="email" class="form-control is-invalid" placeholder="E-Mail" value="" />
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control is-invalid" placeholder="Passwort" value="" />
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control is-invalid" placeholder="Passwort wiederholen" value="" />
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-darkgray" value="Registrieren">Registrieren</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </main>

  @include('inc.footer')

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


</body>

</html>
