<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'test_description',
        'test_settings',
        'test_name',
        'org_id',
        'user_id',
        'discipline_id'
    ];
    public $timestamps = true;

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

    public function questionCount()
    {
        return isset($this->test_settings) ? json_decode($this->test_settings)->question_count : 0;
    }
}
