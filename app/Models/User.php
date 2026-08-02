<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role'
])]

#[Hidden([
    'password',
    'remember_token'
])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;


    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }


    public function guardProfile()
    {
        return $this->hasOne(Guard::class);
    }


    public function parentProfile()
    {
        return $this->hasOne(ParentProfile::class);
    }


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}