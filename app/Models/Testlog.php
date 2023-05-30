<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'testlog_date',
        'testlog_mark',
        'testlog_time',
        'user_id',
        'test_id',
        'teacher_id',
        'uncorrect_answers',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id', 'id');
    }

    public function answerlogs()
    {
        return $this->hasMany(Answerlog::class, 'testlog_id', 'id');
    }
}
