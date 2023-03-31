<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
        
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
