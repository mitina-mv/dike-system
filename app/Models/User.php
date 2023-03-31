<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_firstname',
        'user_lastname',
        'user_patronymic',
        'user_email',
        'user_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class);
    }

    public function studgroups()
    {
        return $this->belongsToMany(Studgroup::class);
    }

    public function org()
    {
        return $this->belongsTo(Org::class);
    } 

    public function role()
    {
        return $this->belongsTo(Role::class);
    } 

    public function studgroup()
    {
        return $this->belongsTo(Studgroup::class);
    } 
}
