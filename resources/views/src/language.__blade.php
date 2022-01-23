    @extends('layouts.main')
    @section('css')
      <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
      <link rel="stylesheet" href="{{ asset('css/language.css') }}">
    @endsection
    @section('content')
      <!-- MODAL START -->
      <div id="overlay-select-language">
        <div id="overlay-select-language-container">
          <div class="alert bg-darkgray">
            <div id="card-content">
              <div class="card-body">
                <h5 class="card-title">language Blade - Wähle deine Fremdsprache</h5>
                <div class="row">

                  <div class="col">
                    <form action="{{ route('language.setCookie') }}" method="post" id="languageForm">
                      @csrf
                      <div class="row">
                        <div class="col-md-12">
                          <select class="form-select" id="foreignLanguage" name="foreignLanguage" required>
                            <option selected disabled value="">wähle eine Sprache</option>

                                @foreach($languages as $language)
                                    <option value="{{ $language->short_name }}">{{ $language->name }}</option>
                                @endforeach

                          </select>
                          @error('foreignLanguage')
                          <div class="alert alert-danger">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>

                      </div>
                      <div class="row btn-group vertical-spacer">
                        <div class="col-md-4">
                          <<a href="{{-- route('logout') --}}">
                            <button id="btnSelectLanguagesCancel" class="btn btn-danger">Logout</button>
                          </a>
                        </div>
                        <div class="col-md-4">
                          <button id="btnSelectLanguages" class="btn btn-darkgray">OK</button>
                        </div>
                        <div class="col-md-4">
                            <a href="{{-- route('language.create') --}}"><button id="btnSelectLanguagesNew" class="btn btn-success">Neu</button></a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>

                <hr class="bg-darkgray">
                <div id="addNewLanguage" class="row">
                  <div class="col">
                    <form method="post" action="{{ route('language.store') }}">
                      @csrf
                      <div class="row">
                        <div class="col-md-12">
                          <input type="text" name="name" id="newLanguage" value="" placeholder="Sprache" />
                          @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                          <input type="hidden" value="@php Auth::user()->id @endphp" />
                        </div>
{{--                         <div class="col-md-6">
                          <input type="text" name="short_name" id="newLanguageShortName" value="" placeholder="Kurzform" />
                          @error('short_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div> --}}
                      </div>
                      <div class="row vertical-spacer">
                        <div class="col-md">
                          <button type="submit" class="btn btn-success">Hinzufügen</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- MODAL END -->

      <main id="selectLanguagePage">

      </main>
    @endsection
    @section('javascript')
        <script>
            const btnNewLanguage = document.querySelector('#btnSelectLanguagesNew');
            const btnCancelNewLanguage = document.querySelector('#btnSelectLanguagesCancel');

            btnNewLanguage.onclick = function(e){
                e.preventDefault();
            };

/*             btnCancelNewLanguage.onclick = function(e){
                e.preventDefault();
                window.location.href = '{{ route('home') }}';
            }; */

        </script>
    @endsection
