<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_type_id',
        'language_id',
        'language_lernen_id',
        'highscore'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class, 'training_type_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function languageLernen()
    {
        return $this->belongsTo(Language::class, 'language_lernen_id', 'id');
    }
}
