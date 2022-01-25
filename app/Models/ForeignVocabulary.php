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
        'vocabulary_id'
    ];

    public function vocabularies(){
        return $this->belongsTo(Vocabulary::class, 'vocabulary_id', 'id');
    }
}
