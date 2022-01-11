<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'language_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    /* ::Peter:: Eloquent Abfrage mit Pivot Tabelle */
    public function vocabularies(){
        return $this->belongsToMany(Vocabulary::class,'vocabulary_vocabularies','vocabulary_id','vocabulary_learn_id');
    }
}
