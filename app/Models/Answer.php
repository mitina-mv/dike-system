<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public function answerlogs()
    {
        return $this->belongsToMany(Answerlog::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    } 
}
