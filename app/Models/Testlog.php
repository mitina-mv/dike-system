<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testlog extends Model
{
    use HasFactory;
    
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function test()
    {
        return $this->hasOne(Test::class);
    }
}
