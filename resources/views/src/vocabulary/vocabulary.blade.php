
@extends('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/vokabel.css') }}">
@endsection
@section('content')

  <div id="breadcrumb" aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('vocabulary.index') }}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><strong>Vokabeln</strong></li>
    </ol>
  </div>
  <main>
    <div class="container">
      <div class="alert turkis-bg" role="alert">
        <h4 class="alert-heading">Vokabel</h4>
          <form action="{{ route('upload.csv') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <label for="formFile" class="form-label">Vokabel über CSV hochladen</label>
                <input class="form-control" name="upload" type="file" id="formFileUpload">
                @if(!empty(session('error')))
                  <div class="text-danger">{{ session('error') }}</div>
                @endif
              </div>
              <div class="col-md-6">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="direction" id="radioVNFVN" value="dir1" checked>
                  <label class="form-check-label" for="radioVNFVN">
                    {{ session('language_name') }} -> {{ session('foreign_name') }}
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="direction" id="radioFVNVN" value="dir2">
                  <label class="form-check-label" for="radioFVNVN">
                    {{ session('foreign_name') }} -> {{ session('language_name') }}
                  </label>
                </div>
              </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button class="btn btn-darkgray me-md-2" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                </svg> <span class="left-spacer">hochladen</span></button>
            </div>
        </form>
      </div>
    </div>

    @if(!empty(session('success')))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    {{-- MODALS --}}
    @include('layouts.modals.vocs.create')
    
    @if(isset($vocabulary))
      @include('layouts.modals.vocs.edit')
    @endif

    @if(isset($deleteVocabulary))
      @include('layouts.modals.vocs.delete')
    @endif
    {{-- MODALS --}}

    <div class="container">
      <table id="tblVocs" class="table table-striped table-dark table-hover">
        <thead>
          <tr>
            <th>{{ session('language_name') }}</th>
            <th>{{ session('foreign_name') }}</th>
            <th></th>
            <th>
              <button type="button" class="btn btn-success btn-sm btn-new">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
              </button>
            </th>
          </tr>
        </thead>
        <tbody>
          @if(isset($vocabularies))
            @foreach($vocabularies as $vocabulary)
              <tr>
                <td id="v_{{ $vocabulary['vid'] }}" class="language">{{ $vocabulary['vn'] }}</td> {{-- Muttersprache --}}
                <td id="fv_{{ $vocabulary['fvid'] }}" class="language">{{ $vocabulary['fvn'] }}</td> {{-- Fremdsprache --}}
                <td>
                  {{-- dd($vocabulary['vid']) --}}
                  <a href="{{ route('vocabulary.edit', $vocabulary['vid'] ) }}" data-toggle="modal" data-target="#overlay-edit-language"><button type="button" class="btn btn-info btn-sm btn-edit">
                    {{-- <a href="{{ route('vocabulary.edit', $vocabulary['vid'] ) }}" data-toggle="modal" data-target="#overlay-edit"><button type="button" class="btn btn-info btn-sm btn-edit"> --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                      <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                    </svg>
                  </button></a>
                </td>
                <td>
                  <form action="{{ route('vocabulary.warn.delete', $vocabulary['vid'] ) }}" method="post">
                      @csrf
                      @method('delete')
                      
                      <button type="submit" class="btn btn-danger btn-sm btn-delete">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                          </svg>
                      </button>
                  </form>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </main>
  @endsection
  @section('javascript')


    <script>
    "use strict";
    const buttons = document.querySelectorAll('#tblVocs .btn');
    const closeVoc = document.querySelector('#overlay-container');
    let vokHomeModal = new Modal(document.querySelector('#overlay'));
    let deleteModal = new Modal(document.querySelector('#overlay-delete'));

    for (let button of buttons) {
      button.onclick = function(e) {
        //e.preventDefault();
        //console.log('e.target', e.target);
        if(e.target.parentElement.classList.contains('btn-new') || e.target.classList.contains('btn-new')){
          vokHomeModal.openModal('new');
        }/* else if(e.target.parentElement.classList.contains('btn-edit')){
          vokHomeModal.openModal('edit');
        }  *//*else if(e.target.parentElement.classList.contains('btn-delete')){
          deleteModal.openModal('delete');
        } */
      }
    }



    const contentV = document.querySelector('#resultV ul');
    const contentFV = document.querySelector('#resultFV ul');
    let searchString;
    let listElement;
  
    let inputFieldVocabulary = document.querySelector('input[id$=vNew]');
    if(inputFieldVocabulary != null){

      let inputFieldForeign = document.querySelector('input[id$=fvNew]');
    
    
      inputFieldVocabulary.onkeyup = function(e){
        searchString = inputFieldVocabulary.value;

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type:'GET',
          url:"/vocabularyautocomplete",
          datatype:"json",
          data:{searchString:searchString},
          success:function(data){
            contentV.innerHTML = '';
            //console.log(data.input.vn);


            if(data.input.vn != ''){
              contentV.classList.remove('hide');
            }else{
              contentV.classList.add('hide');
            }



            for (let dataRow of data.input) {
              contentV.insertAdjacentHTML('beforeend', '<li data-fvn="' + dataRow.fvn + '">' + dataRow.vn + '</li>');

              listElement = document.querySelectorAll('#resultV ul li');
              listElement.forEach(function(value, index){
                value.onclick = function(liElem){
                  contentV.classList.add('hide');
                  inputFieldVocabulary.value = liElem.target.textContent;
                  inputFieldForeign.value = liElem.target.getAttribute('data-fvn')
                }
              });

            }         
          }
          
        });

      }

      inputFieldForeign.onkeyup = function(e){
        searchString = inputFieldForeign.value;

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type:'GET',
          url:"/foreignautocomplete",
          datatype:"json",
          data:{searchString:searchString},
          success:function(data){
            contentFV.innerHTML = '';
            console.log(data.input.fvn);


            if(data.input.fvn != ''){
              contentFV.classList.remove('hide');
            }else{
              contentFV.classList.add('hide');
            }

            for (let dataRow of data.input) {
              console.log(dataRow.fvn);
              contentFV.insertAdjacentHTML('beforeend', '<li data-vn="' + dataRow.vn + '">' + dataRow.fvn + '</li>');

              listElement = document.querySelectorAll('#resultFV ul li');
              listElement.forEach(function(value, index){
                value.onclick = function(liElem){
                  contentFV.classList.add('hide');
                  inputFieldForeign.value = liElem.target.textContent;
                  //::Peter:: ich würde auch das zweite input befüllen
                  inputFieldVocabulary.value = liElem.target.getAttribute('data-vn')
                }
              });

            }         
          }
          
        });

      }  
      
    
    }
    










    closeVoc.onclick = function(e) {
      if (e.target.id == 'overlay-container' || e.target.id == 'close') {
        vokHomeModal.closeModal();
      }
    };

  </script>
@endsection
