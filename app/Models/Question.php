<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'question_private',
        'question_text',
        'question_settings',
        'org_id',
        'user_id',
        'discipline_id',
        'mark'
    ];
    public $timestamps = false;
        
    public function user()
    {
        return $this->hasOne(User::class);
    }  

    public function org()
    {
        return $this->hasOne(Org::class);
    } 

    public function discipline()
    {
        return $this->hasOne(Discipline::class);
    } 

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    } 
}
