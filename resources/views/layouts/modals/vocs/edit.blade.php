<!-- Modal -->
<div class="modal fade" id="vocEditModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    
  </div>
</div>





{{-- <div id="overlay-edit-language" @if(session('success') == 'openModal') style="display:block;" @endif>
  <div id="overlay-edit-language-container">
    <div id="close">X</div>
    <div class="alert">
      <form autocomplete="off" class="row g-3" action="{{ route('vocabulary.update', $vocabularies[0]->vid) }}" method="post">
          @csrf
          @method('put')
        <div class="col-md-6">
          <label for="{{ $vocabularies[0]->vid }}_vEdit" class="form-label">{{ session('language_name') }}</label>
          <input type="text" class="form-control is-invalid" data-id="vEdit" id="{{ $vocabularies[0]->vid }}_vEdit" name="firstLangEdit" value="{{ $vocabularies[0]->vn }}" required minlength="2">
          
          <div id="resultV" class="box-suggestions">
            <ul class="hide">
              
            </ul>
          </div>

        <div class="invalid-feedback">Das Feld <italic>{{ session('language_name') }}</italic> darf nicht leer sein!</div>
        </div>
        <div class="col-md-6">
          <label for="{{ $vocabularies[0]->fvid }}_fvEdit" class="form-label">{{ session('foreign_name') }}</label>
          <input type="text" class="form-control is-invalid" data-id="fvEdit" id="{{ $vocabularies[0]->fvid }}_fvEdit" name="secondLangEdit" value="{{ $vocabularies[0]->fvn }}" required minlength="2">
          
          <div id="resultFV" class="box-suggestions">
            <ul class="hide">
              
            </ul>
          </div>
          
          <div class="invalid-feedback">Das Feld <italic>{{ session('foreign_name') }}</italic> darf nicht leer sein!</div>
        </div>
        <div class="col-12">
          <button class="btn btn-turkis" type="submit" formnovalidate>senden</button>
        </div>
      </form>
    </div>
  </div>
</div> --}}