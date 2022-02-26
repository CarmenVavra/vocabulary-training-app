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

     /**
     * foreignkey constraints
     * 
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * foreignkey constraints
     * 
     * @return \Illuminate\Http\Response
     */    
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    /**
     * foreignkey constraints
     * 
     * @return \Illuminate\Http\Response
     */
    public function foreignVocabularies(){
        return $this->belongsToMany(ForeignVocabulary::class, 'id', 'vocabulary_id');
    }
}
