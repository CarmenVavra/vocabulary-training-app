<?php
namespace App\Http\Traits;

use App\Models\Vocabulary;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait FilterTrait{
  protected array $dateRange;
  protected array $difficulyLevel;
  protected $fromDate;
  protected $toDate;
  protected string $direction;
  protected string $sortOrder;

  public function __construct(Request $request){
      $this->dateRange[] = explode(' - ', $request->daterange);
      //$this->difficulyLevel = $request->difficultyLevel;
      $this->direction = $request->direction;
      $this->sortOrder = $request->sortOrder;
  }

  public function filterSelect(){
      
      $this->fromDate = DateTime::createFromFormat('m/d/Y', $this->dateRange[0]);
      $error = DateTime::getLastErrors();
      if( $error['warning_count'] == 0 && $error['error_count'] == 0 ){
          $this->fromDate->format('Y-m-d');
      }
      else{
          echo 'Hier ist ein Fehler passiert';
      }

      $this->toDate = DateTime::createFromFormat('m/d/Y', $this->dateRange[1]);
      $error = DateTime::getLastErrors();
      if( $error['warning_count'] == 0 && $error['error_count'] == 0 ){
          $this->toDate->format('Y-m-d');
      }
      else{
          echo 'Hier ist ein Fehler passiert';
      }

      if($this->sortOrder != 'random'){
          $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                      ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                      ->where('vocabularies.user_id', Auth::user()->id)
                                      ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                      ->whereBetween('foreign_vocabularies.created_at', [$this->fromDate, $this->toDate])
                                      ->orderBy('vocabularies.name', $this->sortOrder)->get();
      }else{
          $vocabularies = Vocabulary::join('foreign_vocabularies', 'vocabularies.id', '=', 'foreign_vocabularies.vocabulary_id')
                                      ->select('vocabularies.name as vn', 'foreign_vocabularies.name as fvn')
                                      ->where('vocabularies.user_id', Auth::user()->id)
                                      ->where('foreign_vocabularies.language_id', session('foreign_id'))
                                      ->whereBetween('foreign_vocabularies.created_at', [$this->fromDate, $this->toDate])->get();
      }


  }


}



