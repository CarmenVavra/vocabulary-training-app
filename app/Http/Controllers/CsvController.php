<?php

namespace App\Http\Controllers;

use App\Models\ForeignVocabulary;
use App\Models\Vocabulary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use App\Http\Traits\FileTrait;

class CsvController extends Controller
{
    //use FileTrait;
    
    public function uploadContent(Request $request){

        if($request->upload != null){
            $file = $_FILES;
            $pathinfo = pathinfo($_FILES['upload']['name']);

            $filename = $pathinfo['basename'];

            $extension = $pathinfo['extension'];

            $tmpPath = $_FILES['upload']['tmp_name'];
            $fileSize = $_FILES['upload']['size'];

            $this->checkUploadedFileProperties($extension, $fileSize);
            $location = 'uploadsCSV';
            $request->upload->move($location, $filename);
            $filepath = public_path($location.'/'.$filename);
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
           
           $x = 0;
           foreach($dataArray as $data){
             //if(richtung ist deutsch -> fremdsprache){
                $vn = $data[0];
                $fvn = $data[1];

             $x++;
             try{
                $voc = Vocabulary::create([
                    'name'=>$vn,
                    'user_id'=>Auth::user()->id,
                    'language_id'=>session('language_id')
                ]);
                //DB::commit();
                
                ForeignVocabulary::create([
                    'name'=>$fvn,
                    'language_id'=>session('foreign_id'),
                    'vocabulary_id'=>$voc->id

                ]);

                //DB::commit();
             }catch(Exception $e){

             }

           }

        }else{
            // Fehler: Bitte eine Datei auswählen!
        }
        
        return view('src.vocabulary')->with('success', 'Die Daten wurden erfolgreich gespeichert!');
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
