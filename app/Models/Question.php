<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'question_private',
        'question_text',
        'question_settings',
        'org_id',
        'user_id',
        'discipline_id',
    ];
        
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
}
