<?php

namespace App\Http\Controllers;

use App\Models\ForeignVocabulary;
use App\Models\Vocabulary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CsvController extends Controller
{    
    public function uploadContent(Request $request){

        //dd($request->direction);

        if($request->upload != null){
            $file = $_FILES;
            $pathinfo = pathinfo($_FILES['upload']['name']);

            $filename = $pathinfo['basename'];
            $extension = $pathinfo['extension'];
            $fileSize = $_FILES['upload']['size'];

            $this->checkUploadedFileProperties($extension, $fileSize);
            $location = 'uploadsCSV';

            $filepath = public_path($location.'/'.$filename);
            if(file_exists($filepath)){
                //exception
                dd('file bereits vorhanden');
            }else{
                $request->upload->move($location, $filename);
            }  
            
            $file = fopen($filepath, 'r');

            $dataArray = [];

            $i = 0;
            while(($filedata = fgetcsv($file, 1000, ';'))){
                $count = count($filedata);

                for($j=0; $j<$count; $j++){
                    $dataArray[$i][] = $filedata[$j];
                }
                $i++;
           }
           fclose($file);
           unlink($filepath);
           
            $x = 0;
            foreach($dataArray as $data){

                if('dir1' == $request->direction){
                    $vn = $data[0];
                    $fvn = $data[1];
                }else if('dir2' == $request->direction){
                    $vn = $data[1];
                    $fvn = $data[0];
                }
                $x++;

                $writeToDB = false;
                $checkVoc = Vocabulary::where('name', $vn)
                                        ->where('user_id', Auth::user()->id)
                                        ->where('language_id', session('language_id'))->first();
                
                if(empty($checkVoc)){
                    $writeToDB = true;
                }else{                    
                    $checkForeign = ForeignVocabulary::where('name', $fvn)
                                                      ->where('vocabulary_id', $checkVoc->id)
                                                      ->where('language_id', session('foreign_id'))->first();

                    if(!empty($checkForeign)){
                        $writeToDB = false;
                        //error 'datensatz bereits vorhanden';
                    }else{
                        $writeToDB = true;
                    }
                }
                
                if($writeToDB){
                    $voc = Vocabulary::create([
                        'name'=>$vn,
                        'user_id'=>Auth::user()->id,
                        'language_id'=>session('language_id')
                    ]);                
                    
                    ForeignVocabulary::create([
                        'name'=>$fvn,
                        'language_id'=>session('foreign_id'),
                        'vocabulary_id'=>$voc->id
                    ]);
                }
            }
            
        }else{
            return back()->with('error', 'Bitte eine Datei auswählen!');
        }
        
        return back()->with('success', 'Die Daten wurden erfolgreich gespeichert!');
    }

    public function checkUploadedFileProperties($extension, $fileSize){
        $maxFileSize = 2097152;

        if(strtolower($extension) == 'csv'){
            if($fileSize > $maxFileSize){
                throw new Exception('das File ist zu groß!', 413);
            }
        }
    }


}
