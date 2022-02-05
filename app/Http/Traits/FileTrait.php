<?php

namespace App\Http\Traits;

use Exception;

trait FileTrait{

    public function setDir(string $dir, int $mode=0755 ){
        $dir = $this->sanatize($dir);
        if( !is_dir($dir)){
            mkdir($dir,$mode,true);
        }
        return $dir;
    }

    public function sanatize(string $dir){
        $patter = '|[^a-z0-9_\-\.\/]|i';
        return preg_replace($patter,'',$dir);
    }

    public function getFilename(string $file, $overwrite=false){
        $file = $this->sanatize($file);
        $fileInfo = pathinfo($file);
        
        if( !isset($fileInfo['extension'])){
            throw new Exception('Hierbei handelt es ich um keine Datei!');
        }
        
        if( $overwrite || !file_exists($file) ) return $file;

        $counter = 1;
        while( file_exists($file) ){
            $file = $fileInfo['dirname'].'/'.$fileInfo['filename'].'_'.$counter.'.'.$fileInfo['extension'];
            $counter++;
        } 
        return $file;
    }
}