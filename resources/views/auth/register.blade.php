@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrierung') }}</div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <div>
                            <strong><a href="" id="registerInfoHeader">Informationen zu deinen Daten >> </a></strong>
                        </div>                        
                        <div id="registerInfoBody">
                            <hr>
                            <ul>
                                <li>Die E-Mail Adresse muss nicht zwingend echt sein. Man kann nur dann kein neues Passwort anfordern.</li>
                                <li>Das Passwort wird einwegverschlüsselt, dh. es kann nicht entschlüsselt werden und wird zu keiner Zeit im Klartext gespeichert.</li>
                                <li>Die eingegebenen Daten werden nicht an Dritte weitergegeben und nicht zu Werbezwecke verwendet.</li>
                                <li>Die Ausgangssprache ist einmal zu wählen und kann dann nicht mehr geändert werden.<br>Neue Ausgangssprache = neuer User</li>
                                <li>Jeder User kann seinen eigenen Account mit allen zugehörigen Daten löschen.</li>
                            </ul>                            
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <a href="{{ asset('pdf/Caryssa_Projekthandbuch.pdf') }}" target="_blank" class="btn btn-warning">Benutzerhandbuch</a>
                        </div>
                        <div class="col-md-4 d-md-flex justify-content-md-end">
                            <strong>Vokabeln als CSV downloaden:</strong>
                        </div>
                        <div class="col-md-3 d-grid gap-1 d-md-flex justify-content-md-end">
                            <a href="{{ asset('csv/deutsch_englisch.csv') }}" target="_blank" class="btn btn-success">DE -> EN</a>
{{--                         </div>
                        <div class="col-md"> --}}
                            <a href="{{ asset('csv/englisch_deutsch.csv') }}" target="_blank" class="btn btn-success">EN -> DE</a>
                        </div>
                    </div>
                    <div class="row" style="margin-top:20px">
                        <div class="col-md">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Adresse') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Passwort') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Passwort wiederholen') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="userLanguage" class="col-md-4 col-form-label text-md-end">{{ __('Ausgangs-Sprache') }}
                                        <button type="button" id="lblUserLanguage" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Basissprache, Muttersprache - kann nicht mehr geändert werden!">
                                            <strong>?</strong>
                                        </button>
                                    </label>

                                    <div class="col-md-6">
                                        <input id="userLanguage" type="text" class="form-control" name="user_language" required autocomplete="new-language">
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Registrieren') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <a href="{{ route('impressum.show') }}" target="_blank">Impressum</a> | <a href="{{ route('datenschutz.show') }}" target="_blank">Datenschutzbestimmungen</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
