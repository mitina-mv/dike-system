<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'answer_name',
        'answer_status',
        'question_id',
    ];
    public $timestamps = false;

    public function answerlogs()
    {
        return $this->belongsToMany(Answerlog::class);
    }

    public function question()
    {
        return $this->hasOne(Question::class);
    } 
}
