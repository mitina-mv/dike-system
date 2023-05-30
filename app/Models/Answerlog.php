<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answerlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'testlog_id',
        'answerlog_mark'
    ];
    
    public function question()
    {
        return $this->hasOne(Question::class, 'id', 'question_id');
    } 

    public function testlog()
    {
        return $this->hasOne(Testlog::class);
    } 
}
