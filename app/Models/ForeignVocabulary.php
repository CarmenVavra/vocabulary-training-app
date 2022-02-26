<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignVocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'language_id', 
        'vocabulary_id', 
        'marker_id'
    ];

    /**
     * foreignkey constraints
     * 
     * @return \Illuminate\Http\Response
     */
    public function vocabularies(){
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id', 'id');
    }
}
