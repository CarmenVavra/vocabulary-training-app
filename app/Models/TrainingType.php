<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name'
    ];

    /**
     * foreignkey constraints
     * 
     * @return \Illuminate\Http\Response
     */
    public function training()
    {
        return $this->hasMany(Training::class, 'training_type_id', 'id');
    }
}
