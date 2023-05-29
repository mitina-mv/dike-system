<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studgroup extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_studgroup');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'studgroup_id', 'id');
    }

    public function org()
    {
        return $this->hasOne(Org::class);
    } 
}
